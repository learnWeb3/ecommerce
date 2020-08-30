<?php


class Category extends DbRecords
{
    protected $name;


    public function __construct($name=null)
    {
        if (func_get_args() != null) {
            $this->name = $name;
        }
    }


    public function getName()
    {
        return $this->name;
    }
}
