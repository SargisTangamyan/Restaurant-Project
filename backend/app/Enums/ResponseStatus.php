<?php

namespace App\Enums;

enum ResponseStatus: int
{
    // Success
    case SUCCESS = 200;
    case CREATED = 201;

    // Client errors
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case CONFLICT = 409;
    case UNPROCESSABLE = 422;

    // Server errors
    case INTERNAL_ERROR = 500;
}
