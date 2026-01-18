@extends('layouts.app')

@section('title', 'Chi tiết vi phạm')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0">Chi tiết vi phạm giao thông</h1>
                <p class="text-muted mb-0">Thông tin chi tiết vi phạm: {{ $violation->license_plate }}</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.violations.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Quay lại
                </a>
                <a href="{{ route('admin.violations.edit', $violation) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i>
                    Chỉnh sửa
                </a>
            </div>
        </div>
    </div>

    <!-- Violation Details -->
    <div class="row">
        <!-- Main Information Card -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin vi phạm</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Ngày vi phạm</label>
                            <p class="fw-semibold">
                                <span class="badge bg-info fs-6">
                                    {{ $violation->violation_date->format('d/m/Y') }}
                                </span>
                                <small class="text-muted ms-2">
                                    ({{ $violation->violation_date->diffForHumans() }})
                                </small>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Biển số xe</label>
                            <p class="fw-semibold">
                                <span class="badge bg-light text-dark fs-6 font-monospace">
                                    {{ $violation->license_plate }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label text-muted">Họ và tên</label>
                            <p class="fw-semibold fs-5">{{ $violation->full_name }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Năm sinh</label>
                            <p class="fw-semibold">{{ $violation->birth_year }} <small class="text-muted">({{ $violation->age }} tuổi)</small></p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted">Địa chỉ</label>
                            <p class="fw-semibold">{{ $violation->address }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted">Lỗi vi phạm</label>
                            <div class="alert alert-warning alert-permanent">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ $violation->violation_type }}
                            </div>
                        </div>
                        @if($violation->image)
                        <div class="col-12">
                            <label class="form-label text-muted">Hình ảnh vi phạm</label>
                            <div>
                                <a href="{{ Storage::url($violation->image) }}" target="_blank">
                                    <img src="{{ Storage::url($violation->image) }}" alt="Hình ảnh vi phạm" class="img-fluid img-thumbnail" style="max-height: 300px;">
                                </a>
                                <p class="text-muted small mt-1">Nhấn vào ảnh để xem kích thước đầy đủ</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Side Information -->
        <div class="col-lg-4">
            <!-- System Information -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Thông tin hệ thống</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <strong>ID vi phạm:</strong><br>
                            <span class="text-muted">#{{ $violation->id }}</span>
                        </li>
                        <li class="mb-2">
                            <strong>Ngày tạo:</strong><br>
                            <span class="text-muted">{{ $violation->created_at->format('d/m/Y H:i:s') }}</span>
                        </li>
                        <li class="mb-2">
                            <strong>Cập nhật lần cuối:</strong><br>
                            <span class="text-muted">{{ $violation->updated_at->format('d/m/Y H:i:s') }}</span>
                        </li>
                        <li>
                            <strong>Trạng thái:</strong><br>
                            <span class="badge bg-success">Hoạt động</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Thao tác</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.violations.edit', $violation) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Chỉnh sửa
                        </a>
                        <button type="button" class="btn btn-outline-info" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>In thông tin
                        </button>
                        <form action="{{ route('admin.violations.destroy', $violation) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100" 
                                    onclick="return confirm('Bạn có chắc muốn xóa vi phạm này?')">
                                <i class="fas fa-trash me-2"></i>Xóa vi phạm
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Thống kê liên quan</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Cùng biển số xe:</small><br>
                        <strong>{{ \App\Models\Violation::where('license_plate', $violation->license_plate)->count() }}</strong> vi phạm
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Cùng tên người vi phạm:</small><br>
                        <strong>{{ \App\Models\Violation::where('full_name', $violation->full_name)->count() }}</strong> vi phạm
                    </div>
                    <div>
                        <small class="text-muted">Trong tháng {{ $violation->violation_date->format('m/Y') }}:</small><br>
                        <strong>{{ \App\Models\Violation::whereYear('violation_date', $violation->violation_date->year)->whereMonth('violation_date', $violation->violation_date->month)->count() }}</strong> vi phạm
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    @media print {
        .btn, .card-header, .page-header {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush
