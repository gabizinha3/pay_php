<?php

namespace App\Presentation\Errors;

use App\Presentation\Errors\Errors;

class InvalidParamError extends Errors
{
    public function __construct($paramName)
    {
        parent::__construct('Invalid param: ' . $paramName);
    }
}
