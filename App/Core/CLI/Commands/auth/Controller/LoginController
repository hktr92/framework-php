<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Template;
use App\Http\Model\Session;
use App\Http\Model\User;
use Exception;

class LoginController extends Controller
{
    public function loginView(): void
    {
        Template::view('login.html', [
            'errors' => $this->validateErrors
        ]);
    }

    public function login(): void
    {
        $user = new User();

        $formData = [
            'email' => $this->sanitize($_POST['email']),
            'password' => $this->sanitize($_POST['password'])
        ];

        if (!$this->validateLoginRequest($formData)) {
            Template::view('login.html', [
                'errors' => $this->validateErrors
            ]);
            return;
        }

        $users = $user->all()
            ->where('email', '=', $formData['email'])
            ->limit(1)
            ->do();

        if (!($users->count() > 0)) {
            Template::view('login.html', [
                'errors' => [
                    'User not found'
                ]
            ]);
            return;
        }

        if (!password_verify($formData['password'], $users->first()->password)) {
            Template::view('login.html', [
                'errors' => [
                    'Login details do not match our records'
                ]
            ]);
            return;
        }

        $this->registerSession($users->first());
        $this->redirect()->url('/dashboard')->do();
    }

    private function validateLoginRequest(array $formData): bool
    {
        return $this->validate([
            $formData['email'] => 'email',
            $formData['password'] => 'string,gt:8'
        ]);
    }

    private function registerSession(User $user): bool
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $session = new Session();
            $session = $session->find(session_id());

            if (isset($session->user()->id)) {
                if ($session->session_id === session_id() && $session->user()->id === $user->id) {
                    return $this->updateExistingSession($session);
                }
            }

            return $this->registerNewSession($user);
        }

        return false;
    }

    private function registerNewSession(User $user): bool
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $session = new Session();

            $session->session_id = session_id();
            $session->user_id = $user->id;
            $session->login_time = \DateTime::createFromFormat('Y-m-d H:i:s', 'now');

            if ($session->create()->do()) {
                setcookie("user-id", hash('sha1', $user->id));
                return true;
            }

            return false;
        }

        return false;
    }

    private function updateExistingSession(Session $session): bool
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $session->login_time = \DateTime::createFromFormat('Y-m-d H:i:s', 'now');

            return $session->update()->do();
        }

        return false;
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $session = new Session();
            $session->session_id = session_id();

            if ($session->delete()->do()) {
                session_unset();
                session_destroy();
            }

            $this->redirect()->back()->do();
        }
    }
}
