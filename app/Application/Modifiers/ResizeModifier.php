<?php

namespace App\Application\Modifiers;

use App\Application\Exceptions\ModifierException;
use App\Domain\Image\Image;
use Imagick;
use ImagickException;

class ResizeModifier implements ModifierInterface
{
    use ModifierTrait;

    public function __construct(private readonly int $width, private readonly int $height)
    {
    }

    public function modify(Image $image): void
    {
        if ($this->width <= 0 || $this->height <= 0) {
            throw new ModifierException('Resize dimensions are invalid');
        }

        try {
            $imagickImage = $this->getImagick($image);
            $imagickImage->resizeImage($this->width, $this->height, Imagick::FILTER_CATROM, 1);
        } catch (ImagickException $e) {
            throw new ModifierException($e->getMessage());
        }

        $image->setData((string) $imagickImage);
    }

    public function getParams(): array
    {
        return [
            'width' => $this->width,
            'height' => $this->height,
        ];
    }
}
