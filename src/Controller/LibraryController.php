<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }

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

    #[Route('/library/create', name: 'library_create', methods:["GET", "POST"])]
    public function addBook(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        //https://pkp.sfu.ca/ojs/doxygen/master/html/classSymfony_1_1Component_1_1HttpFoundation_1_1Request.html#a770d44aaa4a5c7d314131a3de6fdf5f4
        $requestMethod = $request->getMethod();

        if ($requestMethod === "GET") {
            return $this->render('library/add_new_book.html.twig');
        }
        $title = $request->request->get('title');
        $isbn = $request->request->get('isbn');
        $author = $request->request->get('author');
        $imageLink = $request->request->get('image-link');

        $entityManager = $doctrine->getManager();

        $book = new Book();
        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setImage('img/' . $imageLink);

        $entityManager->persist($book);

        $entityManager->flush();



        return $this->redirectToRoute('library_read_all');

    }
    #[Route('/library/read-one', name: 'library_read_one')]
    public function readOneBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();
        $randomIndex = array_rand($books);
        $randomBook = $books[$randomIndex];

        $data = [
                    "title" => $randomBook->getTitle(),
                    "isbn" => $randomBook->getIsbn(),
                    "author" => $randomBook->getAuthor(),
                    "image_link" => $randomBook->getImage(),
                ];
        return $this->render('library/show_one_book.html.twig', $data);

    }

    #[Route('/library/book/specific/{id}', name: 'library_read_specific')]
    public function readSpecificBook(
        int $id,
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);
        $data = [
                    "title" => $book->getTitle(),
                    "isbn" => $book->getIsbn(),
                    "author" => $book->getAuthor(),
                    "image_link" => $book->getImage(),
                ];

        return $this->render('library/show_one_book_specific.html.twig', $data);

    }

    #[Route('/library/read-all', name: 'library_read_all')]
    public function readAllBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        // var_dump($books);
        $data = [
                    "books" => $books,
                ];
        return $this->render('library/show_all_books.html.twig', $data);

    }

    #[Route('/library/update', name: 'book_update')]
    public function updateBook(
        Request $request,
        BookRepository $bookRepository
    ): Response {
        $requestMethod = $request->getMethod();

        if ($requestMethod === "GET") {
            $books = $bookRepository
            ->findAll();
            $data = [
                        "books" => $books
                    ];
            return $this->render('library/update_a_book.html.twig', $data);
        }


    }

    #[Route('/library/update/specific', name: 'book_update_specific', methods:["GET", "POST"])]
    public function updateBookSpecific(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $requestMethod = $request->getMethod();

        if ($requestMethod === "POST") {
            $entityManager = $doctrine->getManager();
            $theId = intval($request->request->get('the_id'));
            $book = $entityManager->getRepository(Book::class)->find($theId);
            // var_dump($book);
            $data = [
                "book" => $book
            ];
            // var_dump($book);
            return $this->render('library/update_a_book_specific.html.twig', $data);
        }

        return $this->redirectToRoute('book_update');

    }


    #[Route('/library/update/current-book', name: 'book_update_current', methods:["POST"])]
    public function updateBookCurrentBook(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $requestMethod = $request->getMethod();

        if ($requestMethod === "POST") {
            $bookData = [];

            $entityManager = $doctrine->getManager();
            $theId = $request->request->get('theId');
            $title = $request->request->get('title');
            $isbn = $request->request->get('isbn');
            $author = $request->request->get('author');
            $image = $request->request->get('image');

            $book = $entityManager->getRepository(Book::class)->find($theId);

            $bookData[] = $title;
            $bookData[] = $isbn;
            $bookData[] = $author;
            $bookData[] = $image;
            for ($index = 0; $index <= 3; $index++) {
                if ($bookData[$index]) {
                    // var_dump($bookData[$index]);
                    if ($index === 0) {
                        // var_dump("In med titlen");
                        $book->setTitle($title);
                    }
                    if ($index === 1) {
                        // var_dump("In med isbn");
                        $book->setIsbn($isbn);
                    }
                    if ($index === 2) {
                        // var_dump("In med författare");
                        $book->setAuthor($author);
                    }
                    if ($index === 3) {
                        // var_dump("In med image");
                        $book->setImage('img/' . $image);
                    }
                }

            }
            $entityManager->flush();

            return $this->redirectToRoute('library_read_all');
        }
    }


    #[Route('/library/delete', name: 'book_delete')]
    public function deleteBook(
        ManagerRegistry $doctrine,
        Request $request,
        BookRepository $bookRepository
    ): Response {
        $requestMethod = $request->getMethod();

        if ($requestMethod === "GET") {
            $books = $bookRepository
            ->findAll();
            $data = [
                        "books" => $books
                    ];
            return $this->render('library/delete_a_book.html.twig', $data);
        }
        if ($requestMethod === "POST") {

            $entityManager = $doctrine->getManager();
            $theId = intval($request->request->get('the_id'));
            $book = $entityManager->getRepository(Book::class)->find($theId);

            $entityManager->remove($book);
            $entityManager->flush();

            return $this->redirectToRoute('library_read_all');
        }



    }
}
