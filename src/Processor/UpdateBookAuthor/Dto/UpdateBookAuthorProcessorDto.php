<?php

declare(strict_types=1);

namespace App\Processor\UpdateBookAuthor\Dto;

final class UpdateBookAuthorProcessorDto
{
    public int $bookId;
    public null|string $authorName;
    public string $authorCountry;
}
