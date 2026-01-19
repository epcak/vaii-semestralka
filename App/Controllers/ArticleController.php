<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
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
            if ($clanok == NULL) {
                return $this->redirect($this->url("home.index"));
            }
            $obrazkyclanku = \App\Models\Articleimage::getAll('`article_id` like ?', [$idc]);
            $uvodnyobrazok = \App\Models\Image::getOne($clanok->getTitleImage());
            if ($uvodnyobrazok == NULL) {
                $uvodnyobrazok = 'images/defaultimage.png';
            } else {
                $uvodnyobrazok = $uvodnyobrazok.getLocation();
            }
            $obrazky = [];
            foreach ($obrazkyclanku as $obr) {
                $najorb = \App\Models\Image::getOne($obr->getImage());
                if ($najorb != NULL) {
                    array_push($obrazky, $najorb);
                }
            }
            return $this->html(["clanok" => $clanok, "obrazky" => $obrazky, "uvodnyobrazok" => $uvodnyobrazok]);
        }
        return $this->redirect($this->url("home.index"));
    }

    public function comments(Request $request): Response
    {
        return $this->html();
    }
}