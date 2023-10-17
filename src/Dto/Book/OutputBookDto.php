<?php

declare(strict_types=1);

namespace App\Dto\Book;

use App\Dto\Author\AuthorDto;
use App\Entity\Book;

class OutputBookDto
{
    public int $id;

    public string $name;

    public string $publishingHouse;

    public int $pages;

    public bool $isPublic;

    public null|AuthorDto $author = null;

    public static function create(Book $book): static
    {
        $self = new self();
        $self->id = $book->getId();
        $self->name = $book->getName();
        $self->publishingHouse = $book->getPublishingHouse();
        $self->pages = $book->getPages();
        $self->isPublic = $book->isIsPublic();
        $author = $book->getAuthor();
        if (null !== $author) {
            $self->author = AuthorDto::create($book->getAuthor());
        }

        return $self;
    }
}
