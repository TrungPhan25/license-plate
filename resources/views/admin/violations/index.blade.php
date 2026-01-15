@extends('layouts.app')

@section('title', 'Quản lý vi phạm giao thông')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0">Quản lý vi phạm giao thông</h1>
                <p class="text-muted mb-0">Danh sách tất cả lỗi vi phạm giao thông</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.violations.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Thêm vi phạm
                </a>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.violations.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Biển số xe, họ tên...">
                        </div>
                        <div class="col-md-2">
                            <label for="start_date" class="form-label">Từ ngày</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="end_date" class="form-label">Đến ngày</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search me-1"></i>Tìm kiếm
                            </button>
                            <a href="{{ route('admin.violations.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-undo me-1"></i>Reset
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.violations.trash') }}" class="btn btn-outline-danger">
                                <i class="fas fa-trash me-1"></i>Đã xóa ({{ \App\Models\Violation::onlyTrashed()->count() }})
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Violations List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Danh sách vi phạm ({{ $violations->total() }})</h5>
                </div>
                <div class="card-body">
                    @if($violations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>STT</th>
                                        <th>Ngày vi phạm</th>
                                        <th>Biển số xe</th>
                                        <th>Họ và tên</th>
                                        <th>Năm sinh</th>
                                        <th>Lỗi vi phạm</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($violations as $index => $violation)
                                        <tr>
                                            <td><strong>{{ $violations->firstItem() + $index }}</strong></td>
                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    {{ $violation->violation_date->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark font-monospace">
                                                    {{ $violation->license_plate }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>{{ $violation->full_name }}</strong>
                                            </td>
                                            <td>
                                                {{ $violation->birth_year }}
                                                <small class="text-muted">({{ $violation->age }} tuổi)</small>
                                            </td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                                      title="{{ $violation->violation_type }}">
                                                    {{ $violation->violation_type }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.violations.show', $violation) }}" 
                                                       class="btn btn-outline-info" title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.violations.edit', $violation) }}" 
                                                       class="btn btn-outline-primary" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.violations.destroy', $violation) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" 
                                                                onclick="return confirm('Bạn có chắc muốn xóa vi phạm này?')" 
                                                                title="Xóa">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($violations->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $violations->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-exclamation-triangle fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Không có dữ liệu</h5>
                            <p class="text-muted">Chưa có vi phạm nào trong hệ thống.</p>
                            <a href="{{ route('admin.violations.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Thêm vi phạm đầu tiên
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .btn-group-sm .btn {
        padding: 0.25rem 0.4rem;
        font-size: 0.75rem;
    }
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endpush
