<?php

namespace App\Http\Controllers;

use App\Traits\ExceptionTrait;
use App\Traits\ReturnResponse;

abstract class Controller
{
    use ExceptionTrait, ReturnResponse;
}
