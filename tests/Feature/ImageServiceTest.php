<?php

use App\Application\Exceptions\ImageNotFoundException;
use App\Application\Exceptions\InvalidImageException;
use App\Application\Services\ImageService;
use App\Application\Services\ModifierService;
use App\Domain\Image\Image;
use App\Infrastructure\Persistence\ImageFileRepository;

it('throws an ImageNotFoundException when trying to get a non-existing image', function () {
    $fileName = 'non-existing-image.jpg';

    $service = new ImageService();
    $this->expectException(ImageNotFoundException::class);
    $this->expectExceptionMessage('There is no image with such a name:' . $fileName);

    $service->getModifiedName($fileName, []);
});

it('returns the modified image name when it does not exist yet', function () {
    $modifiersInput = [
        'crop' => '100,100'
    ];

    $service = new ImageService();
    $result = $service->getModifiedName('example.jpg', $modifiersInput);

    $savedPath = STATIC_DIR . '/' . $result;

    expect(file_exists($savedPath))->toBeTrue();

    unlink($savedPath); // remove the saved file after the test
});