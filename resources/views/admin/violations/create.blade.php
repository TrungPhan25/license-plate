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
                            
                            <!-- Async Upload Area -->
                            <div id="upload-area" class="border border-2 border-dashed rounded p-4 text-center" style="cursor: pointer;">
                                <div id="upload-placeholder">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                    <p class="mb-1">Kéo thả ảnh vào đây hoặc click để chọn</p>
                                    <small class="text-muted">Chấp nhận: JPEG, PNG, JPG, GIF. Tối đa 10MB.</small>
                                </div>
                                <div id="upload-progress" class="d-none">
                                    <div class="spinner-border text-primary mb-2" role="status">
                                        <span class="visually-hidden">Đang upload...</span>
                                    </div>
                                    <p class="mb-0">Đang upload và nén ảnh...</p>
                                </div>
                            </div>
                            
                            <input type="file" id="image-file" accept="image/jpeg,image/png,image/jpg,image/gif" class="d-none">
                            <input type="hidden" name="image_path" id="image-path" value="{{ old('image_path') }}">
                            
                            @error('image_path')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            
                            <!-- Preview -->
                            <div id="image-preview" class="mt-3 position-relative" style="display: none;">
                                <img src="" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                                <button type="button" id="remove-image" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div id="image-info" class="small text-success mt-1"></div>
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

        // ===== ASYNC IMAGE UPLOAD =====
        const uploadArea = document.getElementById('upload-area');
        const uploadPlaceholder = document.getElementById('upload-placeholder');
        const uploadProgress = document.getElementById('upload-progress');
        const imageFile = document.getElementById('image-file');
        const imagePath = document.getElementById('image-path');
        const imagePreview = document.getElementById('image-preview');
        const previewImg = imagePreview.querySelector('img');
        const removeBtn = document.getElementById('remove-image');
        const imageInfo = document.getElementById('image-info');

        // Click to select file
        uploadArea.addEventListener('click', () => imageFile.click());

        // Drag & Drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('border-primary', 'bg-light');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('border-primary', 'bg-light');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('border-primary', 'bg-light');
            if (e.dataTransfer.files.length) {
                handleFileUpload(e.dataTransfer.files[0]);
            }
        });

        // File input change
        imageFile.addEventListener('change', (e) => {
            if (e.target.files.length) {
                handleFileUpload(e.target.files[0]);
            }
        });

        // Upload file
        async function handleFileUpload(file) {
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                alert('Chỉ chấp nhận định dạng: JPEG, PNG, JPG, GIF.');
                return;
            }

            // Validate file size (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('Dung lượng ảnh tối đa 10MB.');
                return;
            }

            // Show progress
            uploadPlaceholder.classList.add('d-none');
            uploadProgress.classList.remove('d-none');

            const formData = new FormData();
            formData.append('image', file);

            try {
                const response = await fetch('{{ route("admin.upload.image") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    // Save path to hidden input
                    imagePath.value = data.path;
                    
                    // Show preview
                    previewImg.src = data.url;
                    imagePreview.style.display = 'block';
                    uploadArea.style.display = 'none';
                    
                    // Show compression info
                    const originalKB = Math.round(data.original_size / 1024);
                    const compressedKB = Math.round(data.size / 1024);
                    const savedPercent = Math.round((1 - data.size / data.original_size) * 100);
                    imageInfo.innerHTML = `<i class="fas fa-check-circle"></i> Đã nén: ${originalKB}KB → ${compressedKB}KB (giảm ${savedPercent}%)`;
                } else {
                    alert(data.message || 'Không thể upload ảnh.');
                }
            } catch (error) {
                console.error('Upload error:', error);
                alert('Lỗi khi upload ảnh. Vui lòng thử lại.');
            } finally {
                uploadPlaceholder.classList.remove('d-none');
                uploadProgress.classList.add('d-none');
            }
        }

        // Remove image
        removeBtn.addEventListener('click', async () => {
            const path = imagePath.value;
            
            if (path) {
                try {
                    await fetch('{{ route("admin.upload.image.delete") }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ path: path })
                    });
                } catch (e) {
                    console.error('Delete error:', e);
                }
            }

            // Reset UI
            imagePath.value = '';
            previewImg.src = '';
            imagePreview.style.display = 'none';
            uploadArea.style.display = 'block';
            imageFile.value = '';
        });
    });
</script>
@endpush
