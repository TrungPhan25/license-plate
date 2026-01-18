<?php

namespace App\Services;

use App\Models\Violation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ViolationExportService
{
    /**
     * Column headers for export
     */
    protected array $headers = [
        'STT',
        'Ngày vi phạm',
        'Biển số xe',
        'Họ và tên',
        'Ngày sinh',
        'Tuổi',
        'Địa chỉ',
        'Lỗi vi phạm',
        'Ngày tạo',
    ];

    /**
     * Build query with filters from request
     */
    protected function buildQuery(Request $request): Builder
    {
        $query = Violation::query();

        // Date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('violation_date', [
                $request->get('start_date'),
                $request->get('end_date'),
            ]);
        } elseif ($request->filled('start_date')) {
            $query->where('violation_date', '>=', $request->get('start_date'));
        } elseif ($request->filled('end_date')) {
            $query->where('violation_date', '<=', $request->get('end_date'));
        }

        return $query->orderBy('violation_date', 'desc');
    }

    /**
     * Get violations data for export
     */
    protected function getViolationsData(Request $request): array
    {
        $violations = $this->buildQuery($request)->get();

        $data = [];
        $index = 1;

        foreach ($violations as $violation) {
            $data[] = [
                $index++,
                $violation->violation_date->format('d/m/Y'),
                $violation->license_plate,
                $violation->full_name,
                $violation->birth_date?->format('d/m/Y'),
                $violation->age,
                $violation->address,
                $violation->violation_type,
                $violation->created_at->format('d/m/Y H:i:s'),
            ];
        }

        return $data;
    }

    /**
     * Export to CSV format
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $data = $this->getViolationsData($request);
        $filename = 'vi_pham_giao_thong_' . date('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($data) {
            $handle = fopen('php://output', 'w');

            // Add BOM for UTF-8 Excel compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Add headers
            fputcsv($handle, $this->headers);

            // Add data rows
            foreach ($data as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Export to Excel format (using PhpSpreadsheet-compatible XML)
     */
    public function exportExcel(Request $request): StreamedResponse
    {
        $data = $this->getViolationsData($request);
        $filename = 'vi_pham_giao_thong_' . date('Y-m-d_His') . '.xlsx';

        return response()->streamDownload(function () use ($data) {
            $this->generateExcelXml($data);
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Generate Excel-compatible XML (SpreadsheetML)
     */
    protected function generateExcelXml(array $data): void
    {
        // Using HTML table format that Excel can read
        echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #4472C4; color: white; font-weight: bold; }
        tr:nth-child(even) { background-color: #D9E2F3; }
    </style>
</head>
<body>
<table>';

        // Headers
        echo '<tr>';
        foreach ($this->headers as $header) {
            echo '<th>' . htmlspecialchars($header) . '</th>';
        }
        echo '</tr>';

        // Data rows
        foreach ($data as $row) {
            echo '<tr>';
            foreach ($row as $cell) {
                echo '<td>' . htmlspecialchars((string) $cell) . '</td>';
            }
            echo '</tr>';
        }

        echo '</table></body></html>';
    }

    /**
     * Export to native Excel format (.xlsx) using ZipArchive
     */
    public function exportNativeExcel(Request $request): StreamedResponse
    {
        $data = $this->getViolationsData($request);
        $filename = 'vi_pham_giao_thong_' . date('Y-m-d_His') . '.xlsx';

        return response()->streamDownload(function () use ($data) {
            $this->createXlsx($data);
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Create native XLSX file
     */
    protected function createXlsx(array $data): void
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'xlsx_');

        $zip = new \ZipArchive();
        $zip->open($tempFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        // [Content_Types].xml
        $zip->addFromString('[Content_Types].xml', $this->getContentTypes());

        // _rels/.rels
        $zip->addFromString('_rels/.rels', $this->getRels());

        // xl/workbook.xml
        $zip->addFromString('xl/workbook.xml', $this->getWorkbook());

        // xl/_rels/workbook.xml.rels
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->getWorkbookRels());

        // xl/styles.xml
        $zip->addFromString('xl/styles.xml', $this->getStyles());

        // xl/sharedStrings.xml
        $allStrings = [];
        foreach ($this->headers as $header) {
            $allStrings[] = $header;
        }
        foreach ($data as $row) {
            foreach ($row as $cell) {
                if (!is_numeric($cell)) {
                    $allStrings[] = (string) $cell;
                }
            }
        }
        $uniqueStrings = array_values(array_unique($allStrings));
        $stringIndexes = array_flip($uniqueStrings);
        $zip->addFromString('xl/sharedStrings.xml', $this->getSharedStrings($uniqueStrings));

        // xl/worksheets/sheet1.xml
        $zip->addFromString('xl/worksheets/sheet1.xml', $this->getSheet($data, $stringIndexes));

        $zip->close();

        readfile($tempFile);
        unlink($tempFile);
    }

    protected function getContentTypes(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
    <Default Extension="xml" ContentType="application/xml"/>
    <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
    <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
    <Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>
    <Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>
</Types>';
    }

    protected function getRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>';
    }

    protected function getWorkbook(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
    <sheets>
        <sheet name="Vi phạm giao thông" sheetId="1" r:id="rId1"/>
    </sheets>
</workbook>';
    }

    protected function getWorkbookRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
    <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
    <Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>
</Relationships>';
    }

    protected function getStyles(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
    <fonts count="2">
        <font><sz val="11"/><name val="Calibri"/></font>
        <font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>
    </fonts>
    <fills count="3">
        <fill><patternFill patternType="none"/></fill>
        <fill><patternFill patternType="gray125"/></fill>
        <fill><patternFill patternType="solid"><fgColor rgb="FF4472C4"/></patternFill></fill>
    </fills>
    <borders count="2">
        <border/>
        <border>
            <left style="thin"><color auto="1"/></left>
            <right style="thin"><color auto="1"/></right>
            <top style="thin"><color auto="1"/></top>
            <bottom style="thin"><color auto="1"/></bottom>
        </border>
    </borders>
    <cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>
    <cellXfs count="3">
        <xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>
        <xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1">
            <alignment horizontal="center" vertical="center"/>
        </xf>
        <xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1"/>
    </cellXfs>
</styleSheet>';
    }

    protected function getSharedStrings(array $strings): string
    {
        $count = count($strings);
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="' . $count . '" uniqueCount="' . $count . '">';

        foreach ($strings as $string) {
            $xml .= '<si><t>' . htmlspecialchars((string) $string) . '</t></si>';
        }

        $xml .= '</sst>';
        return $xml;
    }

    protected function getSheet(array $data, array $stringIndexes): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
    <sheetData>';

        // Header row
        $xml .= '<row r="1">';
        $col = 0;
        foreach ($this->headers as $header) {
            $colLetter = $this->getColumnLetter($col);
            $stringIndex = $stringIndexes[$header];
            $xml .= '<c r="' . $colLetter . '1" s="1" t="s"><v>' . $stringIndex . '</v></c>';
            $col++;
        }
        $xml .= '</row>';

        // Data rows
        $rowNum = 2;
        foreach ($data as $row) {
            $xml .= '<row r="' . $rowNum . '">';
            $col = 0;
            foreach ($row as $cell) {
                $colLetter = $this->getColumnLetter($col);
                $cellRef = $colLetter . $rowNum;

                if (is_numeric($cell)) {
                    $xml .= '<c r="' . $cellRef . '" s="2"><v>' . $cell . '</v></c>';
                } else {
                    $stringIndex = $stringIndexes[(string) $cell] ?? 0;
                    $xml .= '<c r="' . $cellRef . '" s="2" t="s"><v>' . $stringIndex . '</v></c>';
                }
                $col++;
            }
            $xml .= '</row>';
            $rowNum++;
        }

        $xml .= '</sheetData></worksheet>';
        return $xml;
    }

    protected function getColumnLetter(int $index): string
    {
        $letter = '';
        while ($index >= 0) {
            $letter = chr(65 + ($index % 26)) . $letter;
            $index = intdiv($index, 26) - 1;
        }
        return $letter;
    }

    /**
     * Get total count of violations based on current filters
     */
    public function getCount(Request $request): int
    {
        return $this->buildQuery($request)->count();
    }
}
