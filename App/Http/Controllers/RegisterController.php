<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Template;
use App\Http\Model\User;

class RegisterController extends Controller
{
    public function registerView(): void
    {
        Template::view('register.html', [
            'errors' => $this->validateErrors
        ]);
    }

    public function register(): void
    {
        $user = new User();

        $formData = [
            'username' => $this->sanitize($_POST['username']),
            'email' => $this->sanitize($_POST['email']),
            'password' => $this->sanitize($_POST['password'])
        ];

        if (!$this->validateRegisterRequest($formData)) {
            Template::view('register.html', [
                'errors' => $this->validateErrors
            ]);
            return;
        }

        $user->username = $formData['username'];
        $user->email = $formData['email'];
        $user->password = password_hash($formData['password'], PASSWORD_BCRYPT);

        $user->create()->do();

        $this->redirect()->url('/login')->do();
    }

    private function validateRegisterRequest(array $formData): bool
    {
        return $this->validate([
            $formData['username'] => 'string,gt:6',
            $formData['email'] => 'email',
            $formData['password'] => 'string,gt:8'
        ]);
    }
}
