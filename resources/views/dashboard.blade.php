@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- This file has been moved to pages/dashboard.blade.php --}}
    {{-- Redirecting to the new structure --}}
    @include('pages.dashboard')
@endsection
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-car-front text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Tổng biển số</h6>
                            <h3 class="mb-0">1,234</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Đã xác nhận</h6>
                            <h3 class="mb-0">856</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="bi bi-clock text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Chờ xử lý</h6>
                            <h3 class="mb-0">378</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="bi bi-camera text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Camera hoạt động</h6>
                            <h3 class="mb-0">12</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Recent Activity -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Hoạt động gần đây</span>
                    <a href="#" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Biển số</th>
                                    <th>Thời gian</th>
                                    <th>Camera</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>30A-12345</strong></td>
                                    <td>14/01/2026 10:30</td>
                                    <td>Camera 1 - Cổng vào</td>
                                    <td><span class="badge bg-success">Đã xác nhận</span></td>
                                </tr>
                                <tr>
                                    <td><strong>29B-67890</strong></td>
                                    <td>14/01/2026 10:25</td>
                                    <td>Camera 2 - Cổng ra</td>
                                    <td><span class="badge bg-success">Đã xác nhận</span></td>
                                </tr>
                                <tr>
                                    <td><strong>51F-11111</strong></td>
                                    <td>14/01/2026 10:20</td>
                                    <td>Camera 1 - Cổng vào</td>
                                    <td><span class="badge bg-warning text-dark">Chờ xử lý</span></td>
                                </tr>
                                <tr>
                                    <td><strong>43A-22222</strong></td>
                                    <td>14/01/2026 10:15</td>
                                    <td>Camera 3 - Bãi đỗ</td>
                                    <td><span class="badge bg-success">Đã xác nhận</span></td>
                                </tr>
                                <tr>
                                    <td><strong>30E-33333</strong></td>
                                    <td>14/01/2026 10:10</td>
                                    <td>Camera 1 - Cổng vào</td>
                                    <td><span class="badge bg-danger">Lỗi nhận dạng</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    Thao tác nhanh
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Thêm biển số mới
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="bi bi-camera me-2"></i>
                            Quản lý Camera
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="bi bi-download me-2"></i>
                            Xuất báo cáo
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="bi bi-gear me-2"></i>
                            Cài đặt hệ thống
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
