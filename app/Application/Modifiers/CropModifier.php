<?php

namespace App\Application\Modifiers;

use App\Application\Exceptions\ModifierException;
use App\Domain\Image\Image;
use ImagickException;

class CropModifier implements ModifierInterface
{
    use ModifierTrait;

    public function __construct(private readonly int $width, private readonly int $height)
    {
    }

    public function modify(Image $image): void
    {
        if ($this->width <= 0 || $this->height <= 0) {
            throw new ModifierException('Crop dimensions are invalid');
        }

        try {
            $imagickImage = $this->getImagick($image);

            $imageWith = $imagickImage->getImageWidth();
            $imageHeight = $imagickImage->getImageHeight();

            if ($imageWith < $this->width || $imageHeight < $this->height) {
                throw new ModifierException('Crop dimensions are bigger than the image');
            }

            // to simplify the task, I crop the image from the top left corner
            $imagickImage->cropImage($this->width, $this->height, 0, 0);
        } catch (ImagickException $e) {
            throw new ModifierException($e->getMessage());
        }

        $image->setData((string)$imagickImage);
    }

    public function getParams(): array
    {
        return [
            'width' => $this->width,
            'height' => $this->height,
        ];
    }
}
