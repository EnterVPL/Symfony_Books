<?php

declare(strict_types=1);

namespace App\Dto\Book;

use Symfony\Component\Validator\Constraints as Assert;

class BookDto
{
    public int $id;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1)]
    public string $name;

    #[Assert\NotBlank]
    public string $publishingHouse;

    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(1)]
    public int $pages;

    #[Assert\NotBlank]
    public bool $isPublic;
}
