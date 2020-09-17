<?php

class OrderController extends ApplicationController
{
    public function create()
    {
        if (isset($_POST['remote'])) {
        }
    }

    public function new()
    {
        if (isset($_GET['step'])) {
            if ($_GET['step'] == "1") {
            } elseif ($_GET['step'] == "2") {
            } elseif ($_GET['step'] == "3") {
            }
        }
    }
}
