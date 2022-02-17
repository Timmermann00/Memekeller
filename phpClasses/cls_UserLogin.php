<?php

require_once("cls_Autoloader.php");

class cls_UserLogin
{
    function ValidateUserForRegestration($check, $mail, $username)
    {

        if ($check == false) {

            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                echo "<script type='text/javascript'>alert('Mailadresse ist nicht gültig!');</script>";
                return false;
            }
        } else {

            if ($check["mailadresse"] == $mail) {
                echo "<script type='text/javascript'>alert('Mailadresse wird bereits verwendet!');</script>";
            }
            if ($check["nickname"] == $username) {
                echo "<script type='text/javascript'>alert('Username wird bereits verwendet!');</script>";
            }

            return false;
        }
    }

    function ValidateUserForLogin($username, $password)
    {

        $dbconn = new cls_DBCon();
        $check = $dbconn->query("SELECT nickname FROM memeuser WHERE nickname like '$username'");

        if ($check == false) {
            echo "<script type='text/javascript'>alert('Es gibt keinen Benutzer mit diesem Benutzer!');</script>";
        } else {
            $res = $dbconn->query("SELECT passwort FROM memeuser WHERE nickname like '$username'");
            if ($res["passwort"] == $password) {
                echo ("Benutzer erfolgreich angemeldet!");
                return true;
            } else {
                echo "<script type='text/javascript'>alert('Das Passwort ist Falsch!');</script>";
                return false;
            }
        }
    }

    function AddUser($mail, $password, $username)
    {

        $dbconn = new cls_DBCon();
        $check = $dbconn->query("SELECT mailadresse, nickname FROM memeuser WHERE memeuser.mailadresse like '$mail' or memeuser.nickname like '$username'");

        if ($this->ValidateUserForRegestration($check, $mail, $username)) {
            $stmt = $dbconn->prepare("INSERT INTO memeuser(mailadresse, passwort, nickname) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $mail, $password, $username);
            $dbconn->exec($stmt);
            echo 'User: ' . $username . ' wurde erfolgreich Regestriert';
            return true;
        }
        return false;
    }

    function ValidateAdminLogin($password)
    {
        if ($password == "Memekeller123") {
            return true;
        } else {
            return false;
        }
    }
}
