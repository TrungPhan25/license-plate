@extends('layouts.app')

@section('title', 'Vi phạm đã xóa')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0">Vi phạm đã xóa</h1>
                <p class="text-muted mb-0">Danh sách các vi phạm giao thông đã bị xóa</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.violations.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Quay lại danh sách
                </a>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.violations.trash') }}" class="row g-3">
                        <div class="col-md-6">
                            <label for="search" class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Biển số xe, họ tên...">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search me-1"></i>Tìm kiếm
                            </button>
                            <a href="{{ route('admin.violations.trash') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-undo me-1"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Trash List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Vi phạm đã xóa ({{ $violations->total() }})</h5>
                    @if($violations->total() > 0)
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Các mục ở đây có thể được khôi phục hoặc xóa vĩnh viễn
                        </small>
                    @endif
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
                                        <th>Lỗi vi phạm</th>
                                        <th>Ngày xóa</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($violations as $index => $violation)
                                        <tr class="table-secondary">
                                            <td><strong>{{ $violations->firstItem() + $index }}</strong></td>
                                            <td>
                                                <span class="badge bg-secondary">
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
                                                <br><small class="text-muted">{{ $violation->birth_year }} ({{ $violation->age }} tuổi)</small>
                                            </td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                                      title="{{ $violation->violation_type }}">
                                                    {{ $violation->violation_type }}
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $violation->deleted_at->format('d/m/Y H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <form action="{{ route('admin.violations.restore', $violation->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-outline-success" 
                                                                onclick="return confirm('Bạn có chắc muốn khôi phục vi phạm này?')" 
                                                                title="Khôi phục">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.violations.force-delete', $violation->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" 
                                                                onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn vi phạm này? Hành động này không thể hoàn tác!')" 
                                                                title="Xóa vĩnh viễn">
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
                            <i class="fas fa-trash-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Thùng rác trống</h5>
                            <p class="text-muted">Không có vi phạm nào trong thùng rác.</p>
                            <a href="{{ route('admin.violations.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-1"></i>Quay lại danh sách
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
    .table-secondary {
        background-color: rgba(108, 117, 125, 0.1) !important;
    }
</style>
@endpush
