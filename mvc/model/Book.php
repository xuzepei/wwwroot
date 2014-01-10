<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Book {

    public $title;
    public $author;
    public $desc;

    public function __construct($title, $author, $desc) {
        $this->title = $title;
        $this->author = $author;
        $this->desc = $desc;
    }

}

?>
