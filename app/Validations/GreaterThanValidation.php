<?php

namespace App\Validations;

use App\Validations\Protocols\Validation;
use App\Presentation\Helpers\Http\HttpResponse;

class GreaterThanValidation extends Validation
{
    public $fieldName;
    public $fieldToCompare;
    public function __construct($fieldName, $fieldToCompare)
    {
        parent::__construct();
        $this->fieldName = $fieldName;
        $this->fieldToCompare = $fieldToCompare;
    }

    public function validate($input)
    {
        if ($input[$this->fieldToCompare] > $input[$this->fieldName])
        {
            $httpResponse = new HttpResponse();
            $error = $httpResponse->customizeError(400, 'Invalid value to param: ' . $this->fieldName);
            return $error;
        }
    }
}
