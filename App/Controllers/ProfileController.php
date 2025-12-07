<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use App\Model\User;

class ProfileController extends BaseController
{
    public function authorize(Request $request, string $action): bool
    {
        return true;
    }

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
        if ($logedin) {
            return $this->html(['logeduser' => $logeduser[0]]);
        }
        return $this->redirect($this->url('home.index'));
    }

    public function profile(Request $request): Response
    {
        if (!$request->hasValue('name')) {
            return $this->redirect($this->url('notfound'));
        }
        $usrname = $request->get('name');
        $foundusers = \App\Models\User::getAll('`username` like ?', [$usrname]);
        if (!\sizeof($foundusers) == 1) {
            return $this->redirect($this->url('notfound'));
        }

        return $this->html(
            [
                'username' => $usrname,
                'displayname' => $foundusers[0]->getDisplayname(),
                'descrition' => $foundusers[0]->getDescription()
            ]
            );
    }

    public function notfound(Request $request): Response
    {
        return $this->html();
    }

    public function logout(Request $request): Response
    {
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            return $this->redirect($this->url('home.index'));
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']])[0];
        $logeduser->deleteSession($_COOKIE['session']);
        setcookie('username', '', time() - 10000);
        setcookie('session', '', time() - 10000);
        return $this->redirect($this->url('home.index'));
    }
}