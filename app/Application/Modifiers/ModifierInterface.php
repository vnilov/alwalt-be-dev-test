<?php

namespace App\Application\Modifiers;

use App\Domain\Image\Image;

interface ModifierInterface
{
    public function modify(Image $image): void;
    public function getParams();
}
