@extends('layouts.app')

@section('title', 'Xuất dữ liệu vi phạm')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.violations.index') }}">Quản lý vi phạm</a></li>
                        <li class="breadcrumb-item active">Xuất dữ liệu</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0">Xuất dữ liệu vi phạm giao thông</h1>
                <p class="text-muted mb-0">Chọn các tiêu chí lọc và định dạng file để xuất</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.violations.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Filter Options -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Bộ lọc dữ liệu</h5>
                </div>
                <div class="card-body">
                    <form id="exportForm" method="GET" action="{{ route('admin.violations.export') }}">
                        <!-- Date Range -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt me-1"></i>Khoảng thời gian vi phạm
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Từ ngày</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                       value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Đến ngày</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                       value="{{ request('end_date') }}">
                            </div>
                        </div>

                        <!-- Quick Date Selection -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">Chọn nhanh:</label>
                                <div class="btn-group flex-wrap" role="group">
                                    <button type="button" class="btn btn-outline-secondary btn-sm quick-date" data-range="today">
                                        Hôm nay
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm quick-date" data-range="yesterday">
                                        Hôm qua
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm quick-date" data-range="this_week">
                                        Tuần này
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm quick-date" data-range="last_week">
                                        Tuần trước
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm quick-date" data-range="this_month">
                                        Tháng này
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm quick-date" data-range="last_month">
                                        Tháng trước
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm quick-date" data-range="this_year">
                                        Năm nay
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm quick-date" data-range="all">
                                        Tất cả
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Export Format -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-file-export me-1"></i>Định dạng xuất
                                </label>
                            </div>
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check export-format-option">
                                            <input class="form-check-input" type="radio" name="format" 
                                                   id="formatCsv" value="csv" checked>
                                            <label class="form-check-label export-format-card" for="formatCsv">
                                                <div class="d-flex align-items-center">
                                                    <div class="format-icon text-success me-3">
                                                        <i class="fas fa-file-csv fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <strong>CSV</strong>
                                                        <small class="d-block text-muted">Comma Separated Values</small>
                                                        <small class="text-muted">Tương thích với nhiều ứng dụng</small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check export-format-option">
                                            <input class="form-check-input" type="radio" name="format" 
                                                   id="formatExcel" value="excel">
                                            <label class="form-check-label export-format-card" for="formatExcel">
                                                <div class="d-flex align-items-center">
                                                    <div class="format-icon text-success me-3" style="color: #217346 !important;">
                                                        <i class="fas fa-file-excel fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <strong>Excel</strong>
                                                        <small class="d-block text-muted">Microsoft Excel (.xlsx)</small>
                                                        <small class="text-muted">Định dạng bảng tính chuyên nghiệp</small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview & Export -->
        <div class="col-lg-4">
            <!-- Preview Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Xem trước</h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-3">
                        <div class="display-4 fw-bold text-primary" id="previewCount">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                        <p class="text-muted mb-0">Bản ghi sẽ được xuất</p>
                    </div>
                    
                    <hr>
                    
                    <div class="small">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Định dạng:</span>
                            <span id="previewFormat" class="fw-bold">CSV</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Từ ngày:</span>
                            <span id="previewStartDate" class="fw-bold">Tất cả</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Đến ngày:</span>
                            <span id="previewEndDate" class="fw-bold">Tất cả</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Button -->
            <div class="card border-success">
                <div class="card-body">
                    <button type="submit" form="exportForm" class="btn btn-success btn-lg w-100" id="btnExport">
                        <i class="fas fa-download me-2"></i>Tải xuống
                    </button>
                    <p class="text-muted small text-center mt-2 mb-0">
                        File sẽ được tải về máy của bạn
                    </p>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card mt-4 bg-light">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-lightbulb text-warning me-1"></i>Gợi ý
                    </h6>
                    <ul class="small mb-0 ps-3">
                        <li>Chọn khoảng thời gian để giới hạn dữ liệu xuất</li>
                        <li>Sử dụng <strong>CSV</strong> nếu cần nhập vào hệ thống khác</li>
                        <li>Sử dụng <strong>Excel</strong> nếu cần định dạng và báo cáo</li>
                        <li>File CSV hỗ trợ tiếng Việt khi mở bằng Excel</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .export-format-option {
        padding: 0;
    }
    .export-format-option .form-check-input {
        display: none;
    }
    .export-format-card {
        display: block;
        padding: 1rem;
        border: 2px solid #dee2e6;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .export-format-card:hover {
        border-color: #0d6efd;
        background-color: #f8f9fa;
    }
    .export-format-option .form-check-input:checked + .export-format-card {
        border-color: #198754;
        background-color: #d1e7dd;
    }
    .quick-date {
        margin: 2px;
    }
    .quick-date.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const formatInputs = document.querySelectorAll('input[name="format"]');
    const quickDateButtons = document.querySelectorAll('.quick-date');
    const previewCount = document.getElementById('previewCount');
    const previewFormat = document.getElementById('previewFormat');
    const previewStartDate = document.getElementById('previewStartDate');
    const previewEndDate = document.getElementById('previewEndDate');
    const btnExport = document.getElementById('btnExport');

    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Format date for display
    function formatDate(dateStr) {
        if (!dateStr) return 'Tất cả';
        const date = new Date(dateStr);
        return date.toLocaleDateString('vi-VN');
    }

    // Update preview
    function updatePreview() {
        // Update format
        const selectedFormat = document.querySelector('input[name="format"]:checked');
        previewFormat.textContent = selectedFormat.value === 'csv' ? 'CSV' : 'Excel (.xlsx)';

        // Update dates
        previewStartDate.textContent = formatDate(startDateInput.value);
        previewEndDate.textContent = formatDate(endDateInput.value);

        // Fetch count
        fetchCount();
    }

    // Fetch count from server
    const fetchCount = debounce(function() {
        previewCount.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        const params = new URLSearchParams();
        if (startDateInput.value) params.append('start_date', startDateInput.value);
        if (endDateInput.value) params.append('end_date', endDateInput.value);

        fetch('{{ route("admin.violations.export.count") }}?' + params.toString())
            .then(response => response.json())
            .then(data => {
                previewCount.textContent = data.count.toLocaleString('vi-VN');
                btnExport.disabled = data.count === 0;
            })
            .catch(() => {
                previewCount.textContent = '?';
            });
    }, 300);

    // Quick date selection
    function getDateRange(range) {
        const today = new Date();
        let start, end;

        switch (range) {
            case 'today':
                start = end = today;
                break;
            case 'yesterday':
                const yesterday = new Date(today);
                yesterday.setDate(yesterday.getDate() - 1);
                start = end = yesterday;
                break;
            case 'this_week':
                start = new Date(today);
                start.setDate(today.getDate() - today.getDay() + 1); // Monday
                end = today;
                break;
            case 'last_week':
                start = new Date(today);
                start.setDate(today.getDate() - today.getDay() - 6); // Last Monday
                end = new Date(today);
                end.setDate(today.getDate() - today.getDay()); // Last Sunday
                break;
            case 'this_month':
                start = new Date(today.getFullYear(), today.getMonth(), 1);
                end = today;
                break;
            case 'last_month':
                start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                end = new Date(today.getFullYear(), today.getMonth(), 0);
                break;
            case 'this_year':
                start = new Date(today.getFullYear(), 0, 1);
                end = today;
                break;
            case 'all':
                start = null;
                end = null;
                break;
        }

        return { start, end };
    }

    function formatDateForInput(date) {
        if (!date) return '';
        return date.toISOString().split('T')[0];
    }

    // Event listeners
    quickDateButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            quickDateButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const range = this.dataset.range;
            const { start, end } = getDateRange(range);

            startDateInput.value = formatDateForInput(start);
            endDateInput.value = formatDateForInput(end);

            updatePreview();
        });
    });

    startDateInput.addEventListener('change', function() {
        quickDateButtons.forEach(b => b.classList.remove('active'));
        updatePreview();
    });

    endDateInput.addEventListener('change', function() {
        quickDateButtons.forEach(b => b.classList.remove('active'));
        updatePreview();
    });

    formatInputs.forEach(input => {
        input.addEventListener('change', updatePreview);
    });

    // Form submit handling
    document.getElementById('exportForm').addEventListener('submit', function(e) {
        btnExport.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xuất...';
        btnExport.disabled = true;

        setTimeout(() => {
            btnExport.innerHTML = '<i class="fas fa-download me-2"></i>Tải xuống';
            btnExport.disabled = false;
        }, 3000);
    });

    // Initial load
    updatePreview();
});
</script>
@endpush
