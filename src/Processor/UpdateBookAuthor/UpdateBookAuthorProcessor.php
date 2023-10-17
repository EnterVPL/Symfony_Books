<?php

declare(strict_types=1);

namespace App\Processor\UpdateBookAuthor;

use App\Entity\Author;
use App\Entity\Book;
use App\Processor\UpdateBookAuthor\Dto\UpdateBookAuthorProcessorDto;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;

final class UpdateBookAuthorProcessor
{
    public function __construct(
        private BookRepository $bookRepository,
        private AuthorRepository $authorRepository
    ) {}

    public function process(UpdateBookAuthorProcessorDto $dto): void
    {
        $book = $this->bookRepository->findById($dto->bookId);
        if (null === $dto->authorName) {
            $this->removeBookAuthor($book);

            return;
        }

        $author = $this->authorRepository->findByName($dto->authorName);
        if (null === $author) {
            $author = $this->createAuthor($dto->authorName, $dto->authorCountry);
        }

        if ($author->getBooks()->count() >= 3) {
            throw new \Exception('Author can have a maximum of 3 books');
        }

        $this->bookRepository->updateAuthor($book, $author);
    }

    private function createAuthor(string $name, string $country): Author
    {
        return $this->authorRepository->create($name, $country);
    }

    private function removeBookAuthor(Book $book): void
    {
        $author = $book->getAuthor();
        if (null !== $author) {
            $author->removeBook($book);
            $this->authorRepository->update($author);
        }
        $book = $this->bookRepository->updateAuthor($book, null);
    }
}
