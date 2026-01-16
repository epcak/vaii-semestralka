<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\JsonResponse;

class SearchController extends BaseController
{
    public function index(Request $request): Response
    {
        return $this->html();
    }

    public function searchajax(Request $request): JsonResponse
    {
        
    }
}