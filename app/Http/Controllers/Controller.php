<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected const STATUS_CODE_ERROR = 500;
    protected const STATUS_CODE_CREATE = 202;
    protected const STATUS_CODE_UPDATE = 204;
    protected const STATUS_CODE_SUCCESS = 200;
}
