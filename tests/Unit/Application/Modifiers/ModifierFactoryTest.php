<?php

namespace Tests\Unit\Application\Modifiers;

use App\Application\Modifiers\CropModifier;
use App\Application\Modifiers\ModifierFactory;
use App\Application\Modifiers\ResizeModifier;
use App\Domain\Image\ImageModifierEnum;

it('should create a crop modifier', function () {
    $modifier = ModifierFactory::createModifier(ImageModifierEnum::CROP, '100,200');

    expect($modifier)->toBeInstanceOf(CropModifier::class);
});

it('should create a resize modifier', function () {
    $modifier = ModifierFactory::createModifier(ImageModifierEnum::RESIZE, '300,400');

    expect($modifier)->toBeInstanceOf(ResizeModifier::class);
});
