<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class ArticleController extends BaseController
{
    public function article(Request $request): Response
    {
        return $this->html();
    }

    public function comments(Request $request): Response
    {
        return $this->html();
    }

    public function index(Request $request): Response
    {
        return $this->redirect($this->url("article"));
    }
}