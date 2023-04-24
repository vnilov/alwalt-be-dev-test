<?php

namespace App\Application\Modifiers;

use App\Domain\Image\Image;
use App\Infrastructure\Persistence\ImageFileRepository;
use Imagick;

trait ModifierTrait
{
    private function getImagick(Image $image): Imagick
    {
        $imagick = new Imagick();

        if ($image->getData() === null) {
            $path = ImageFileRepository::getPath($image->getFullName());

            $imagick->readImage($path);
        } else {
            $imagick->readImageBlob($image->getData());
        }

        return $imagick;
    }
}
