<?php

namespace App\Domain\Image;

class Image
{
    /**
     * @param string $name
     * @param string $extension the extension is always the same, so we can make it readonly
     * @param string|null $data
     */
    public function __construct(
        private string $name,
        private readonly string $extension,
        private ?string $data = null,
    ) {
    }

    public function getFullName(): string
    {
        return $this->name . '.' . $this->extension;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setData(string $data): void
    {
        $this->data = $data;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }
}
