<?php

class SearchEngine
{
    public $column_name;
    public $value;
    public $limit;
    public $offset;
    public $order_column;
    public $order;
    public $category_id;
    public $price_min;
    public $price_max;


    public function __construct($column_name, $value, $order_column = "book_created_at", $order = "DESC", $limit = 20, $offset = 0, $price_min=null,$price_max=null,$category_id=null)
    {
        $this->column_name = $column_name;
        $this->value = $value;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order_column = $order_column;
        $this->order = $order;
        if ($price_min != null && $price_max != null && $category_id != null) {
            $this->price_min = $price_min;
            $this->price_max = $price_max;
            $this->category_id = $category_id;
        }
    }

    public function getSearchResult()
    {

        if ( is_null($this->price_min)  || is_null($this->price_max) || is_null($this->category_id)) {
            return Book::searchLike($this->column_name, $this->value, $this->limit, $this->offset, $this->order_column, $this->order);
        } else {
            return Book::filterSearchMenu($this->category_id, $this->price_min, $this->price_max, $this->order_column, $this->order, $this->limit, $this->offset);
        }
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
