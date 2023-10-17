<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method null|Author find($id, $lockMode = null, $lockVersion = null)
 * @method null|Author findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findById(int $id): null|Author
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function findByName(string $name): null|Author
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function create(string $name, string $country): Author
    {
        $author = new Author();
        $author->setName($name);
        $author->setCountry($country);

        $this->update($author);

        return $author;
    }

    public function update(Author $author): void
    {
        $this->_em->persist($author);
        $this->_em->flush();
    }
}
