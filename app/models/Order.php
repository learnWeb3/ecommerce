<?php

class Order extends DbRecords
{
    protected $basket_id;
    protected $state_id;
    protected $delivery_fee_id;
    protected $stripe_session_object;

    public function __construct(int $basket_id,int $state_id,int $delivery_fee_id, object $stripe_session_object)
    {
        $this->basket_id = $basket_id;
        $this->state_id = $state_id;
        $this->delivery_fee_id = $delivery_fee_id;
        $this->stripe_session_object = $stripe_session_object;
        parent::__construct();
    }


    public function unsetStripeSession()
    {
        unset($this->stripe_session_object);
        return $this;
    }



}