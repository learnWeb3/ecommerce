<?php 

class Session
{

    protected $id;

    public function __construct()
    {
        $this->init();
        $this->id = session_id();
    }
    public function init()
    {
        if (!isset($_SESSION))
        {
            session_start();
        }
    }
}