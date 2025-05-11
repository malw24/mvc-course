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

    #[Route('/library/show', name: 'library_show_all')]
    public function showAllBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        return $this->json($books);
    }

    #[Route('/library/create', name: 'library_create', methods:["GET", "POST"])]
    public function addBook(
        BookRepository $bookRepository,
        Request $request,
        ManagerRegistry $doctrine
    ): Response 
    {
        //https://pkp.sfu.ca/ojs/doxygen/master/html/classSymfony_1_1Component_1_1HttpFoundation_1_1Request.html#a770d44aaa4a5c7d314131a3de6fdf5f4
       $requestMethod = $request->getMethod();
       if($requestMethod === "GET") {
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
       $book->setImage($imageLink);

       $entityManager->persist($book);

       $entityManager->flush();

       return $this->redirectToRoute('library_show_all');

    }

    #[Route('/library/read-one', name: 'library_read_one')]
    public function readOneBook(
        BookRepository $bookRepository
    ): Response 
    {
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

    #[Route('/library/read-all', name: 'library_read_all')]
    public function readAllBooks(
        BookRepository $bookRepository,
        Request $request,
        ManagerRegistry $doctrine
    ): Response 
    {
        $books = $bookRepository
            ->findAll();

        // var_dump($books);
        $data = [
                    "books" => $books,
                ];
        return $this->render('library/show_all_books.html.twig', $data);
       
    }

    // #[Route('/library/create-manually', name: 'library_create_manually')]
    // public function createBookManually(
    //     ManagerRegistry $doctrine
    // ): Response {
    //     $entityManager = $doctrine->getManager();
    //     $book = new Book();
    //     $book->setTitle("Moby-Dick");
    //     $book->setIsbn("9789187193170");
    //     $book->setAuthor("Herman Melville");
    //     $book->setImage("/images/moby.jpg");

    //     // tell Doctrine you want to (eventually) save the Product
    //     // (no queries yet)
    //     $entityManager->persist($book);

    //     // actually executes the queries (i.e. the INSERT query)
    //     $entityManager->flush();

    //     return new Response('Saved new book called:'.$book->getTitle());
    // }

 
}
