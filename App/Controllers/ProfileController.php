<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\HttpException;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\JsonResponse;
use App\Model\User;
use App\Model\Image;
use App\Model\Articleimage;
use App\Configuration;

class ProfileController extends BaseController
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
        if ($logedin && ($logeduser[0]->getRole() == 1 || $logeduser[0]->getRole() == 2)) {
            $obrazky = \App\Models\Image::getAll('`user` like ?', [$logeduser[0]->getUsername()]);
            return $this->html(["obrazky" => $obrazky]);
        }
        return $this->redirect($this->url('home.index'));
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

    public function changeimagedescription(Request $request): JsonResponse
    {
        $data = $request->json();
        $resp = new \StdClass();
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            $resp->status = "Užívateľ neprihlásený.";
            return $this->json($resp);
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']])[0];
        if ($logeduser->getRole() == 1 || $logeduser->getRole() == 2) {
            $obrazok = \App\Models\Image::getOne($data->imageid);
            if ($obrazok == NULL) {
                $resp->status = "Obrázok nenájdený";
            } else if ($obrazok->getUser() != $logeduser->getUsername()) {
                $resp->status = "Obrázok nie je vo vlastníctve";
            } else {
                $obrazok->setDescription($data->desc);
                $obrazok->save();
                $resp->status = "OK";
            }
        } else {
            $resp->status = "Nespravne pravomoci";
        }
        
        return $this->json($resp);
    }

    public function deleteimage(Request $request): JsonResponse
    {
        $data = $request->json();
        $resp = new \StdClass();
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE))
        {
            $resp->status = "Užívateľ neprihlásený.";
            return $this->json($resp);
        }
        $logeduser = \App\Models\User::getAll('`username` like ?', [$_COOKIE['username']])[0];
        if ($logeduser->getRole() == 1 || $logeduser->getRole() == 2) {
            $obrazok = \App\Models\Image::getOne($data->imageid);
            if ($obrazok == NULL) {
                $resp->status = "Obrázok nenájdený";
            } else if ($obrazok->getUser() != $logeduser->getUsername()) {
                $resp->status = "Obrázok nie je vo vlastníctve";
            } else {
                $obrazokvclanku = \App\Models\Articleimage::getAll("image_id like ?", [$data->imageid]);
                foreach ($obrazokvclanku as $obr) {
                    $obr->delete();
                }
                @unlink($obrazok->getLocation());
                $obrazok->delete();
                $resp->status = "OK";
            }
        } else {
            $resp->status = "Nespravne pravomoci";
        }
        
        return $this->json($resp);
    }

    public function uploadimage(Request $request): Response
    {
        if (!is_dir(Configuration::UPLOAD_DIR)) {
            if (!@mkdir(Configuration::UPLOAD_DIR, 0777, true) && !is_dir(Configuration::UPLOAD_DIR)) {
                throw new HttpException(500, 'Nepodarilo sa vytvoriť adresár pre nahrávanie obrázkov.',);
            }
        }
        if (!array_key_exists('username', $_COOKIE) || !array_key_exists('session', $_COOKIE)) {
            throw new HttpException(401);
        }
        $koncovka = "";
        $novyobrazok = $request->file('nahratobrazok');
        $typobrazka = $novyobrazok->getType();
        if ($typobrazka == "image/png") {
            $koncovka = ".png";
        } else if ($typobrazka == "image/jpeg") {
            $koncovka = ".jpg";
        }
        if ($koncovka == "") throw new HttpException(400, "Zlý typ súboru.");

        $obrazok = new \App\Models\Image;
        $obrazok->setLocation("");
        $obrazok->setUser($_COOKIE['username']);
        $obrazok->save();
        $cestaukladania = Configuration::UPLOAD_DIR . $obrazok->getId() . $koncovka;
        if (!$novyobrazok->store($cestaukladania)) {
            $obrazok->delete();
            throw new HttpException(500, 'Nepodarilo sa uložiť obrázok.',);
        }

        $obrazok->setLocation($cestaukladania);
        $obrazok->save();

        return $this->redirect($this->url('profile.gallery'));
    }
}