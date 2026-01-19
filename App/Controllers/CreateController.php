<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\HttpException;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\JsonResponse;
use App\Model\User;

class CreateController extends BaseController
{
    public function index(Request $request): Response
    {
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            return $this->redirect($this->url('home.index'));
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']]);
        $logedin = false;
        foreach ($logeduser as $usr)
        {
            $logedin = $usr->hasSession($_COOKIE['session']);
            if ($logedin)
            {
                break;
            }
        }
        if ($logedin && ($logeduser[0]->getRole() == 2 || $logeduser[0]->getRole() == 1)) {
            $clanky = \App\Models\Article::getAll('`author` like ?', [$_COOKIE['username']]);
            $zverejnitelne = false;
            if ($logeduser[0]->getRole() == 2) $zverejnitelne = true;
            return $this->html(["clanky" => $clanky, "zverej" => $zverejnitelne]);
        }
        return $this->redirect($this->url('home.index'));
    }

    public function editor(Request $request): Response
    {
        return $this->html();
    }

    public function manage(Request $request): Response
    {
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            return $this->redirect($this->url('home.index'));
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']]);
        $logedin = false;
        foreach ($logeduser as $usr)
        {
            $logedin = $usr->hasSession($_COOKIE['session']);
            if ($logedin)
            {
                break;
            }
        }
        if ($logedin && $logeduser[0]->getRole() == 2) {
            $redaktor = $logeduser[0]->getUsername();
            $prispievatelia = \App\Models\User::getAll('`redactor` like ?', [$redaktor]);
            return $this->html(["prispievatenia" => $prispievatelia]);
        }
        throw new HTTPException(401);
    }

    public function subeditorarticles(Request $request): JsonResponse
    {
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            throw new HTTPException(401);
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']]);
        $logedin = false;
        foreach ($logeduser as $usr)
        {
            $logedin = $usr->hasSession($_COOKIE['session']);
            if ($logedin)
            {
                break;
            }
        }
        if ($logedin && $logeduser[0]->getRole() == 2) {
            $username = $request->json()->username;
            $clanky = \App\Models\Article::getAll('`author` like ?', [$username]);
            $nazvy = [];
            $idcka = [];
            $zverejnene = [];
            foreach ($clanky as $clanok) {
                array_push($nazvy, $clanok->getTitle());
                array_push($idcka, $clanok->getId());
                array_push($zverejnene, $clanok->getPublished());
            }
            $resp = new \StdClass();
            $resp->nazvy = $nazvy;
            $resp->id = $idcka;
            $resp->zverejnene = $zverejnene;
            return $this->json($resp);
        }
        throw new HTTPException(401);
    }

    public function changepublished(Request $request): JsonResponse
    {
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            throw new HTTPException(401);
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']]);
        $logedin = false;
        foreach ($logeduser as $usr)
        {
            $logedin = $usr->hasSession($_COOKIE['session']);
            if ($logedin)
            {
                break;
            }
        }
        if ($logedin && ($logeduser[0]->getRole() == 2)) {
            $data = $request->json();
            $idc = $data->articleid;
            $zverejnenie = $data->published;
            $resp = new \StdClass();
            if ($idc == NULL || $zverejnenie == NULL) {
                $resp->status = "InvalidInput" . $idc . $zverejnenie;
            } else {
                $najdeny = \App\Models\Article::getOne($idc);
                if ($najdeny == NULL) {
                    $resp->status = "NotFound";
                } else {
                    if ($zverejnenie == "true") {
                        $najdeny->setPublished(1);
                    } else {
                        $najdeny->setPublished(0);
                    }
                    $najdeny->save();
                    $resp->status = "OK";
                }
            }
            return $this->json($resp);
        }
        throw new HTTPException(401);
    }

    public function deletearticle(Request $request): JsonResponse
    {
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            throw new HTTPException(401);
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']]);
        $logedin = false;
        foreach ($logeduser as $usr)
        {
            $logedin = $usr->hasSession($_COOKIE['session']);
            if ($logedin)
            {
                break;
            }
        }
        if ($logedin && ($logeduser[0]->getRole() == 2 || $logeduser[0]->getRole() == 1)) {
            $data = $request->json();
            $idc = $data->articleid;
            $resp = new \StdClass();
            if ($idc == NULL) {
                $resp->status = "InvalidInput" . $idc . $zverejnenie;
            } else {
                $najdeny = \App\Models\Article::getOne($idc);
                if ($najdeny != NULL) {
                    if ($logeduser[0]->getUsername() != $najdeny->getAuthor()) throw new HTTPException(401);
                }
                if ($najdeny == NULL) {
                    $resp->status = "NotFound";
                } else {
                    if ($logeduser[0]->getUsername() != $najdeny->getAuthor()) {
                        throw new HTTPException(401);
                    } else {
                        $najdeny->delete();
                        $resp->status = "OK";
                    }
                }
            }
            return $this->json($resp);
        }
        throw new HTTPException(401);
    }

    public function save(Request $request): JsonResponse
    {
        
    }
}