<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Template;
use App\Http\Model\User;

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
            ->do()
            ->get();

        if (!(count($users) > 0)) {
            Template::view('login.html', [
                'errors' => [
                    'User not found'
                ]
            ]);
            return;
        }

        if (!password_verify($formData['password'], $users[0]->password)) {
            Template::view('login.html', [
                'errors' => [
                    'Login details do not match our records'
                ]
            ]);
            return;
        }

        $this->redirect()->url('/dashboard')->do();
    }

    private function validateLoginRequest(array $formData): bool
    {
        return $this->validate([
            $formData['email'] => 'email',
            $formData['password'] => 'string,gt:8'
        ]);
    }
}
