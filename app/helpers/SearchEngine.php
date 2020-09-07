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

    public function getNextPage(int $start)
    {
        $this->offset = $start + 20;
        return $this;
    }

    public function getPreviousPage(int $start)
    {
        if ($this->offset >= 10) {
            $this->offset = $start - 20;
        }
        return $this;
    }
}
