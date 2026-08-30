<?php

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileStorageService
{
    protected array $allowedMimes = [
        'image' => ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'],
        'document' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'],
    ];

    /**
     * Upload an image securely
     */
    public function uploadImage(UploadedFile $file, string $folder = 'uploads/images'): string
    {
        $mime = $file->getMimeType();
        if (!in_array($mime, $this->allowedMimes['image'])) {
            throw new Exception("Invalid image format: {$mime}. Only JPG, PNG, WebP, SVG, and GIF are allowed.");
        }

        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid() . '.' . strtolower($extension);
        $path = $file->storeAs($folder, $filename, 'public');

        return '/storage/' . $path;
    }

    /**
     * Upload a document securely
     */
    public function uploadDocument(UploadedFile $file, string $folder = 'uploads/documents'): array
    {
        $mime = $file->getMimeType();
        if (!in_array($mime, $this->allowedMimes['document'])) {
            throw new Exception("Invalid document format: {$mime}. Only PDF, DOC, DOCX, and images are allowed.");
        }

        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid() . '.' . strtolower($extension);
        $path = $file->storeAs($folder, $filename, 'public');

        return [
            'file_path' => '/storage/' . $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $mime,
        ];
    }
}
