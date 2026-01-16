<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\JsonResponse;
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

    public function gallery(Request $request): Response
    {
        return $this->html();
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
        $logeduser->save();
        setcookie('username', '', time() - 10000);
        setcookie('session', '', time() - 10000);
        return $this->redirect($this->url('home.index'));
    }

    public function changedisplayname(Request $request): JsonResponse
    {
        $data = $request->json();
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            $resp = new \StdClass();
            $resp->status = "Užívateľ neprihlásený.";
            return $this->json($resp);
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']])[0];
        $logeduser->setDisplayname($data->displayname);
        $logeduser->save();
        $resp = new \StdClass();
        $resp->status = "OK";
        return $this->json($resp);
    }

    public function changedescription(Request $request): JsonResponse
    {
        $data = $request->json();
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            $resp = new \StdClass();
            $resp->status = "Užívateľ neprihlásený.";
            return $this->json($resp);
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']])[0];
        $logeduser->setDescription($data->description);
        $logeduser->save();
        $resp = new \StdClass();
        $resp->status = "OK";
        return $this->json($resp);
    }

    public function changeemail(Request $request): JsonResponse
    {
        $data = $request->json();
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            $resp = new \StdClass();
            $resp->status = "Užívateľ neprihlásený.";
            return $this->json($resp);
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']])[0];
        $passhash = $logeduser->getPassword();
        if (!password_verify($data->password, $passhash))
        {
            $resp = new \StdClass();
            $resp->status = "Heslo sa nezhoduje.";
            return $this->json($resp);
        }
        $logeduser->setEmail($data->email);
        $logeduser->save();
        $resp = new \StdClass();
        $resp->status = "OK";
        return $this->json($resp);
    }

    public function changepassword(Request $request): JsonResponse
    {
        $data = $request->json();
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            $resp = new \StdClass();
            $resp->status = "Užívateľ neprihlásený.";
            return $this->json($resp);
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']])[0];
        $passhash = $logeduser->getPassword();
        if (!password_verify($data->password, $passhash))
        {
            $resp = new \StdClass();
            $resp->status = "Heslo sa nezhoduje.";
            return $this->json($resp);
        }
        $logeduser->setPassword(password_hash($data->newpassword, PASSWORD_DEFAULT));
        $logeduser->save();
        $resp = new \StdClass();
        $resp->status = "OK";
        return $this->json($resp);
    }

    public function deleteaccount(Request $request): JsonResponse
    {
        $data = $request->json();
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            $resp = new \StdClass();
            $resp->status = "Užívateľ neprihlásený.";
            return $this->json($resp);
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']])[0];
        $passhash = $logeduser->getPassword();
        if (!password_verify($data->password, $passhash))
        {
            $resp = new \StdClass();
            $resp->status = "Heslo sa nezhoduje.";
            return $this->json($resp);
        }
        $logeduser->delete();
        setcookie('username', '', time() - 10000);
        setcookie('session', '', time() - 10000);
        $resp = new \StdClass();
        $resp->status = "OK";
        return $this->json($resp);
    }

    public function deletesessions(Request $request): JsonResponse
    {
        $data = $request->json();
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            $resp = new \StdClass();
            $resp->status = "Užívateľ neprihlásený.";
            return $this->json($resp);
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']])[0];
        $passhash = $logeduser->getPassword();
        if (!password_verify($data->password, $passhash))
        {
            $resp = new \StdClass();
            $resp->status = "Heslo sa nezhoduje.";
            return $this->json($resp);
        }
        $logeduser->setSession("");
        $logeduser->save();
        setcookie('username', '', time() - 10000);
        setcookie('session', '', time() - 10000);
        $resp = new \StdClass();
        $resp->status = "OK";
        return $this->json($resp);
    }
}