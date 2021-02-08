<?php

namespace App\Validations;

use App\Validations\Protocols\Validation;
use App\Presentation\Helpers\Http\HttpResponse;

class EntryExistsValidation extends Validation
{
    public $fieldName;
    public function __construct($fieldName)
    {
        parent::__construct();
        $this->fieldName = $fieldName;
    }

    public function validate($input)
    {
        if(empty($input[$this->fieldName]) || count($input[$this->fieldName]) <= 0)
        {
            $httpResponse = new HttpResponse();
            $error = $httpResponse->notFound($this->fieldName);
            return $error;
        }
    }
}
