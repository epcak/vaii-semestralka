<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\JsonResponse;
use App\Model\Article;
use App\Model\Image;

class HomeController extends BaseController
{
    public function index(Request $request): Response
    {
        $clanky = \App\Models\Article::getAll('`tags` like ? and published like 1', ["%top%"]);
        $obrazky = [];
        foreach ($clanky as $clanok) {
            $uvodnyobrazok = \App\Models\Image::getOne($clanok->getTitleImage());
            if ($uvodnyobrazok == NULL) {
                $uvodnyobrazok = 'images/defaultimage.png';
            } else {
                $uvodnyobrazok = $uvodnyobrazok->getLocation();
            }
            array_push($obrazky, $uvodnyobrazok);
        }
        return $this->html(["clanky" => $clanky, "obrazky" => $obrazky]);
    }

    public function new(Request $request): Response
    {
        $clanky = \App\Models\Article::getAll('published like 1 order by created_at desc limit 15', []);
        $obrazky = [];
        foreach ($clanky as $clanok) {
            $uvodnyobrazok = \App\Models\Image::getOne($clanok->getTitleImage());
            if ($uvodnyobrazok == NULL) {
                $uvodnyobrazok = 'images/defaultimage.png';
            } else {
                $uvodnyobrazok = $uvodnyobrazok->getLocation();
            }
            array_push($obrazky, $uvodnyobrazok);
        }
        return $this->html(["clanky" => $clanky, "obrazky" => $obrazky]);
    }

    public function popular(Request $request): Response
    {
        $clanky = \App\Models\Article::getAll('published like 1 order by view desc limit 15', []);
        $obrazky = [];
        foreach ($clanky as $clanok) {
            $uvodnyobrazok = \App\Models\Image::getOne($clanok->getTitleImage());
            if ($uvodnyobrazok == NULL) {
                $uvodnyobrazok = 'images/defaultimage.png';
            } else {
                $uvodnyobrazok = $uvodnyobrazok->getLocation();
            }
            array_push($obrazky, $uvodnyobrazok);
        }
        return $this->html(["clanky" => $clanky, "obrazky" => $obrazky]);
    }

    public function loadmorenew(Request $request): JsonResponse
    {
        $data = $request->json();
        $nacitane = $data->nacitane;
        $clanky = \App\Models\Article::getAll('published like 1 order by created_at desc limit 10 offset ' . intval($nacitane));
        $resp = new \StdClass();
        $nazvy = [];
        $idclanky = [];
        foreach ($clanky as $atr)
        {
            array_push($nazvy, $atr->getTitle());
            array_push($idclanky, $atr->getId());
        }
        $resp->nazvy = $nazvy;
        $resp->id = $idclanky;
        return $this->json($resp);
    }

    public function loadmorepopular(Request $request): JsonResponse
    {
        $data = $request->json();
        $nacitane = $data->nacitane;
        $clanky = \App\Models\Article::getAll('published like 1 order by view desc limit 10 offset ' . intval($nacitane));
        $resp = new \StdClass();
        $nazvy = [];
        $idclanky = [];
        foreach ($clanky as $atr)
        {
            array_push($nazvy, $atr->getTitle());
            array_push($idclanky, $atr->getId());
        }
        $resp->nazvy = $nazvy;
        $resp->id = $idclanky;
        return $this->json($resp);
    }
}
