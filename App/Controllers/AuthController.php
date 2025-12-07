<?php

namespace App\Controllers;

use App\Configuration;
use Exception;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\JsonResponse;
use Framework\Http\Responses\ViewResponse;
use App\Models\User;

/**
 * Class AuthController
 *
 * This controller handles authentication actions such as login, logout, and redirection to the login page. It manages
 * user sessions and interactions with the authentication system.
 *
 * @package App\Controllers
 */
class AuthController extends BaseController
{
    /**
     * Redirects to the login page.
     *
     * This action serves as the default landing point for the authentication section of the application, directing
     * users to the login URL specified in the configuration.
     *
     * @return Response The response object for the redirection to the login page.
     */
    public function index(Request $request): Response
    {
        return $this->redirect(Configuration::LOGIN_URL);
    }

    public function login(Request $request): Response
    {
        return $this->html();
    }

    public function loginer(Request $request): JsonResponse
    {
        $status = "";
        $newSession = 0;
        $username = "";
        $data = $request->json();
        $posibleuser = \App\Models\User::getAll('`username` like ? or `email` like ?', [$data->username, $data->username]);
        if (sizeof($posibleuser) == 1) {
            if (password_verify($data->password, $posibleuser[0]->getPassword()))
            {
                $status = "OK";
                do {
                    $newSession = rand();
                    $posibleusers = \App\Models\User::getAll('`session` like ?', [$newSession]);
                } while (sizeof($posibleusers) > 0);
                $posibleuser[0]->addSession($newSession);
                $posibleuser[0]->save();
                $username = $posibleuser[0]->getUsername();
                setcookie("username", $username);
                setcookie("session", $newSession);
            } else {
                $status = "Heslo sa nazhoduje.";
            }
        } else {
            $status = "Nenájdený užívateľ.";
        }
        $resp = new \StdClass();
        $resp->status = $status;
        return $this->json($resp);
    }

    public function register(Request $request): Response
    {
        return $this->html();
    }

    public function registeror(Request $request): JsonResponse
    {
        $status = "";
        $newSession = 0;
        if ($request->isJson())
        {
            $data = $request->json();
            $posibleusersname = \App\Models\User::getAll('`username` like ?', [$data->username]);
            $posibleusersemail = \App\Models\User::getAll('`email` like ?', [$data->email]);
            if (\sizeof($posibleusersname) > 0) {
                $status = "Užívateľ s týmto menom už existuje.";
            } else if (\sizeof($posibleusersemail) > 0) {
                $status = "Užívateľ s týmto emailom už existuje.";
            } else {
                $posibleusers = [];
                do {
                    $newSession = \rand();
                    $posibleusers = \App\Models\User::getAll('`session` like ?', [$newSession]);
                } while (\sizeof($posibleusers) > 0);

                $user = new \App\Models\User();
                $user->setUsername($data->username);
                $user->setEmail($data->email);
                $user->setPassword(\password_hash($data->password, PASSWORD_DEFAULT));
                $user->setRole(0);
                $user->setSession($newSession);
                $user->save();
            }
        }
        $resp = new \StdClass();
        $resp->status = $status;
        $resp->session = $newSession;
        return $this->json($resp);
    }

    public function forgot(Request $request): Response
    {
        return $this->html();
    }
}
