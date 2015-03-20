<?php

class Book {
    private $bookTitle;
    private $bookAuthor;
    private $isbn;

    public function __construct($newBookTitle, $newBookAuthor, $newBookIsbn) {
        $this->bookIsbn = $newBookIsbn;
        $this->bookTitle = $newBookTitle;
        $this->bookAuthor = $newBookAuthor;
    }

    public function getBookTitle() {
        return $this->bookTitle;
    }

    public function getBookAuthor() {
        return $this->bookAuthor;
    }

    public function getIsbn() {
        return $this->isbn;
    }
}


// the collection builder
class BookList implements \Countable {

    private $books;

    public function getBook($bookNumberToGet) {
        if ((int)$bookNumberToGet <= $this->count()) {
            return $this->books[$bookNumberToGet];
        } else {
            return null;
        }
    }

    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    public function removeBook(Book $bookToRemove) {
        foreach ($this->books as $key => $book) {
            if ($book->getIsbn == $bookToRemove->getIsbn) {
                unset($this->books[$key]);
            }
        }
    }

    public function count() {
        return count($this->books);
    }
}


class BookListIterator implements \Iterator {

    protected $bookList;
    protected $currentBook = 0;

    public function __construct(BookList $newBookList) {
        $this->bookList = $newBookList;
    }

    public function current() {
        return $this->bookList->getBook($this->currentBook);
    }

    public function key() {
        return $this->currentBook;
    }

    public function next() {
        $this->currentBook++;
    }

    public function rewind() {
        $this->currentBook = 0;
    }

    public function valid() {
        return $this->bookList->count() > $this->currentBook;
    }
}

class IteratorTest extends \PHPUnit_Framework_TestCase {
    public function testIterateBooks() {
        $bookList = new BookList();
        $bookList->addBook(new Book('1,000 Places to See Before You Die', 'Patricia Schultz', '0761156860'));
        $bookList->addBook(new Book('Bicycle Book', 'Gail Gibbons ', '0823411990'));
        $bookList->addBook(new Book('The Herbal Remedies Handbook', 'Lillian Hall', 'B00N9H6QVI'));

        $iterator = new BookListIterator($bookList);

        while ($iterator->valid()) {
            print $iterator->current()->getBookTitle() . PHP_EOL;
            $iterator->next();
        }
    }

    protected function assertPostConditions() {
        print "---------------------------------------------------------------- \n";
    }
}