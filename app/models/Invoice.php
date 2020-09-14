<?php 


class Invoice extends DbRecords
{
    protected $accountance_id;
    protected $order_id;
    protected $total_amount;
    protected $stripe_customer_id;


    public function __construct($accountance_id,$order_id,$total_amount,$stripe_customer_id)
    {
        $this->accountance_id=$accountance_id;
        $this->order_id=$order_id;
        $this->total_amount=$total_amount;
        $this->stripe_customer_id=$stripe_customer_id;
        parent::__construct();
    }


}