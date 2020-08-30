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
        return intval($this->id);
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public static function destroyAll($table_names)
    {
        $db = new DbRecords();

        foreach ($table_names as $table_name) {
            $statement = "DELETE FROM $table_name";
            // READING AND FETCHING FROM DATABASE
            $prepared_statement = $db->connect()->prepare($statement);
            $prepared_statement->execute();
        }
    }
}
