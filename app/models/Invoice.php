<?php 


class Invoice extends DbRecords
{
    protected $basket_id;
    protected $total_amount_ttc;
    protected $total_amount_ht;
    protected $items;


    public function __construct($basket_id,$total_amount_ttc,$total_amount_ht,$adress_id)
    {
        $this->basket_id=$basket_id;
        $this->total_amount_ttc=$total_amount_ttc;
        $this->total_amount_ht=$total_amount_ht;
        $this->adress_id = $adress_id;
        $this->items = $this->getItems();
        parent::__construct();
    }


    private function getItems()
    {
        $connection = Db::connect();
        $statement = "SELECT * FROM basket_items WHERE basket_id=?";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($this->basket_id));
        
        $results = [];
        
        while($row = $prepared_statement->fetch())
        {
            $book = Book::find($row["book_id"])[0];
            $results[] = new BasketItem($row["book_id"], $row['basket_id'], $book, $row['quantity'], $row['id'], $row['created_at'], $row['updated_at']);
        }

        return $results;
    }


    public function create()
    {
        $connection = Db::connect();
        $statement = "INSERT INTO invoices (basket_id,total_amount_ttc,total_amount_ht, adress_id) VALUES (?,?,?,?)";
        $prepared_statement = $connection->prepare($statement);
        return $prepared_statement->execute(array($this->basket_id, $this->total_amount_ttc, $this->total_amount_ht, $this->adress_id));
    }


}