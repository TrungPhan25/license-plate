@extends('layouts.app')

@section('title', 'Chi tiết người dùng')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0">Chi tiết người dùng</h1>
                <p class="text-muted mb-0">Thông tin chi tiết của {{ $user->name }}</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Quay lại
                </a>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i>
                    Chỉnh sửa
                </a>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="row">
        <!-- User Profile Card -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" 
                             class="rounded-circle mb-3" width="120" height="120" style="object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 120px; height: 120px;">
                            <i class="fas fa-user fa-3x text-white"></i>
                        </div>
                    @endif
                    
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="mb-3">
                        @if($user->is_active)
                            <span class="badge bg-success fs-6">Hoạt động</span>
                        @else
                            <span class="badge bg-warning text-dark fs-6">Không hoạt động</span>
                        @endif
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i>Chỉnh sửa
                        </a>
                        @if($user->is_active)
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100" 
                                        onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                    <i class="fas fa-trash me-1"></i>Xóa người dùng
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- User Details -->
        <div class="col-lg-8">
            <div class="row">
                <!-- Personal Information -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin cá nhân</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Họ tên</label>
                                    <p class="fw-semibold">{{ $user->name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Email</label>
                                    <p class="fw-semibold">{{ $user->email }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Số điện thoại</label>
                                    <p class="fw-semibold">{{ $user->phone ?? 'Chưa cập nhật' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Trạng thái</label>
                                    <p>
                                        @if($user->is_active)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Không hoạt động</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label text-muted">Địa chỉ</label>
                                    <p class="fw-semibold">{{ $user->address ?? 'Chưa cập nhật' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin tài khoản</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">ID người dùng</label>
                                    <p class="fw-semibold">#{{ $user->id }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Ngày tạo</label>
                                    <p class="fw-semibold">{{ $user->created_at->format('d/m/Y H:i:s') }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Cập nhật lần cuối</label>
                                    <p class="fw-semibold">{{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
                                </div>
                                @if($user->email_verified_at)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">Email đã xác thực</label>
                                        <p class="fw-semibold">
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                {{ $user->email_verified_at->format('d/m/Y H:i:s') }}
                                            </span>
                                        </p>
                                    </div>
                                @else
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">Email chưa xác thực</label>
                                        <p class="fw-semibold">
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                Chưa xác thực
                                            </span>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Log (if needed) -->
                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Hoạt động gần đây</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center py-3">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Chức năng theo dõi hoạt động sẽ được cập nhật trong phiên bản tới.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>
@endpush
