<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\HttpException;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\JsonResponse;
use App\Model\User;
use App\Model\Article;
use App\Model\Comment;

class AdminController extends BaseController
{
    private function jeadmin(): bool
    {
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            return false;
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
            if ($logeduser[0]->getrole() == 9) {
                return true;
            }
        }
        return false;
    }

    public function index(Request $request): Response
    {
        if ($this->jeadmin() == false)
        {
            return $this->redirect($this->url('home.index'));
        }
        return $this->html();
    }

    public function articles(Request $request): Response
    {
        if ($this->jeadmin() == false)
        {
            return $this->redirect($this->url('home.index'));
        }
        return $this->html();
    }

    public function comments(Request $request): Response
    {
        if ($this->jeadmin() == false)
        {
            return $this->redirect($this->url('home.index'));
        }
        if ($request->hasValue('id'))
        {
            $ida = $request->get('id');
            $clanok = \App\Models\Article::getOne($ida);
            if ($clanok == null)
            {
                return $this->redirect($this->url('admin.index'));
            }
            $komentare = \App\Models\Comment::getAll('`article_id` like ?', [$ida]);
            return $this->html(['clanok' => $clanok, 'komentare' => $komentare]);
        }
        return $this->redirect($this->url('admin.index'));
    }

    public function users(Request $request): Response
    {
        if ($this->jeadmin() == false)
        {
            return $this->redirect($this->url('home.index'));
        }
        return $this->html();
    }

    public function user(Request $request): Response
    {
        if ($this->jeadmin() == false)
        {
            return $this->redirect($this->url('home.index'));
        }
        if ($request->hasValue('username'))
        {
            $username = $request->get('username');
            $usersee = \App\Models\User::getOne($username);
            if ($usersee == null)
            {
                return $this->redirect($this->url('admin.users'));
            }
            $redaktory = [];
            if ($usersee->getRole() == 1)
            {
                $redaktory = \App\Models\User::getAll('`role` like ?', [2]);
            }
            $clanky = \App\Models\Article::getAll('`author` like ?', [$username]);
            return $this->html(['founduser' => $usersee, 'clanky' => $clanky, 'redaktory' => $redaktory]);
        }
        return $this->redirect($this->url('admin.users'));
    }

    public function finduser(Request $request): JsonResponse
    {
        if ($this->jeadmin() == false)
        {
            throw new HTTPException(401);
        }
        $data = $request->json();
        $meno = $data->user;
        $najdeny = \App\Models\User::getAll('`username` like ?', ['%' . $meno . '%']);
        $mena = [];
        foreach ($najdeny as $uzv)
        {
            array_push($mena, $uzv->getUsername());
        }
        return $this->json($mena);
    }

    public function banuser(Request $request): JsonResponse
    {
        if ($this->jeadmin() == false)
        {
            throw new HTTPException(401);
        }
        $data = $request->json();
        $meno = $data->user;
        $level = $data->level;
        $resp = new \StdClass();
        if ($meno == NULL) {
            $resp->status = "InvalidInput" . $meno . $level;
        } else {
            $najdeny = \App\Models\User::getOne($meno);
            if ($najdeny == NULL) {
                $resp->status = "NotFound";
            } else {
                $najdeny->setBan(intval($level));
                $najdeny->save();
                $resp->status = "OK";
            }
        }
        return $this->json($resp);
    }

    public function changerole(Request $request): JsonResponse
    {
        if ($this->jeadmin() == false)
        {
            throw new HTTPException(401);
        }
        $data = $request->json();
        $meno = $data->user;
        $rola = $data->role;
        $resp = new \StdClass();
        if ($meno == NULL || !($rola == 0 || $rola == 1 || $rola == 2 || $rola == 9)) {
            $resp->status = "InvalidInput" . $meno . $rola;
        } else {
            $najdeny = \App\Models\User::getOne($meno);
            if ($najdeny == NULL) {
                $resp->status = "NotFound";
            } else {
                $najdeny->setRole(intval($rola));
                $najdeny->save();
                $resp->status = "OK";
            }
        }
        return $this->json($resp);
    }

    public function updateuserredactor(Request $request): JsonResponse
    {
        if ($this->jeadmin() == false)
        {
            throw new HTTPException(401);
        }
        $data = $request->json();
        $meno = $data->user;
        $redaktor = $data->redactor;
        $resp = new \StdClass();
        if ($meno == NULL || $redaktor == NULL) {
            $resp->status = "InvalidInput" . $meno . $redaktor;
        } else {
            $najdeny = \App\Models\User::getOne($meno);
            if ($najdeny == NULL) {
                $resp->status = "NotFound";
            } else {
                if ($redaktor == "ziaden") {
                    $najdeny->setRedactor(NULL);
                } else {
                    $najdeny->setRedactor($redaktor);
                }
                $najdeny->save();
                $resp->status = "OK";
            }
        }
        return $this->json($resp);
    }

    public function searcharticles(Request $request): JsonResponse
    {
        if ($this->jeadmin() == false)
        {
            throw new HTTPException(401);
        }
        $data = $request->json();
        $hladane = $data->searched;
        $clanky = \App\Models\Article::getAll('`title` like ?', ['%' . $hladane . '%']);
        $resp = new \StdClass();
        $mena = [];
        $idclanky = [];
        $zverejnene = [];
        foreach ($clanky as $atr)
        {
            array_push($mena, $atr->getTitle());
            array_push($idclanky, $atr->getId());
            array_push($zverejnene, $atr->getPublished());
        }
        $resp->mena = $mena;
        $resp->id = $idclanky;
        $resp->zverejnene = $zverejnene;
        return $this->json($resp);
    }

    public function changepublished(Request $request): JsonResponse
    {
        if ($this->jeadmin() == false)
        {
            throw new HTTPException(401);
        }
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

    public function deletearticle(Request $request): JsonResponse
    {
        if ($this->jeadmin() == false)
        {
            throw new HTTPException(401);
        }
        $data = $request->json();
        $idc = $data->articleid;
        $resp = new \StdClass();
        if ($idc == NULL) {
            $resp->status = "InvalidInput" . $idc;
        } else {
            $najdeny = \App\Models\Article::getOne($idc);
            if ($najdeny == NULL) {
                $resp->status = "NotFound";
            } else {
                $komentare = \App\Models\Comment::getAll('`article_id` like ?', [$idc]);
                foreach ($komentare as $komentar) {
                    $komentar->delete();
                }
                $najdeny->delete();
                $resp->status = "OK";
            }
        }
        return $this->json($resp);
    }

    public function deletecomment(Request $request): JsonResponse
    {
        if ($this->jeadmin() == false)
        {
            throw new HTTPException(401);
        }
        $data = $request->json();
        $idc = $data->commentid;
        $resp = new \StdClass();
        if ($idc == NULL) {
            $resp->status = "InvalidInput" . $idc;
        } else {
            $najdeny = \App\Models\Comment::getOne($idc);
            if ($najdeny == NULL) {
                $resp->status = "NotFound";
            } else {
                $najdeny->delete();
                $resp->status = "OK";
            }
        }
        return $this->json($resp);
    }
}
