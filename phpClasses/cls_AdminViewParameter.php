<?php

include_once 'cls_Autoloader.php';

class cls_AdminViewParameter
{
    protected $id_user;
    protected $id_meme;
    protected $subcategory;
    protected $headline;
    protected $filepath;
    protected $Userreview;
    protected $action;
    protected $dbcon;

    function __construct()
    {

        $this->dbcon = new cls_DBCon();

        $sql = "select count(*) as maxrange from meme";
        $maxrange_forID = $this->dbcon->query($sql);
        $options = array("options" => array("default" => 1, "min_range" => 1, "max_range" => $maxrange_forID["maxrange"]));
        $this->id_meme = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT, $options);

        $options = array("options" => array("default" => 1, "min_range" => 1));
        $this->id_user = filter_input(INPUT_GET, "id_user", FILTER_VALIDATE_INT, $options);

        $options = array("options" => array("default" => "show"));
        $this->action = filter_input(INPUT_GET, "action", FILTER_DEFAULT, $options);

        $valid_actions = array("del_meme", "del_user", "next", "previous", "preview", "show");

        if (!in_array($this->action, $valid_actions))
            $this->action = "show";

        $sql = "select * from meme where id={$this->id_meme}";
        $DatafromId = $this->dbcon->query($sql);
        if ($DatafromId != NULL) {
            $this->subcategory = $DatafromId["id_subcategory"];
            $this->headline = $DatafromId["headline"];
            $this->filepath = $DatafromId["file_path"];
        } else {
            $this->subcategory = "id_subcategory";
            $this->headline = "headline";
            $this->filepath = "file_path";
        }


        if (cls_SessionHandling::SessionIsActive()) {
            cls_SessionHandling::start();

            try {
                $sqlforuserid = "select id from memeuser where nickname like '{$_SESSION['user']}'";
                $CurrentUserId = $this->dbcon->query($sqlforuserid, MYSQLI_NUM);
                $UserInfoForPost = "select likedislikes.like_dislike from likedislikes where post_id='{$this->id_meme}' and user_id='{$CurrentUserId[0]}'";
                $res = $this->dbcon->query($UserInfoForPost);

                if ($res == null) {
                    $this->Userreview = -1;
                } else {
                    $this->Userreview = $res;
                }
            } catch (Exception $ex) {
                echo 'No valid UserId';
            }
        } else {
            $this->Userreview = -1;
        }
    }

    public function __get($s)
    {
        if (property_exists($this, $s)) {
            return $this->$s;
        } else {
            die("<br>unzulässiger Parameter: " . $s . "in Datei: " . __FILE__ . " Zeile:" . __LINE__ . "<br>");
        }
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            die("<br>unzulässiger Parameter: " . $name . "in Datei: " . __FILE__ . " Zeile:" . __LINE__ . "<br>");
        }
    }
}
