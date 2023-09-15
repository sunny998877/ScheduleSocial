<?php

namespace App\Libraries\Utilities;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class RequestValidation
{
    private $Request;
    private $rules;
    private $messages;

    public function __construct(Request $Request)
    {
        $this->Request = $Request;
        $this->messages = [];
    }

    /**
     * @return mixed
     */
    public function requestValidator()
    {
        $this->rules = [
            'socialType' => Constants::REQUIRED,
            'secret' => Constants::REQUIRED,
            'id' => Constants::REQUIRED,
            'baseUrl' => Constants::REQUIRED,
            'email' => Constants::REQUIRED,
            'redirect' => Constants::REQUIRED,
        ];

        return $this->returnValidator();
    }

    /**
     * @return Validator
     */
    public function schedulerValidation(): Validator
    {
        $this->rules = [
            'type' => Constants::REQUIRED,
            'period' => Constants::REQUIRED,
            'contentType' => Constants::REQUIRED,
            'timeSlot' => Constants::REQUIRED
        ];

        return $this->returnValidator();
    }

    /**
     * @return \Illuminate\Validation\Validator
     */
    private function returnValidator()
    {
        return \Validator::make($this->Request->all(), $this->rules, $this->messages);
    }
}
