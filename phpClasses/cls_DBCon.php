<?php

class cls_DBCon
{
    protected static $dbconn = null;

    public function __construct()
    {
        $servername = "localhost";
        $username = "Memelord";
        $password = "Memes1234";
        $db = "Memekeller";

        if (self::$dbconn == null) {
            try {
                self::$dbconn = new mysqli($servername, $username, $password, $db);
            } catch (mysqli_sql_exception $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
    }

    public function getcon()
    {
        return self::$dbconn;
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->name;
        }
    }

    public function query($sql, $format = MYSQLI_ASSOC)
    {
        try {
            $res = mysqli_query(self::$dbconn, $sql);
            return mysqli_fetch_array($res, $format);
        } catch (mysqli_sql_exception $ex) {
            echo __FILE__ . " " . __LINE__ . $ex->getMessage();
            die();
        }
    }

    public function query_all($sql, $format = MYSQLI_ASSOC)
    {
        try {
            $res = mysqli_query(self::$dbconn, $sql);
            return mysqli_fetch_all($res, $format);
        } catch (mysqli_sql_exception $ex) {
            echo __FILE__ . " " . __LINE__ . $ex->getMessage();
            die();
        }
    }

    public function query_exec($sql)
    {
        try {
            return mysqli_query(self::$dbconn, $sql);
        } catch (mysqli_sql_exception $ex) {
            echo __FILE__ . " " . __LINE__ . $ex->getMessage();
            die();
        }
    }

    public function exec($stmt)
    {
        try {
            $res = mysqli_execute($stmt);
            return $res;
        } catch (mysqli_sql_exception $ex) {
            echo __FILE__ . " " . __LINE__ . $ex->getMessage();
            die();
        }
    }

    public function prepare($sql)
    {
        return mysqli_prepare(self::$dbconn, $sql);
    }

    public function execute($stmt)
    {
        try {
            $res = mysqli_execute($stmt);
            return $res;
        } catch (Exception $ex) {
            echo __FILE__ . " " . __LINE__ . $ex->getMessage();
            die();
        }
    }

    public function GetMostVotedFromSub($idSub)
    {
        $sql = "select id, file_path from meme where id_subcategory={$idSub} order by likes desc limit 5 ";
        return $this->query($sql);
    }

    function InsertUserRating($memeid, $likeDislike)
    {
        cls_SessionHandling::start();
        if (cls_SessionHandling::SessionIsActive() && $likeDislike != -1) {
            $sqlreq = "select post_id, user_id, like_dislike from likedislikes join memeuser on likedislikes.user_id=memeuser.id "
                . "where post_id={$memeid} and memeuser.nickname='" . cls_SessionHandling::ReturnUserNickname() . "'";

            $res = $this->query($sqlreq);
            if (isset($res)) {
                $sqlupdate = "update likedislikes set like_dislike={$likeDislike} where post_id={$res['post_id']} and user_id={$res['user_id']}";
                $this->query_exec($sqlupdate);
            } else if (!isset($res)) {
                $getUserID = "select id from memeuser where nickname like'" . cls_SessionHandling::ReturnUserNickname() . "'";
                $resid = $this->query($getUserID);
                $sqlinsert = "insert into likedislikes (post_id,user_id,like_dislike) values ({$memeid},{$resid['id']},{$likeDislike})";
                $this->query_exec($sqlinsert);
            }
            return $likeDislike;
        }
        return -1;
    }

    function ReturnJSONForJS($headline)
    {
        $selectFilePath = "select id,file_path from meme where headline like '{$headline}'";
        $res = $this->query_all($selectFilePath);
        return json_encode($res);
    }
}
