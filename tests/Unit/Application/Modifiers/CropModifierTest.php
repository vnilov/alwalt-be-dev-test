<?php

namespace Tests\Unit\Application\Modifiers;

use App\Application\Exceptions\ModifierException;
use App\Application\Modifiers\CropModifier;
use App\Domain\Image\Image;
use Imagick;

it('crops the image correctly', function () {
    $image = new Image('test', 'jpg');
    $image->setData(file_get_contents(__DIR__.'/../../../assets/example.jpg'));

    $cropModifier = new CropModifier(200, 200);
    $cropModifier->modify($image);

    $imagick = new Imagick();
    $imagick->readImageBlob($image->getData());

    expect($imagick->getImageWidth())->toEqual(200)
        ->and($imagick->getImageHeight())->toEqual(200);
});

it('throws an exception for invalid dimensions', function () {
    $image = new Image('test', 'jpg');
    $image->setData(file_get_contents(__DIR__.'/../../../assets/example.jpg'));

    $cropModifier = new CropModifier(-200, 200);
    $cropModifier->modify($image);
})->throws(ModifierException::class);

it('throws an exception for dimensions bigger than the image', function () {
    $image = new Image('test', 'jpg');
    $image->setData(file_get_contents(__DIR__.'/../../../assets/example.jpg'));

    $cropModifier = new CropModifier(5000, 5000);
    $cropModifier->modify($image);
})->throws(ModifierException::class);

