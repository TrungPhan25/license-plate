<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageUploadController extends Controller
{
    /**
     * Upload ảnh tạm (async upload)
     * Ảnh sẽ được resize và nén trước khi lưu
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:10240'], // 10MB max cho upload
        ], [
            'image.required' => 'Vui lòng chọn ảnh.',
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Chỉ chấp nhận định dạng: JPEG, PNG, JPG, GIF.',
            'image.max' => 'Dung lượng ảnh tối đa 10MB.',
        ]);

        try {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $tmpPath = 'tmp/' . $filename;

            // Resize và nén ảnh với Intervention Image
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            
            // Resize nếu ảnh lớn hơn 1200px (giữ tỉ lệ)
            $image->scaleDown(width: 1200);
            
            // Encode với chất lượng 85%
            $encoded = $image->toJpeg(quality: 85);
            
            // Lưu vào thư mục tmp
            Storage::disk('public')->put($tmpPath, $encoded);

            // Trả về path để form sử dụng
            return response()->json([
                'success' => true,
                'path' => $tmpPath,
                'url' => Storage::disk('public')->url($tmpPath),
                'size' => Storage::disk('public')->size($tmpPath),
                'original_size' => $file->getSize(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể upload ảnh: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Xóa ảnh tạm (nếu user hủy hoặc chọn ảnh khác)
     */
    public function delete(Request $request): JsonResponse
    {
        $request->validate([
            'path' => ['required', 'string'],
        ]);

        $path = $request->input('path');

        // Chỉ cho phép xóa file trong thư mục tmp
        if (!Str::startsWith($path, 'tmp/')) {
            return response()->json([
                'success' => false,
                'message' => 'Không được phép xóa file này.',
            ], 403);
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
