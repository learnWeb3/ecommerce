<?php


class Category extends DbRecords
{
    protected $name;


    public function __construct($name=null,$id = null, $created_at = null, $updated_at = null)
    {
        if (func_get_args() != null) {
            $this->name = $name;
        }
        parent::__construct($id, $created_at, $updated_at);
    }


    public function getName()
    {
        return $this->name;
    }
}
