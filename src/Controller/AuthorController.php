<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Book\OutputBookDto;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route(
        '/author/{id}',
        name: 'app_book_by_author',
        methods: ['GET']
    )]
    public function bookByAuthor(
        int $id,
        AuthorRepository $authorRepository
    ): Response {
        $author = $authorRepository->findById($id);
        if (null === $author) {
            return $this->json([], 404);
        }
        $books = $author->getBooks();
        if (0 === $books->count()) {
            return $this->json([], 404);
        }
        $output = [];
        foreach ($books as $book) {
            $output[] = OutputBookDto::create($book);
        }

        return $this->json(['book' => $output]);
    }
}
