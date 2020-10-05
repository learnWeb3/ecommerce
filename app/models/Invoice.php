<?php


class Invoice
{
    protected $basket_id;
    protected $total_amount_ttc;
    protected $total_amount_ht;
    protected $items;
    protected $payment_intent_id;
    protected $card;
    protected $full_adress;

    // USING COMMON METHODS
    use Db;


    public function __construct($basket_id, $total_amount_ttc, $total_amount_ht, $adress_id, $payment_intent_id, $id = null, $created_at = null, $updated_at = null)
    {
        $this->basket_id = $basket_id;
        $this->total_amount_ttc = number_format($total_amount_ttc, 2);
        $this->total_amount_ht = number_format($total_amount_ht, 2);
        $this->adress_id = $adress_id;
        $this->items = $this->getItems();
        $this->payment_intent_id = $payment_intent_id;
        $this->card = $this->retrieveCardDetails();
        $this->full_adress = $this->setFullAdress($this->adress_id);
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


    // GETTERS ATTRIBUTES

    public function getTotalAmountTTC()
    {
        return htmlspecialchars($this->total_amount_ttc);
    }


    public function getTotalAmountHT()
    {
        return htmlspecialchars($this->total_amount_ht);
    }


    public function getFullAdress()
    {
        return htmlspecialchars($this->full_adress);
    }

    public function getCardDetailsNumber()
    {
        return "**** **** **** " . $this->card->charges->data[0]->payment_method_details->card->last4;
    }

    public function getCardDetailsExpDate()
    {
        return $this->card->charges->data[0]->payment_method_details->card->exp_month . "/" . $this->card->charges->data[0]->payment_method_details->card->exp_year;
    }


    public function getCardType()
    {
        return $this->card->charges->data[0]->payment_method_details->card->brand;
    }

    public function getItems()
    {
        $connection = Db::connect();
        $statement = "SELECT * FROM basket_items WHERE basket_id=?";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($this->basket_id));

        $results = [];

        while ($row = $prepared_statement->fetch()) {
            $book = Book::find($row["book_id"])[0];
            $results[] = new BasketItem($row["book_id"], $row['basket_id'], $book, $row['quantity'], $row['id'], $row['created_at'], $row['updated_at']);
        }

        return $results;
    }


    // CREATE ACTION 
    public function create()
    {
        $connection = Db::connect();
        $statement = "INSERT INTO invoices (basket_id,total_amount_ttc,total_amount_ht, adress_id,payment_intent_id) VALUES (?,?,?,?,?)";
        $prepared_statement = $connection->prepare($statement);
        return $prepared_statement->execute(array(intval($this->basket_id), $this->total_amount_ttc, $this->total_amount_ht, $this->adress_id, $this->payment_intent_id));
    }


    // RETRIEVING INOICE AND ASSOCIATED RECORDS 

    public static function findInvoice(int $invoice_id)
    {
        $connection = Db::connect();
        $statement = "SELECT 
        invoices.id as invoice_id, 
        invoices.basket_id as invoice_basket_id, 
        invoices.total_amount_ttc as invoice_total_amount_ttc,
        invoices.total_amount_ht as invoice_total_amount_ht,
        invoices.adress_id as invoice_adress_id,
        invoices.payment_intent_id as invoice_payment_id,
        invoices.id as invoice_id,
        invoices.created_at as invoice_created_at,
        invoices.updated_at as invoice_updated_at,
        adresses.id as adress_id,
        adresses.adress as adress_adress,
        adresses.city as adress_city,
        adresses.postal_code as adress_postal_code
        FROM invoices 
        JOIN adresses ON adresses.id = invoices.adress_id
        WHERE invoices.id=?";

        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($invoice_id));

        $results = [];

        while ($row = $prepared_statement->fetch()) {
            $results[] = array(
                "invoice" => new Invoice($row['invoice_basket_id'], $row['invoice_total_amount_ttc'], $row['invoice_total_amount_ht'], $row['adress_id'], $row['invoice_payment_id'], $row['invoice_id'], $row['invoice_created_at'], $row['invoice_updated_at'])
            );
        }

        return $results;
    }


    // RETRIEVING CARD DETAILS ON STRIPE BY FETCHING PAYMENT INTENT OBJECT
    public function retrieveCardDetails()
    {
        $app_stripe = new AppStripe(STRIPE_SECRET_KEY);
        return $app_stripe->retrievePaymentIntent($this->payment_intent_id);
    }

    // SET FULL ADRESS AS ATTRIBUTE OF MODEL
    public function setFullAdress($adress_id)
    {
        $connection = Db::connect();
        $statement = "SELECT * FROM adresses WHERE id=?";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($adress_id));
        $results = $prepared_statement->fetchAll(PDO::FETCH_ASSOC)[0];
        return $results["adress"] . " " . $results["city"] . " " . $results["postal_code"];
    }



    // DISPLAY OF ANALYTICS 

    public static function getRevenue($periodicity)
    {   
        $connection = Db::connect();
        $to = time(); // current time in epoch
        $from = time() - $periodicity * (24 * 60 * 60); // to seconds 
        $statement = "SELECT 
        SUM(total_amount_ttc) as total_amount_ttc,
        SUM(total_amount_ht) as total_amount_ht
        FROM invoices WHERE created_at BETWEEN ? AND ?";

        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($from, $to));
    }
    
}
