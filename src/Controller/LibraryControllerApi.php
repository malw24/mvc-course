<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class LibraryControllerApi extends AbstractController
{
    
    #[Route('api/library/books', name: 'library_show_all')]
    public function showAllBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        return $this->json($books);
    }

    #[Route('api/library/books/{isbn}', name: 'book_by_isbn')]
    public function showbookByIsbn(
        BookRepository $bookRepository,
        string $isbn
    ): Response {
        $books = $bookRepository
                ->findAll();
        $theBook = "";

        foreach ($books as $book) {
            if ($book->getIsbn() === $isbn) {
                $theBook = $book;
            }
        }

        return $this->json($theBook);
    }

    #[Route('api/library/books/specific/9781853260001', name: 'pride_api')]
    public function showPrideAndPrejudice(
        BookRepository $bookRepository
    ): Response {
        $isbn = "9781853260001";
        $books = $bookRepository
                ->findAll();
        $theBook = "";

        foreach ($books as $book) {
            if ($book->getIsbn() === $isbn) {
                $theBook = $book;
            }
        }

        return $this->json($theBook);
    }

    
}
