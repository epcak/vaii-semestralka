<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\JsonResponse;
use App\Model\Article;
use App\Model\Image;
use App\Model\User;

class SearchController extends BaseController
{
    public function index(Request $request): Response
    {
        return $this->html();
    }

    public function getsearch(Request $request): JsonResponse
    {
        $data = $request->json();
        $typ = $data->typ;
        $hladane = $data->hladane;
        $offsetprofily = intval($data->offsetprofily);
        $offsetclanky = intval($data->offsetclanky);
        $resp = new \StdClass();
        if ($typ == NULL || $hladane == NULL) {
            $resp->status = "Nespravne argumenty";
            return $this->json($resp);
        } else {
            $typy = [];
            $idcka = [];
            $obrazky = [];
            $nazvy = [];
            $texty = [];
            if ($typ == "vsetko" || $typ == "clanky") {
                $clanky = \App\Models\Article::getAll('published like 1 and title like ? limit 5 offset ' . $offsetclanky, ['%' . $hladane . '%']);
                foreach ($clanky as $clanok) {
                    array_push($typy, "clanok");
                    array_push($idcka, $clanok->getId());
                    $obrazok = \App\Models\Image::getOne($clanok->getTitleImage());
                    if ($obrazok == NULL) {
                        array_push($obrazky, "/images/defaultimage.png");
                    } else {
                        array_push($obrazky, $obrazok->getLocation());
                    }
                    array_push($nazvy, $clanok->getTitle());
                    array_push($texty, mb_substr($clanok->getText(), 0, 200) . "...");
                }
            }
            if ($typ == "vsetko" || $typ == "profily") {
                $profily = \App\Models\User::getAll('username like ? or displayname like ? limit 5 offset ' . $offsetprofily, ['%' . $hladane . '%', '%' . $hladane . '%']);
                foreach ($profily as $profil) {
                    array_push($typy, "profil");
                    array_push($idcka, -1);
                    array_push($obrazky, "");
                    array_push($nazvy, $profil->getUsername());
                    array_push($texty, $profil->getUsername());
                }
            }
            return $this->json(["typy" => $typy, "id" => $idcka, "obrazky" => $obrazky, "nazvy" => $nazvy, "texty" => $texty]);
        }
    }
}