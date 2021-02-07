<?php

namespace App\Validations\Protocols;

use App\Presentation\Errors\ImplementationError;

class Validation
{
  public function __construct()
  {
    if (!method_exists($this, 'validate'))
    {
      throw new ImplementationError();
    }
  }
}
