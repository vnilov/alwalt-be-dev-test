<?php

namespace App\Domain\Image;

enum ImageModifierEnum: string
{
    case RESIZE = 'resize';
    case CROP = 'crop';
}
