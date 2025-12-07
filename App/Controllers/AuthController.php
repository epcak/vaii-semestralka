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

    /**
     * Authenticates a user and processes the login request.
     *
     * This action handles user login attempts. If the login form is submitted, it attempts to authenticate the user
     * with the provided credentials. Upon successful login, the user is redirected to the admin dashboard.
     * If authentication fails, an error message is displayed on the login page.
     *
     * @return Response The response object which can either redirect on success or render the login view with
     *                  an error message on failure.
     * @throws Exception If the parameter for the URL generator is invalid throws an exception.
     */
    public function login(Request $request): Response
    {
        $logged = null;
        if ($request->hasValue('submit')) {
            $logged = $this->app->getAuthenticator()->login($request->value('username'), $request->value('password'));
            if ($logged) {
                return $this->redirect($this->url("admin.index"));
            }
        }

        $message = $logged === false ? 'Bad username or password' : null;
        return $this->html(compact("message"));
    }

    /**
     * Logs out the current user.
     *
     * This action terminates the user's session and redirects them to a view. It effectively clears any authentication
     * tokens or session data associated with the user.
     *
     * @return ViewResponse The response object that renders the logout view.
     */
    public function logout(Request $request): Response
    {
        $this->app->getAuthenticator()->logout();
        return $this->html();
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
