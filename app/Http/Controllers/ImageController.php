<?php

namespace App\Http\Controllers;

use App\Application\Exceptions\ValidationException;
use App\Application\Services\ImageService;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ImageController
{
    public function getModified(Request $request): RedirectResponse
    {
        $this->validateModifiersInput($request->query);

        $imageService = new ImageService();
        $imageName = $imageService->getModifiedName($request->attributes->get('filename'), $request->query->all());

        return new RedirectResponse('http://' . $_SERVER['HTTP_HOST'] . '/' . $imageName);
    }

    private function validateModifiersInput(ParameterBag $query): void
    {
        if (empty($query->keys())) {
            throw new ValidationException('At least one modifier is required');
        }
    }
}
