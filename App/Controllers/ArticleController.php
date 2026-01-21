<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\JsonResponse;
use App\Model\Article;
use App\Model\Articleimage;
use App\Model\Image;
use App\Model\Comment;
use App\Model\User;

class ArticleController extends BaseController
{
    public function index(Request $request): Response
    {
        if ($request->hasValue('id')) {
            $idc = $request->value('id');
            $clanok = \App\Models\Article::getOne($idc);
            if ($clanok == NULL || $clanok->getPublished() != 1) {
                return $this->redirect($this->url("home.index"));
            }
            $obrazkyclanku = \App\Models\Articleimage::getAll('`article_id` like ?', [$idc]);
            $uvodnyobrazok = \App\Models\Image::getOne($clanok->getTitleImage());
            if ($uvodnyobrazok == NULL) {
                $uvodnyobrazok = 'images/defaultimage.png';
            } else {
                $uvodnyobrazok = $uvodnyobrazok->getLocation();
            }
            $obrazky = [];
            foreach ($obrazkyclanku as $obr) {
                $najorb = \App\Models\Image::getOne($obr->getImage());
                if ($najorb != NULL) {
                    array_push($obrazky, $najorb);
                }
            }
            $clanok->addView();
            $clanok->save();
            return $this->html(["clanok" => $clanok, "obrazky" => $obrazky, "uvodnyobrazok" => $uvodnyobrazok]);
        }
        return $this->redirect($this->url("home.index"));
    }

    public function comments(Request $request): Response
    {
        if (!$request->hasValue("id")) {
            return $this->redirect($this->url("home.index"));
        }
        $prihlaseny = false;
        $uzivatel = "";
        if (array_key_exists('username', $_COOKIE) && array_key_exists('session', $_COOKIE)) {
            $prihlaseny = true;
            $uzivatel = $_COOKIE['username'];
        }

        $shadow = [];
        $perma = [];
        $uzivatelia = \App\Models\User::getAll('`ban` like 1');
        foreach ($uzivatelia as $uzv) {
            array_push($shadow, $uzv->getUsername());
        }
        $uzivatelia = \App\Models\User::getAll('`ban` like 2');
        foreach ($uzivatelia as $uzv) {
            array_push($perma, $uzv->getUsername());
            if ($uzv->getUsername() == $uzivatel) {
                $prihlaseny = false;
                $uzivatel = "";
            }
        }

        $komentare = \App\Models\Comment::getAll('`article_id` like ?', [$request->value('id')]);
        $clanok = \App\Models\Article::getOne($request->value('id'));
        if ($clanok == NULL || $clanok->getPublished() != 1) return $this->redirect($this->url("home.index"));
        
        return $this->html(["prihlaseny" => $prihlaseny, "uzivatel" => $uzivatel, "komentare" => $komentare, "clanok" =>$clanok, "shadow" => $shadow, "perma" => $perma]);
    }

    public function commentsave(Request $request): JsonResponse
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
        if ($logedin) {
            $resp = new \StdClass();
            $data = $request->json();
            $idkomentar = $data->id;
            $text = $data->text;
            $novy = $data->novy;
            $clanokid = $data->clanok;
            if ($idkomentar == NULL || $text == NULL || $clanokid == NULL) {
                $resp->status = "Nespravne argumenty";
                return $this->json($resp);
            }
            if ($novy == true) {
                $komentar = new \App\Models\Comment;
                $komentar->setArticle(intval($clanokid));
                $komentar->setUser($_COOKIE['username']);
                $komentar->setComment(addslashes($text));
                $komentar->save();
            } else {
                $komentar = \App\Models\Comment::getOne($idkomentar);
                if ($komentar == NULL) {
                    $resp->status = "Komentár nenájdený";
                    return this->json($resp);
                }
                if ($_COOKIE['username'] != $komentar->getUser()) {
                    throw new HTTPException(401);
                }
                $komentar->setComment($text);
                $komentar->save();
            }
            $resp->status = "OK";
            return $this->json($resp);
        }
        throw new HTTPException(401);
    }

    public function commentdelete(Request $request): JsonResponse
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
        if ($logedin) {
            $resp = new \StdClass();
            $data = $request->json();
            $idkomentar = $data->id;
            $clanokid = $data->clanok;
            if ($idkomentar == NULL || $clanokid == NULL) {
                $resp->status = "Nespravne argumenty";
                return this->json($resp);
            }
            $komentar = \App\Models\Comment::getOne($idkomentar);
            if ($komentar == NULL) {
                $resp->status = "Komentár nenájdený";
                return $this->json($resp);
            }
            if ($_COOKIE['username'] != $komentar->getUser()) {
                throw new HTTPException(401);
            }
            $komentar->setDeleted(1);
            $komentar->save();
            $resp->status = "OK";
            return $this->json($resp);
        }
        throw new HTTPException(401);
    }
}