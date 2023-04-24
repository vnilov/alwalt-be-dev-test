<?php

namespace App\Application\Modifiers;

use App\Domain\Image\ImageModifierEnum;

class ModifierFactory
{
    public static function createModifier(ImageModifierEnum $type, string $paramString): ModifierInterface
    {
        $params = explode(',', $paramString);

        return match ($type) {
            ImageModifierEnum::CROP => new CropModifier($params[0] ?? 0, $params[1] ?? 0),
            ImageModifierEnum::RESIZE => new ResizeModifier($params[0] ?? 0, $params[1] ?? 0)
        };
    }
}
