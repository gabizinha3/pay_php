<?php

namespace App\Validations;

use App\Validations\Protocols\Validation;
use App\Presentation\Helpers\Http\HttpResponse;

class RequiredFieldValidation extends Validation
{
    public $fieldName;
    public function __construct($fieldName)
    {
        parent::__construct();
        $this->fieldName = $fieldName;
    }

    public function validate($input)
    {
        if(empty($input[$this->fieldName]))
        {
            $httpResponse = new HttpResponse();
            $error = $httpResponse->badRequest($this->fieldName);
            return $error;
        }
    }
}
