<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\JsonResponse;
use App\Model\User;

class CreateController extends BaseController
{
    public function index(Request $request): Response
    {
        return $this->html();
    }

    public function editor(Request $request): Response
    {
        return $this->html();
    }

    public function manage(Request $request): Response
    {
        return $this->html();
    }

    public function save(Request $request): JsonResponse
    {
        
    }
}