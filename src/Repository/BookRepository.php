<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\Book\BookDto;
use App\Entity\Author;
use App\Entity\Book;
use App\Service\BookFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method null|Book find($id, $lockMode = null, $lockVersion = null)
 * @method null|Book findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private BookFactory $bookFactory
    ) {
        parent::__construct($registry, Book::class);
    }

    public function findById(int $id): null|Book
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function create(BookDto $bookDto): Book
    {
        $book = $this->bookFactory->create($bookDto);
        $this->update($book);

        return $book;
    }

    public function update(Book $book): void
    {
        $this->_em->persist($book);
        $this->_em->flush();
    }

    public function updateByDto(Book $book, BookDto $bookDto): Book
    {
        $this->bookFactory->mergeWithDto($book, $bookDto);
        $this->update($book);

        return $book;
    }

    public function updateAuthor(Book $book, null|Author $author): Book
    {
        $book->setAuthor($author);
        $this->update($book);

        return $book;
    }

    public function delete(Book $book): void
    {
        $this->_em->remove($book);
        $this->_em->flush();
    }
}
