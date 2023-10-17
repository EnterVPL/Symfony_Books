<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Book\BookDto;
use App\Entity\Book;

class BookFactory
{
    public function create(BookDto $bookDto): Book
    {
        $book = new Book();

        return $this->mergeWithDto($book, $bookDto);
    }

    public function mergeWithDto(Book $book, BookDto $bookDto): Book
    {
        $book->setName($bookDto->name);
        $book->setPages($bookDto->pages);
        $book->setPublishingHouse($bookDto->publishingHouse);
        $book->setIsPublic($bookDto->isPublic);

        return $book;
    }
}
