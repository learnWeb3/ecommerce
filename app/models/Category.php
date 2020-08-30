<?php


class Category extends DbRecords
{
    // ATTIRBUTES
    protected $name;

    // CONSTRUCTOR
    public function __construct($name=null,$id = null, $created_at = null, $updated_at = null)
    {
        if (func_get_args() != null) {
            $this->name = $name;
        }
        parent::__construct($id, $created_at, $updated_at);
    }

    // GET NAME OF CATEGORY
    public function getName()
    {
        return $this->name;
    }
}
