<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Book\BookDto;
use App\Dto\Book\InputAuthorBookDto;
use App\Dto\Book\OutputBookDto;
use App\Processor\UpdateBookAuthor\Dto\UpdateBookAuthorProcessorDto;
use App\Processor\UpdateBookAuthor\UpdateBookAuthorProcessor;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route(
        '/book',
        name: 'app_book_get_all',
        methods: 'GET'
    )]
    public function getAll(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        $output = [];
        foreach ($books as $book) {
            $output[] = OutputBookDto::create($book);
        }

        return $this->json(['books' => $output]);
    }

    #[Route(
        '/book/{id}',
        name: 'app_book_get_by_id',
        methods: 'GET'
    )]
    public function getById(int $id, BookRepository $bookRepository): Response
    {
        $book = $bookRepository->findById($id);
        $output = OutputBookDto::create($book);

        return $this->json(['book' => $output]);
    }

    #[Route(
        '/book',
        name: 'app_book_create',
        methods: ['POST', 'PUT']
    )]
    public function create(
        BookRepository $bookRepository,
        #[MapRequestPayload]
        BookDto $bookDto
    ): Response {
        $book = $bookRepository->create($bookDto);
        $output = OutputBookDto::create($book);

        return $this->json(['book' => $output]);
    }

    #[Route(
        '/book/{id}',
        name: 'app_book_update',
        methods: ['POST', 'PUT']
    )]
    public function update(
        int $id,
        BookRepository $bookRepository,
        #[MapRequestPayload]
        BookDto $bookDto
    ): Response {
        $book = $bookRepository->findById($id);
        $book = $bookRepository->updateByDto($book, $bookDto);

        $output = OutputBookDto::create($book);

        return $this->json(['book' => $output]);
    }

    #[Route(
        '/book/{id}',
        name: 'app_book_delete',
        methods: ['DELETE']
    )]
    public function delete(
        int $id,
        BookRepository $bookRepository,
    ): Response {
        $book = $bookRepository->findById($id);
        $bookRepository->delete($book);

        return new JsonResponse(['success' => true]);
    }

    #[Route(
        '/book/{id}/author',
        name: 'app_book_update_author',
        methods: ['PATCH']
    )]
    public function updateAuthor(
        int $id,
        UpdateBookAuthorProcessor $processor,
        BookRepository $bookRepository,
        #[MapRequestPayload]
        InputAuthorBookDto $authorBookDto
    ): Response {
        $dto = new UpdateBookAuthorProcessorDto();
        $dto->bookId = $id;
        $dto->authorName = $authorBookDto->name;
        $processor->process($dto);

        $book = $bookRepository->findById($id);

        $output = OutputBookDto::create($book);

        return $this->json(['book' => $output]);
    }
}
