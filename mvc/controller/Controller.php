<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'mvc/model/Book.php';

class Controller {

    public function __construct() {
    }

    public function invoke() {
        if (!isset($_GET["book"])) {
            $books = $this->getBookList();
            include 'mvc/view/book_list.php';
        } else {
            $book = $this->getBook($_GET['book']);
            include 'mvc/view/book_info.php';
        }
    }

    public function getBookList() {
        return array("Jungle Book" => new Book("Jungle Book", "R.Kipling", "A classic book."),
            "Moonwalker" => new Book("Moonwalker", "J.Walker", ""),
            "PHP for Dummies" => new Book("PHP for Dummies", "Some Smart Guy", ""));
    }

    public function getBook($title) {
        $book_array = $this->getBookList();
        return $book_array[$title];
    }

}

?>
