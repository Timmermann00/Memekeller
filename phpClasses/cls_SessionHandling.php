<?php

class cls_SessionHandling
{

    static function start()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    static function kill()
    {
        if (isset($_SESSION)) {
            session_unset();
            session_destroy();
        }
    }

    static function AddUser($user)
    {
        if ($_SESSION['user'] != $user || !isset($_SESSION['user'])) {
            $_SESSION['user'] = $user;
        }
    }

    static function ReturnUserNickname()
    {
        cls_SessionHandling::start();
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
    }


    static function SessionIsActive()
    {
        if (isset($_SESSION['id']) || isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }

    static function AddPreviousLink($link)
    {
        $_SESSION['link'] = $link;
    }

    static function GetLink()
    {
        if (isset($_SESSION['link'])) {
            return $_SESSION['link'];
        }
    }

    static function Logout()
    {
        if (cls_SessionHandling::SessionIsActive()) {
            cls_SessionHandling::kill();
        }
    }
}
