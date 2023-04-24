<?php

namespace App\Application\Services;

use App\Application\Modifiers\ModifierFactory;
use App\Application\Modifiers\ModifierInterface;
use App\Domain\Image\Image;
use App\Domain\Image\ImageModifierEnum;

class ModifierService
{
    public function generateModifiers(array $input): array
    {
        $modifiers = [];
        foreach ($input as $modifierName => $modifierParamString) {
            // let's skip the modifier if it's not valid
            if (null === $modifierType = ImageModifierEnum::tryFrom($modifierName)) {
                continue;
            }

            $modifiers[] = ModifierFactory::createModifier($modifierType, $modifierParamString);
        }

        return $modifiers;
    }

    /**
     * We use the key to generate a unique name for the modified image
     *
     * @param string $fileName
     * @param array $modifiers
     * @return string
     */
    public function generateKey(string $fileName, array $modifiers): string
    {
        $key = $fileName;
        foreach ($modifiers as $modifier) {
            /** @var ModifierInterface $modifier */
            $key .= get_class($modifier) . implode("", $modifier->getParams());
        }

        return md5($key);
    }

    public function modify(Image $image, array $modifiers): Image
    {
        foreach ($modifiers as $modifier) {
            /** @var ModifierInterface $modifier */
            $modifier->modify($image);
        }

        return $image;
    }
}
