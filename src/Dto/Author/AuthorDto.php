<?php

declare(strict_types=1);

namespace App\Dto\Author;

use App\Entity\Author;

class AuthorDto
{
    public int $id;
    public string $name;
    public string $country;

    public static function create(Author $author): static
    {
        $self = new self();
        $self->id = $author->getId();
        $self->name = $author->getName();
        $self->country = $author->getCountry();

        return $self;
    }
}
