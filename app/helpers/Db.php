<?php


trait Db
{


    public static function connect()
    {

        $dsn = "mysql:" . "host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        try {
            return new PDO($dsn, DB_USERNAME, DB_PASSWORD);
        } catch (Exception $e) {
            die("Expetion message :<strong>".$e->getMessage()."</strong> "."créée depuis la ligne : " . $e->getLine()." du document ".$e->getFile());
        }
    }

    // SHARED ATTRIBUTES ACROSS ALL MODELS
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

    public function getCreatedAtFormated()
    {
        return strftime("%d-%m-%Y à %H:%M", strtotime($this->created_at));
    }

    public function getUpdatedAtFormated()
    {
        return strftime("%d-%m-%Y à %H:%M", strtotime($this->updated_at));
    }



    // GETTING OBEJCT VARS DYNAMICALLY
    public function getObjectVars()
    {
        return get_object_vars($this);
    }
    
    // GET FIELDS 
    private function getFields(): array
    {
        // OBJECT POSSES FIELDS WICH WILL BE POPULATED AUTOMATICALLY IN DB
        $not_desired_columns = ["id", "created_at", "updated_at", "ht_price"];
        // GETTING OBJECT FIELDS AS AN ASSOCIATIVE ARRAY IN ORDER TO MANIPULATE IT MORE EASYLY
        $object_vars = $this->getObjectVars();
        // FILTERING OUT NOT NEEDED DESIRED FIELDS
        $object_vars = array_filter(get_object_vars($this), function ($key) use ($object_vars, $not_desired_columns) {
            if (in_array($key, $not_desired_columns)) {
                return false;
            } else {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY);

        return $object_vars;
    }


    // WRITING TO DATABSE IN A DYNAMIC MANEER
    public function create()
    {
        $object_vars = $this->getFields();
        // GETTING THE NAME OF THE TABLE WE WANT TO WRITE IN  BASED ON OUR OWN CONVENTION 
        $table_name = DB_NAMING_CONVENTIONS[get_class($this)];
        // FORMATTING DATAS TO PASS IT TO A PREPARED STATEMENT DEALT BY PDO
        $columns = implode(",", array_keys($object_vars));
        $values =  array_values($object_vars);

        $prepared_values = implode(",", array_map(function ($el) {
            return "?";
        }, $values));

        // STATEMENT
        $statement = "INSERT INTO $table_name ($columns) VALUES ($prepared_values)";

        // WRITING INTO DATABASE
        $prepared_statement = Db::connect()->prepare($statement);

        $prepared_statement->execute($values);

        return $this->lastCreated();
    }


    // FETCHING LAST CRETAED INSTANCE
    public function lastCreated()
    {
        $table_name = DB_NAMING_CONVENTIONS[get_class($this)];
        // STATEMENT
        $statement = "SELECT * FROM $table_name ORDER BY created_at DESC LIMIT 1";
        // READING AND FETCHING FROM DATABASE
        $prepared_statement =  Db::connect()->prepare($statement);
        $prepared_statement->execute();
        return $prepared_statement->fetchAll(PDO::FETCH_CLASS, get_class($this))[0];
    }


    // UPDATING RECORDS
    public function update()
    {
        $object_vars = $this->getFields();

        // GETTING THE NAME OF THE TABLE WE WANT TO WRITE IN  BASED ON OUR OWN CONVENTION 
        $table_name = DB_NAMING_CONVENTIONS[get_class($this)];
        // FORMATTING DATAS TO PASS IT TO A PREPARED STATEMENT DEALT BY PDO
        $columns = array_keys($object_vars);
        $values =  array_values($object_vars);

        $datas = "";
        foreach ($columns as $i => $v) {
            if ($i < count($columns) - 1) {
                $datas .= $v . "=" . "?, ";
            } else {
                $datas .= $v . "=" . "? ";
            }
        }

        // STATEMENT
        $statement = "UPDATE $table_name SET $datas WHERE id=?";

        // WRITING INTO DATABASE
        $prepared_statement =  Db::connect()->prepare($statement);

        $fields = array_merge($values, array($this->getId()));

        return $prepared_statement->execute($fields);
    }

    // FINDING A RECORD BY ITS PRIMARY KEY
    public static function find($id)
    {
        $table_name = DB_NAMING_CONVENTIONS[get_called_class()];
        // STATEMENT
        $statement = "SELECT * FROM $table_name WHERE id=?";
        // READING AND FETCHING FROM DATABASE
        $prepared_statement =  Db::connect()->prepare($statement);
        $prepared_statement->execute(array($id));
        return $prepared_statement->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }

    // FINDING ALL RECORDS IN A GIVEN TABLE
    public static function findAll($order_column, $inversed = true)
    {
        $table_name = DB_NAMING_CONVENTIONS[get_called_class()];
        // STATEMENT
        $order = ($inversed) ? "DESC" : "ASC";
        $statement = "SELECT * FROM $table_name ORDER BY $order_column $order";
        // READING AND FETCHING FROM DATABASE
        $prepared_statement = Db::connect()->prepare($statement);
        $prepared_statement->execute();
        return $prepared_statement->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }

    // PERFORMING A SELECT WITH A WHERE CLAUSE ACCORDING DIFFERENT COLUMN VALUES
    public static function where($searched_column, $searched_value, $order_column, $inversed = true)
    {
        $table_name = DB_NAMING_CONVENTIONS[get_called_class()];
        // STATEMENT
        $order = ($inversed) ? "DESC" : "ASC";
        $statement = "SELECT * FROM $table_name WHERE $searched_column=? ORDER BY $order_column $order";
        // READING AND FETCHING FROM DATABASE
        $prepared_statement = Db::connect()->prepare($statement);
        $prepared_statement->execute(array($searched_value));
        return $prepared_statement->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }

    // PERFORMING A SELECT WITH A LIKE CLAUSE ACCORDING DIFFERENT COLUMN VALUES
    public static function like($searched_column, $searched_value, $order_column, $inversed = true)
    {
        $table_name = DB_NAMING_CONVENTIONS[get_called_class()];
        // STATEMENT
        $order = ($inversed) ? "DESC" : "ASC";
        $statement = "SELECT * FROM $table_name WHERE $searched_column LIKE $searched_value ORDER BY $order_column $order";
        // READING AND FETCHING FROM DATABASE
        $prepared_statement = Db::connect()->prepare($statement);
        $prepared_statement->execute();
        return $prepared_statement->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }

    // GETTING SEARCH FILTERS
    public static function getSearchFilters()
    {
        $connection = self::connect();
        $statement = "SELECT filter, filter_name FROM search_filters";
        $query = $connection->query($statement);
        $results = array();

        while($row=$query->fetch())
        {
            $results[] = array('filter'=>$row['filter'],'filter_name'=> $row['filter_name']);
        }

        return $results;
    }

    // DESTROYING ALL RECORDS IN A GIVEN TABLE    
    public static function destroyAll($table_names)
    {
        $connection = Db::connect();

        foreach ($table_names as $table_name) {
            $statement = "DELETE FROM $table_name";
            // READING AND FETCHING FROM DATABASE
            $prepared_statement = $connection->prepare($statement);
            $prepared_statement->execute();
        }
    }

    // DESTROYING SPECIFIC RECORD BY ITS PRIMARY KEY
    public static function destroy($id)
    {
        $table_name = DB_NAMING_CONVENTIONS[get_called_class()];
        $statement = "DELETE FROM $table_name WHERE id= ?";
        $connection = Db::connect();
        $prepared_statement = $connection->prepare($statement);
        return  $prepared_statement->execute(array($id));
    }

    // RESTING AUTO INCREMNT IN A GIVEN TABLE
    public static function resetAutoIncrement($table_name)
    {
        $connection = Db::connect();
        $statement = "ALTER TABLE $table_name AUTO_INCREMENT=1";
        // EXECUTING QUERY
        return $connection->query($statement);
    }

    // CHECKING LIMIT AND OFFSET VALUE
    public static function checkLimitAndOffset($limit, $offset)
    {
        if (gettype($limit) == "integer" && gettype($offset) == "integer" && $limit > 0 && $offset >= 0) {
            return true;
        } else {
            return false;
        }
    }
}
