<?php


class DbRecords
{
    protected $id;
    protected $created_at;
    protected $updated_at;

    use Db;



    public function __construct($id = null, $created_at = null, $updated_at = null)
    {
        if ($id != null && $created_at != null) {
            $this->id = $id;
            $this->created_at = $created_at;
        }

        if ($updated_at != null) {
            $this->updated_at = $updated_at;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getObjectVars()
    {
        return get_object_vars($this);
    }
}
