<?php

namespace App\Presentation\Errors;

use Exception;

class ImplementationError extends Exception
{
    public function __construct()
    {
        parent::__construct('Implementation Required');
    }
}
