<?php

namespace App\Application\Services;

use App\Application\Exceptions\ImageNotFoundException;
use App\Application\Exceptions\InvalidImageException;
use App\Domain\Image\Image;
use App\Infrastructure\Persistence\ImageFileRepository;

class ImageService
{
    private ImageFileRepository $fileRepository;
    private ModifierService $modifierService;

    public function __construct()
    {
        $this->fileRepository = new ImageFileRepository();
        $this->modifierService = new ModifierService();
    }

    public function getModifiedName(string $fileName, array $modifiersInput): string
    {
        if (null === $image = $this->fileRepository->getByName($fileName)) {
            throw new ImageNotFoundException('There is no image with such a name:' . $fileName);
        }

        $modifiers = $this->modifierService->generateModifiers($modifiersInput);
        $key = $this->modifierService->generateKey($fileName, $modifiers);

        // if we already have the modified image, we just return its name
        if (null !== $modifiedImage = $this->fileRepository->getByName($key . '.' . $image->getExtension())) {
            return $modifiedImage->getFullName();
        }

        $this->modifierService->modify($image, $modifiers);
        $image->setName($key);

        $this->save($image);

        return $image->getFullName();
    }

    public function save(Image $image): void
    {
        if ($image->getData() === null) {
            throw new InvalidImageException('Image is empty');
        }

        $this->fileRepository->save($image);
    }
}
