<?php

namespace App\Presentation\Protocols;

use App\Presentation\Errors\ImplementationError;

class Controller
{
    public function __construct()
    {
        if (!method_exists($this, 'handle'))
        {
            throw new ImplementationError();
        }
    }
}
