<?php


class Category
{
    // ATTIRBUTES
    public $name;

    protected $id;
    protected $created_at;
    protected $updated_at;

    // USING COMMON METHODS
    use Db;

    // CONSTRUCTOR
    public function __construct($name = null, $id = null, $created_at = null, $updated_at = null)
    {
        if ($name != null) {
            $this->name = $name;
        }
        if ($id != null) {
            $this->id = $id;
        }

        if ($created_at != null) {
            $this->created_at = $created_at;
        }

        if ($updated_at != null) {
            $this->updated_at = $updated_at;
        }
    }

    // GET NAME OF CATEGORY
    public function getName()
    {
        return $this->name;
    }

}
