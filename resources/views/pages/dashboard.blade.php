@extends('layouts.app')

@section('title', 'Tra cứu vi phạm giao thông')

@section('styles')
<style>
    .search-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        padding: 2rem 1.5rem;
        color: white;
        text-align: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
    }
    
    .search-hero h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .search-hero p {
        opacity: 0.9;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }
    
    .search-box {
        position: relative;
        max-width: 500px;
        margin: 0 auto;
    }
    
    .search-box input {
        width: 100%;
        padding: 1rem 1.25rem;
        padding-right: 3.5rem;
        border: none;
        border-radius: 3rem;
        font-size: 1.1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }
    
    .search-box input::placeholder {
        text-transform: none;
        letter-spacing: normal;
        font-weight: 400;
        color: #adb5bd;
    }
    
    .search-box input:focus {
        outline: none;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.2);
    }
    
    .search-box .btn-search {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s ease;
    }
    
    .search-box .btn-search:hover {
        transform: translateY(-50%) scale(1.05);
    }
    
    .search-box .btn-search:active {
        transform: translateY(-50%) scale(0.95);
    }
    
    .search-hint {
        font-size: 0.8rem;
        opacity: 0.8;
        margin-top: 0.75rem;
    }
    
    .search-hint i {
        margin-right: 0.25rem;
    }
    
    /* Results Section */
    .results-section {
        margin-top: 1rem;
    }
    
    .results-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    
    .results-count {
        font-weight: 600;
        color: #495057;
    }
    
    .results-count span {
        color: #667eea;
    }
    
    /* Violation Card */
    .violation-card {
        background: white;
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #dc3545;
        transition: all 0.2s ease;
    }
    
    .violation-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
    }
    
    .violation-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    
    .license-plate-badge {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-family: 'SFMono-Regular', Consolas, monospace;
        font-weight: 700;
        font-size: 1.1rem;
        letter-spacing: 0.05em;
        box-shadow: 0 2px 8px rgba(30, 60, 114, 0.3);
    }
    
    .violation-date {
        font-size: 0.85rem;
        color: #6c757d;
        text-align: right;
    }
    
    .violation-date i {
        margin-right: 0.25rem;
    }
    
    .violation-body {
        display: grid;
        gap: 0.75rem;
    }
    
    .violation-info {
        display: flex;
        align-items: flex-start;
    }
    
    .violation-info .icon {
        width: 32px;
        height: 32px;
        background: #f8f9fa;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        flex-shrink: 0;
        color: #667eea;
    }
    
    .violation-info .content {
        flex: 1;
        min-width: 0;
    }
    
    .violation-info .label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.15rem;
    }
    
    .violation-info .value {
        font-weight: 500;
        color: #212529;
        word-break: break-word;
    }
    
    .violation-type-box {
        background: #fff5f5;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-top: 0.5rem;
    }
    
    .violation-type-box .label {
        font-size: 0.75rem;
        color: #dc3545;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
    }
    
    .violation-type-box .label i {
        margin-right: 0.35rem;
    }
    
    .violation-type-box .value {
        font-weight: 500;
        color: #842029;
        line-height: 1.5;
    }
    
    /* Violation Image */
    .violation-image-box {
        margin-top: 0.75rem;
        border-radius: 0.75rem;
        overflow: hidden;
        background: #f8f9fa;
    }
    
    .violation-image-box .label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.75rem 1rem 0.5rem;
        display: flex;
        align-items: center;
    }
    
    .violation-image-box .label i {
        margin-right: 0.35rem;
        color: #667eea;
    }
    
    .violation-image-box .image-container {
        position: relative;
        width: 100%;
        cursor: pointer;
    }
    
    .violation-image-box .image-container img {
        width: 100%;
        height: auto;
        max-height: 250px;
        object-fit: cover;
        display: block;
    }
    
    .violation-image-box .image-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.6));
        color: white;
        padding: 1rem;
        font-size: 0.8rem;
        text-align: center;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    
    .violation-image-box .image-container:hover .image-overlay {
        opacity: 1;
    }
    
    /* Image Modal for Mobile */
    .image-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.9);
        z-index: 9999;
        padding: 1rem;
        align-items: center;
        justify-content: center;
    }
    
    .image-modal.show {
        display: flex;
    }
    
    .image-modal img {
        max-width: 100%;
        max-height: 90vh;
        object-fit: contain;
        border-radius: 0.5rem;
    }
    
    .image-modal .close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 44px;
        height: 44px;
        background: rgba(255,255,255,0.2);
        border: none;
        border-radius: 50%;
        color: white;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }
    
    .empty-state .icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 2rem;
    }
    
    .empty-state.no-result .icon {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    }
    
    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #212529;
    }
    
    .empty-state p {
        color: #6c757d;
        margin-bottom: 0;
    }
    
    /* Welcome State */
    .welcome-state {
        text-align: center;
        padding: 2rem 1.5rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }
    
    .welcome-state .icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 1.75rem;
    }
    
    .welcome-state h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #212529;
    }
    
    .welcome-state p {
        color: #6c757d;
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    
    /* Loading State */
    .loading-spinner {
        display: none;
        text-align: center;
        padding: 2rem;
    }
    
    .loading-spinner.show {
        display: block;
    }
    
    .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Mobile Optimizations */
    @media (max-width: 575.98px) {
        .search-hero {
            padding: 1.5rem 1rem;
            border-radius: 0.75rem;
            margin: -1rem -1rem 1rem -1rem;
            border-radius: 0 0 1rem 1rem;
        }
        
        .search-hero h1 {
            font-size: 1.25rem;
        }
        
        .search-hero p {
            font-size: 0.875rem;
        }
        
        .search-box input {
            padding: 0.875rem 1rem;
            padding-right: 3rem;
            font-size: 1rem;
        }
        
        .search-box .btn-search {
            width: 38px;
            height: 38px;
        }
        
        .violation-card {
            padding: 1rem;
        }
        
        .license-plate-badge {
            font-size: 1rem;
            padding: 0.4rem 0.75rem;
        }
        
        .violation-info .icon {
            width: 28px;
            height: 28px;
            font-size: 0.8rem;
        }
        
        .empty-state, .welcome-state {
            padding: 2rem 1rem;
        }
        
        .violation-image-box .image-container img {
            max-height: 200px;
        }
        
        .violation-image-box .image-overlay {
            opacity: 1;
            padding: 0.5rem;
            font-size: 0.75rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Search Hero Section -->
<div class="search-hero">
    <h1><i class="fas fa-car me-2"></i>Tra cứu vi phạm giao thông</h1>
    <p>Nhập biển số xe để kiểm tra thông tin vi phạm</p>
    
    <form id="searchForm" method="GET" action="{{ route('dashboard') }}">
        <div class="search-box">
            <input 
                type="text" 
                name="license_plate" 
                id="licensePlateInput"
                placeholder="Nhập biển số xe, VD: 29A-12345" 
                value="{{ request('license_plate') }}"
                autocomplete="off"
                autocapitalize="characters"
            >
            <button type="submit" class="btn-search">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
    
    <div class="search-hint">
        <i class="fas fa-info-circle"></i> Hỗ trợ tìm kiếm một phần biển số
    </div>
</div>

<!-- Results Section -->
<div class="results-section">
    @if(request('license_plate'))
        @if(isset($violations) && $violations->count() > 0)
            <div class="results-header">
                <div class="results-count">
                    Tìm thấy <span>{{ $violations->count() }}</span> vi phạm
                </div>
            </div>
            
            @foreach($violations as $violation)
                <div class="violation-card">
                    <div class="violation-header">
                        <div class="license-plate-badge">
                            {{ $violation->license_plate }}
                        </div>
                        <div class="violation-date">
                            <i class="far fa-calendar-alt"></i>
                            {{ $violation->violation_date->format('d/m/Y') }}
                        </div>
                    </div>
                    
                    <div class="violation-body">
                        <div class="violation-info">
                            <div class="icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="content">
                                <div class="label">Họ và tên</div>
                                <div class="value">{{ $violation->full_name }}</div>
                            </div>
                        </div>
                        
                        <div class="violation-info">
                            <div class="icon">
                                <i class="fas fa-birthday-cake"></i>
                            </div>
                            <div class="content">
                                <div class="label">Ngày sinh</div>
                                <div class="value">{{ $violation->birth_date?->format('d/m/Y') }} ({{ $violation->age }} tuổi)</div>
                            </div>
                        </div>
                        
                        <div class="violation-info">
                            <div class="icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="content">
                                <div class="label">Địa chỉ</div>
                                <div class="value">{{ $violation->address }}</div>
                            </div>
                        </div>
                        
                        <div class="violation-type-box">
                            <div class="label">
                                <i class="fas fa-exclamation-triangle"></i>
                                Nội dung vi phạm
                            </div>
                            <div class="value">{{ $violation->violation_type }}</div>
                        </div>
                        
                        @if($violation->image)
                        <div class="violation-image-box">
                            <div class="label">
                                <i class="fas fa-camera"></i>
                                Hình ảnh vi phạm
                            </div>
                            <div class="image-container" onclick="openImageModal('{{ Storage::url($violation->image) }}')">
                                <img src="{{ Storage::url($violation->image) }}" alt="Hình ảnh vi phạm" loading="lazy">
                                <div class="image-overlay">
                                    <i class="fas fa-search-plus me-1"></i> Nhấn để xem ảnh lớn
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state no-result">
                <div class="icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>Không tìm thấy vi phạm</h3>
                <p>Biển số <strong>{{ request('license_plate') }}</strong> không có trong hệ thống<br>hoặc chưa có vi phạm được ghi nhận</p>
            </div>
        @endif
    @else
        <div class="welcome-state">
            <div class="icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h3>Tra cứu nhanh chóng & chính xác</h3>
            <p>Nhập biển số xe vào ô tìm kiếm phía trên để kiểm tra thông tin vi phạm giao thông</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('licensePlateInput');
    
    // Auto uppercase for license plate
    input.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
    
    // Focus on input when page loads (only on desktop)
    if (window.innerWidth > 768) {
        input.focus();
    }
});

// Image Modal Functions
function openImageModal(imageUrl) {
    // Remove existing modal if any
    const existingModal = document.getElementById('imageModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Create modal
    const modal = document.createElement('div');
    modal.id = 'imageModal';
    modal.className = 'image-modal show';
    modal.innerHTML = `
        <button class="close-btn" onclick="closeImageModal()">
            <i class="fas fa-times"></i>
        </button>
        <img src="${imageUrl}" alt="Hình ảnh vi phạm">
    `;
    
    // Close on background click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeImageModal();
        }
    });
    
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    if (modal) {
        modal.remove();
        document.body.style.overflow = '';
    }
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection
