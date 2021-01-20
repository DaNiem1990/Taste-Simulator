<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotAuthorizedController extends BaseController
{

    public function notAuthorized(): JsonResponse
    {
        return $this->sendError('Not authorized', ['Nie masz uprawnień'], 401);
    }

}
