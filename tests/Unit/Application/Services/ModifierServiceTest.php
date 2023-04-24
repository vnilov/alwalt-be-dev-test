<?php

use App\Application\Modifiers\CropModifier;
use App\Application\Modifiers\ResizeModifier;
use App\Application\Services\ModifierService;
use App\Domain\Image\Image;

it('can generate modifiers for valid modifier names', function () {
    $modifierService = new ModifierService();
    $inputModifiers = [
        'resize' => '100,200',
        'crop' => '50,50',
        'invalid-modifier-name' => 'invalid-modifier-param',
    ];

    $modifiers = $modifierService->generateModifiers($inputModifiers);

    expect($modifiers)->toHaveCount(2)
        ->and($modifiers[0])->toBeInstanceOf(ResizeModifier::class)
        ->and($modifiers[1])->toBeInstanceOf(CropModifier::class);
});

it('can generate key for the given filename and modifiers', function () {
    $modifierService = new ModifierService();

    $modifiers = [
        new ResizeModifier(100, 200),
        new CropModifier(50, 50),
    ];

    $key = $modifierService->generateKey('example.jpg', $modifiers);

    expect($key)->toBeString()
        ->and($key)->toHaveLength(32);
});

it('can modify image with the given modifiers', function () {
    $modifierService = new ModifierService();
    $image = new Image('example', 'jpg');

    $modifiers = [
        new ResizeModifier(100, 200),
        new CropModifier(50,50)
    ];

    $modifiedImage = $modifierService->modify($image, $modifiers);

    expect($modifiedImage)->toBeInstanceOf(Image::class)
        ->and($modifiedImage->getData())->toBeString();
});