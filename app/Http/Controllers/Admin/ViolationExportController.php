<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ViolationExportService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ViolationExportController extends Controller
{
    public function __construct(
        protected ViolationExportService $exportService
    ) {}

    /**
     * Show export page with filters
     */
    public function index(): View
    {
        return view('admin.violations.export');
    }

    /**
     * Export violations to the specified format
     */
    public function export(Request $request): StreamedResponse
    {
        $request->validate([
            'format' => 'required|in:csv,excel',
        ]);

        $format = $request->get('format');

        return match ($format) {
            'csv' => $this->exportService->exportCsv($request),
            'excel' => $this->exportService->exportNativeExcel($request),
            default => abort(400, 'Định dạng không hợp lệ'),
        };
    }

    /**
     * Get count of violations to be exported (for preview)
     */
    public function count(Request $request): \Illuminate\Http\JsonResponse
    {
        $count = $this->exportService->getCount($request);

        return response()->json([
            'count' => $count,
            'message' => "Sẽ xuất {$count} bản ghi vi phạm",
        ]);
    }
}
