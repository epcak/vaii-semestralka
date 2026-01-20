<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\HttpException;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\JsonResponse;
use App\Model\User;
use App\Model\Article;
use App\Model\Articleimage;
use App\Model\Comment;

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
            $obrazky = \App\Models\Image::getAll('`user` like ?', [$logeduser[0]->getUsername()]);
            $clanok = NULL;
            $priradeneobrazky = [];
            if ($request->hasValue('id')) {
                $idclanku = $request->value('id');
                $clanok = \App\Models\Article::getOne($idclanku);
                $priradene = \App\Models\Articleimage::getAll('`article_id` like ?', [$idclanku]);
                foreach ($priradene as $prdn) {
                    array_push($priradeneobrazky, $prdn->getImage());
                }
            }
            
            return $this->html(["obrazky" => $obrazky, "clanok" => $clanok, "priradene" => $priradeneobrazky]);
        }
        throw new HTTPException(401);
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
                if ($najdeny == NULL) {
                    $resp->status = "NotFound";
                } else {
                    if ($logeduser[0]->getUsername() != $najdeny->getAuthor()) {
                        throw new HTTPException(401);
                    } else {
                        $obrazky = \App\Models\Articleimage::getAll('`article_id` like ?', [$idc]);
                        foreach ($obrazky as $obr) $obr->delete();
                        $komentare = \App\Models\Comment::getAll('`article_id` like ?', [$idc]);
                        foreach ($komentare as $kom) $kom->delete();
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
        $resp = new \StdClass();
        if ($logedin && ($logeduser[0]->getRole() == 2 || $logeduser[0]->getRole() == 1)) {
            $data = $request->json();
            $clanok = NULL;
            if ($data->novy == true) {
                $clanok = new \App\Models\Article;
                $clanok->setTitleImage(-1);
                $clanok->setAuthor($logeduser[0]->getUsername());
            } else {
                $clanok = \App\Models\Article::getOne($data->id);
                $clanok->setEdited(date("Y-m-d H:i:s"));
                if ($clanok != NULL) if ($clanok->getAuthor() != $logeduser[0]->getUsername()) {
                    throw new HTTPException(401);
                }
            }
            if ($clanok == NULL) {
                $resp->status = "Nenesiel sa";
                return $this->json($resp);
            }
            $nazov = $data->nazov;
            if ($nazov == NULL || $nazov == "") {
                $resp->status = "Musi byt nazov";
                return $this->json($resp);
            }
            $text = addslashes($data->text);
            $clanok->setTitle($nazov);
            $clanok->setText($text);
            $clanok->save();

            $nove = [];
            $stale = [];
            $obrazkyclanku = $data->obrazky;
            $obrazkyaktualne = \App\Models\Articleimage::getAll('`article_id` like ?', [$clanok->getId()]);
            $obrazkyaktualneid = [];
            foreach ($obrazkyaktualne as $obr) array_push($obrazkyaktualneid ,$obr->getImage());
            foreach ($obrazkyclanku as $obr) {
                if (in_array($obr, $obrazkyaktualneid)) {
                    array_push($stale, $obr);
                } else {
                    array_push($nove, $obr);
                }
            }
            $artid = $clanok->getId();
            $navyradenie = array_diff($obrazkyaktualneid, $stale);
            foreach ($navyradenie as $vyrad) {
                $obra = \App\Models\Articleimage::getAll('`article_id` like ? and `image_id` like ?', [$artid, $vyrad]);
                foreach ($obra as $x) {
                    $x->delete();
                }
            }
            foreach ($nove as $novy) {
                $obra = new \App\Models\Articleimage;
                $obra->setArticle($artid);
                $obra->setImage($novy);
                $obra->save();
            }
            if ($clanok->getTitleImage() == -1 && sizeof($nove) > 0) {
                $clanok->setTitleImage($nove[0]);
                $clanok->save();
            } 
            $resp->status = "OK";
            $resp->articleid = $clanok->getId();
            return $this->json($resp);
        }
        throw new HTTPException(401);
    }
}