<?php

class SearchEngine
{
    public $column_name;
    public $value;
    public $limit;
    public $offset;
    public $order_column;
    public $order;


    public function __construct($column_name, $value, $order_column = "book_created_at", $order = "DESC", $limit = 20, $offset = 0)
    {
        $this->column_name = $column_name;
        $this->value = $value;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order_column = $order_column;
        $this->order = $order;
    }

    public function getSearchResult()
    {
        return Book::searchLike($this->column_name, $this->value, $this->limit, $this->offset, $this->order_column, $this->order);
    }

    public function getNextPage()
    {
        $this->offset = $this->offset + 10;
        return $this;
    }

    public function getPreviousPage()
    {
        if ($this->offset >= 10) {
            $this->offset = $this->offset - 10;
        }
        return $this;
    }
}
