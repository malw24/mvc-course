<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $isbn = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;
    

    /**
     * Fetches the id of the current book.
     * @return int which is the database id.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Fetches the title of the current book.
     * @return string which is the title of the book.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Sets the title of the current book.
     * 
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Fetches the ISBN of the current book.
     * @return string which is the ISBN of the book.
     */
    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    /**
     * Sets the ISBN of the current book.
     * 
     */
    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Fetches the author of the current book.
     * @return string which is the author of the book.
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * Sets the author of the current book.
     * 
     */
    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Fetches the url for the image of the current book.
     * @return string which is the url for the image of the book.
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
    /**
     * Sets the image of the current book.
     * 
     */
    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
