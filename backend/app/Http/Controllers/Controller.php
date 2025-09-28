<?php

namespace App\Http\Controllers;

use App\Contracts\ResponseStrategy;

abstract class Controller
{
    protected ResponseStrategy $responder;

    public function __construct(ResponseStrategy $responder)
    {
        $this->responder = $responder;
    }
}
