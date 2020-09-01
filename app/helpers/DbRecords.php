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


    public static function destroy($id)
    {
        $class_name = get_called_class();
        $table_name = strtolower($class_name);
        $statement = "DELETE FROM $table_name WHERE id= ?";
        $connection = Db::connect();
        $prepared_statement = $connection->prepare($statement);
        return  $prepared_statement->execute(array($id));
    }

    public static function resetAutoIncrement($table_name)
    {
        $db = new DbRecords();
        $statement = "ALTER TABLE $table_name AUTO_INCREMENT=1";
        // EXECUTING QUERY
        return $db->connect()->query($statement);
    }


    public static function checkLimitAndOffset($limit, $offset)
    {
        if (gettype($limit) == "integer" && gettype($offset) == "integer" && $limit > 0 && $offset >= 0) {
            return true;
        } else {
            return false;
        }
    }
}
