<?php

require_once("cls_DBCon.php");
class cls_UserFunc
{
    function DelteUser($mail)
    {
        $dbconn = new cls_DBCon();


        $check = $dbconn->query("SELECT mailadresse FROM memeuser WHERE mailadresse LIKE '$mail'");
        if ($check == false) {
            echo ("Es gibt keinen Benutzer mit dieser Email! <br>");
            return false;
        } else {

            $dbconn->query("DELETE FROM memeuser WHERE mailadresse LIKE '$mail'");
            echo ("User wurde erfolgreich gelöscht");
        }
    }

    function GetEmail($user)
    {
       if($user != null)
       {
           $dbconn = new cls_DBCon();
           $email = $dbconn->query("SELECT mailadresse FROM memeuser WHERE nickname LIKE '$user'");
           return $email['mailadresse'];
       }
       return "";
    }

    function SearchUserByName($username)
    {
        $dbconn = new cls_DBCon();
        $res = $dbconn->query("SELECT nickname FROM memeuser WHERE nickname LIKE '$username'");
        if ($res == false) {

            return false;
        } else {
            echo ("Dieser Nutzername ist bereits vergeben");
            return true;
        }
    }

    function SearchEmailByMail($email)
    {
        $dbconn = new cls_DBCon();
        $res = $dbconn->query("SELECT mailadresse FROM memeuser WHERE mailadresse LIKE '$email'");
        if ($res == false) {
            return false;
        } else {
            echo ("Diese Email ist bereits vergeben");
            return true;
        }
    }

    function UpdateName($newName)
    {
        if (!empty($newName)) {
            if (!$this->SearchUserByName($newName)) {
                $dbconn = new cls_DBCon();
                $name = $_SESSION['user'];
                $dbconn->query_exec("UPDATE memeuser SET nickname = '$newName' WHERE nickname LIKE '$name'");
                $_SESSION['user'] = $newName;
            }
        } else {
            return false;
        }
    }

    function UpdateEmail($newEmail)
    {
        if (!empty($newEmail)) {
            if (!$this->SearchEmailByMail($newEmail)) {
                $dbconn = new cls_DBCon();
                $name = $_SESSION['user'];
                $dbconn->query_exec("UPDATE memeuser SET mailadresse = '$newEmail' WHERE nickname LIKE '$name'");
            }
        } else {
            return false;
        }
    }

    function UpdatePassword($newPassword)
    {
        if (!empty($newPassword)) {
            $dbconn = new cls_DBCon();
            $name = $_SESSION['user'];
            $dbconn->query_exec("UPDATE memeuser SET passwort = '$newPassword' WHERE nickname LIKE '$name'");
        } else {
            return false;
        }
    }

    function CheckPassword($password)
    {
        $dbconn = new cls_DBCon();
        $name = $_SESSION['user'];
        $oldPw = $dbconn->query("SELECT passwort FROM memeuser WHERE nickname LIKE '$name'");
        if ($oldPw == $password) {
            return true;
        } else {
            return false;
        }
    }

    function CheckLoginState()
    {
        if (cls_SessionHandling::SessionIsActive()) {
            return "..\AlterUser\AlterProfile.php";
        } else {
            return "..\Login\Meme-Login.php";
        }
    }
}
