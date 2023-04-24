<?php

use App\Domain\Image\Image;
use App\Infrastructure\Persistence\ImageFileRepository;


it('can get path of an image file', function () {
    $filename = 'example.jpg';
    $path = ImageFileRepository::getPath($filename);

    expect($path)->toBe(STATIC_DIR . '/' . $filename);
});

it('can generate an image instance by filename', function () {
    $filename = 'example.jpg';
    $repository = new ImageFileRepository();
    $image = $repository->getByName($filename);

    expect($image)->toBeInstanceOf(Image::class)
        ->and($image->getFullName())->toBe($filename);
});

it('returns null for a non-existent image', function () {
    $filename = 'nonexistent.jpg';
    $repository = new ImageFileRepository();
    $image = $repository->getByName($filename);

    expect($image)->toBeNull();
});

it('can save an image to the filesystem', function () {
    $filename = 'example.jpg';
    $data = file_get_contents(STATIC_DIR . '/' . $filename);

    $image = new Image('example_new', 'jpg', $data);
    $repository = new ImageFileRepository();

    $repository->save($image);

    $savedPath = STATIC_DIR . '/' . $image->getFullName();

    expect(file_exists($savedPath))->toBeTrue()
        ->and(file_get_contents($savedPath))->toEqual($data);

    unlink($savedPath); // remove the saved file after the test
});
