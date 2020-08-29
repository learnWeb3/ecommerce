<?php


class Category extends DbRecords
{
    protected $name;


    public function __construct($name)
    {
        $this->name = $name;
    }

}
