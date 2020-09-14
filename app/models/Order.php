<?php

class Order extends DbRecords
{
    protected $basket_id;
    protected $state_id;
    protected $delivery_fee_id;

    public function __construct(int $basket_id,int $state_id,int $delivery_fee_id)
    {
        $this->basket_id = $basket_id;
        $this->state_id = $state_id;
        $this->delivery_fee_id = $delivery_fee_id;
        parent::__construct();
    }



}