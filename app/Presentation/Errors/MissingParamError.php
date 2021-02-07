<?php

namespace App\Presentation\Errors;

use App\Presentation\Errors\Errors;

class MissingParamError extends Errors
{
    public function __construct($paramName)
    {
        parent::__construct('Missing param: ' . $paramName);
    }
}
