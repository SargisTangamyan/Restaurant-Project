<?php

namespace App\Http\Controllers;

use App\Contracts\ResponseStrategy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected ResponseStrategy $responder;

    public function __construct(ResponseStrategy $responder)
    {
        $this->responder = $responder;
    }
}
