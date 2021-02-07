<?php

namespace App\Validations;

use App\Validations\Protocols\Validation;

class ValidationComposite extends Validation
{
    public $validations;
    public function __construct($validations = [])
    {
        parent::__construct();
        $this->validations = $validations;
    }

    public function validate($input)
    {
        foreach ($this->validations as $validation)
        {
            $error = $validation->validate($input);
            if($error)
            {
                return $error;
            }
        }
    }
}
