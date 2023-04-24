<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Image\Image;
use RuntimeException;

class ImageFileRepository
{
    public static function getPath(string $filename): string
    {
        return STATIC_DIR . '/' . $filename;
    }

    public function getByName(string $filename): ?Image
    {
        $fullPath = STATIC_DIR . '/' . $filename;

        return $this->getFromFilesystem($fullPath);
    }

    private function getFromFilesystem(string $path): ?Image
    {
        if (!file_exists($path)) {
            return null;
        }

        $filename = pathinfo($path, PATHINFO_FILENAME);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return new Image($filename, $extension);
    }

    public function save(Image $image): void
    {
        $fullPath = STATIC_DIR . '/' . $image->getFullName();

        if (!file_put_contents($fullPath, $image->getData())) {
            throw new RuntimeException('Failed to save image');
        }
    }
}
