Copy code
<?php

use App\Application\Exceptions\ModifierException;
use App\Application\Modifiers\ResizeModifier;
use App\Domain\Image\Image;

it('should resize the image correctly', function () {
    $image = new Image('test', 'jpg');
    $image->setData(file_get_contents(__DIR__ . '/../../../assets/example.jpg'));

    $modifier = new ResizeModifier(500, 500);
    $modifier->modify($image);

    $imagickImage = new Imagick();
    $imagickImage->readImageBlob($image->getData());

    expect($imagickImage->getImageWidth())->toBe(500)
        ->and($imagickImage->getImageHeight())->toBe(500);
});

it('should throw exception when given invalid dimensions', function () {
    $image = new Image('test', 'jpg');
    $image->setData(file_get_contents(__DIR__ . '/../../../assets/example.jpg'));

    $modifier = new ResizeModifier(0, 0);

    expect(function () use ($modifier, $image) {
        $modifier->modify($image);
    })->toThrow(ModifierException::class);
});