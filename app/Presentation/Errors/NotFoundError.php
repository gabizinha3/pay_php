<?php

namespace App\Presentation\Errors;

use App\Presentation\Errors\Errors;

class NotFoundError extends Errors
{
    public function __construct($paramName)
    {
        parent::__construct('Not Found: ' . $paramName);
    }
}
