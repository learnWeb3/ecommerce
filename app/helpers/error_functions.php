<?php

function renderError($error_code)
{
    require_once  ERROR_PATH . "/" . $error_code . ".php";
}
