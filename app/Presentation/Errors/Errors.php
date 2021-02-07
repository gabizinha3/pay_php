<?php

namespace App\Presentation\Errors;

class Errors
{
    public $message;
    public function __construct($msg)
    {
        $this->message = $msg;
    }
}
