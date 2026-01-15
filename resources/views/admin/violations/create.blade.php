@extends('layouts.app')

@section('title', 'Thêm vi phạm')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0">Thêm vi phạm giao thông</h1>
                <p class="text-muted mb-0">Tạo mới thông tin vi phạm giao thông</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.violations.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Quay lại
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-8 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin vi phạm</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.violations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="violation_date" class="form-label">Ngày vi phạm <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('violation_date') is-invalid @enderror" 
                                           id="violation_date" name="violation_date" value="{{ old('violation_date') }}" required>
                                    @error('violation_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="license_plate" class="form-label">Biển số xe <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('license_plate') is-invalid @enderror" 
                                           id="license_plate" name="license_plate" value="{{ old('license_plate') }}" 
                                           placeholder="Ví dụ: 59A-123.45" required>
                                    @error('license_plate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                           id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="birth_year" class="form-label">Năm sinh <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('birth_year') is-invalid @enderror" 
                                           id="birth_year" name="birth_year" value="{{ old('birth_year') }}" 
                                           min="1900" max="{{ date('Y') }}" required>
                                    @error('birth_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="violation_type" class="form-label">Lỗi vi phạm <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('violation_type') is-invalid @enderror" 
                                      id="violation_type" name="violation_type" rows="3" 
                                      placeholder="Mô tả chi tiết lỗi vi phạm..." required>{{ old('violation_type') }}</textarea>
                            @error('violation_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh vi phạm</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif">
                            <small class="form-text text-muted">Chấp nhận định dạng: JPEG, PNG, JPG, GIF. Tối đa 2MB.</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="image-preview" class="mt-2" style="display: none;">
                                <img src="" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.violations.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Lưu vi phạm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Hướng dẫn</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <strong>Ngày vi phạm:</strong> Không được là ngày tương lai
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-car text-success me-2"></i>
                            <strong>Biển số xe:</strong> Định dạng VN (Ví dụ: 59A-123.45)
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-birthday-cake text-info me-2"></i>
                            <strong>Năm sinh:</strong> Từ 1900 đến năm hiện tại
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                            <strong>Lỗi vi phạm:</strong> Mô tả chi tiết và rõ ràng
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Các lỗi vi phạm thường gặp</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm violation-preset" 
                                data-violation="Vượt đèn đỏ">Vượt đèn đỏ</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm violation-preset" 
                                data-violation="Chạy quá tốc độ quy định">Quá tốc độ</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm violation-preset" 
                                data-violation="Không đội mũ bảo hiểm">Không đội mũ bảo hiểm</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm violation-preset" 
                                data-violation="Dừng xe sai quy định">Dừng xe sai quy định</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Set today as max date for violation_date
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('violation_date').setAttribute('max', today);
        
        // Preset violation types
        document.querySelectorAll('.violation-preset').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('violation_type').value = this.dataset.violation;
            });
        });
        
        // Format license plate input
        document.getElementById('license_plate').addEventListener('input', function() {
            let value = this.value.toUpperCase();
            // Remove any characters that aren't digits, letters, dash, or dot
            value = value.replace(/[^0-9A-Z.-]/g, '');
            this.value = value;
        });

        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('image-preview');
            const img = preview.querySelector('img');
            
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    img.src = event.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(e.target.files[0]);
            } else {
                preview.style.display = 'none';
                img.src = '';
            }
        });
    });
</script>
@endpush
