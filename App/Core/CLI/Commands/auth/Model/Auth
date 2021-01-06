<?php

namespace App\Http\Model;

use App\Core\Model;

class Auth extends Model
{
    public static function authenticated(): bool
    {
        if (!session_status() === PHP_SESSION_ACTIVE) {
            return false;
        }

        if (!isset($_COOKIE['user-id'])) {
            return false;
        }

        $session = new Session();
        $session->find(session_id());

        if (session_id() !== $session->session_id) {
            return false;
        }

        if (!isset($session->user()->id)) {
            return false;
        }

        if ($_COOKIE['user-id'] !== hash('sha1', $session->user()->id)) {
            return false;
        }


        return true;
    }

    public static function auth(): ?Model
    {
        if (!session_status() === PHP_SESSION_ACTIVE) {
            return null;
        }

        if (!isset($_COOKIE['user-id'])) {
            return null;
        }

        $session = new Session();
        $session = $session->find(session_id());

        if (session_id() !== $session->session_id) {
            return null;
        }

        if ($_COOKIE['user-id'] !== hash('sha1', $session->user()->id)) {
            return null;
        }

        return $session->user();
    }
}
