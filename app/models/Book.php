<?php

class Book extends DbRecords
{

    protected $title;
    protected $author;
    protected $editor;
    protected $price;
    protected $publication_year;
    protected $image_path;
    protected $description;
    protected $category_id;

    public function __construct($title = null, $author = null, $editor = null, $price = null, $publication_year = null, $image_path = null, $description = null,$category_id=null, $id = null, $created_at = null, $updated_at = null)
    {
        if (func_get_args() != null) {
            $this->title = $title;
            $this->author = $author;
            $this->editor = $editor;
            $this->price = $price;
            $this->publication_year = $publication_year;
            $this->image_path = $image_path;
            $this->description = $description;
            $this->category_id = $category_id;
        }

        parent::__construct($id, $created_at, $updated_at);
    }



}
