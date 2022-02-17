<?php

include_once 'cls_Autoloader.php';
class cls_SingleViewController
{
    function __construct()
    {
    }

    function CreateBodyOnAction()
    {
        $dbcon = new cls_DBCon();
        $parameter = new cls_SingleViewParameter();
        
        $id = $parameter->id;
        $subcat = $parameter->subcategory;
        $headline = $parameter->headline;
        $path = $parameter->filepath;
        $reviewed=-1;

        $sql = "";
        if ($parameter->action == "next") {
            $sql = "select * from meme where id > {$parameter->id} and id_subcategory={$parameter->subcategory} order by id limit 1";
        } else if ($parameter->action == "previous") {
            $sql = "select * from meme where id < {$parameter->id} and id_subcategory={$parameter->subcategory} order by id desc limit 1 ";
        } else if ($parameter->action == "preview" || $parameter->action == "show") {
            $sql = "select * from meme where id={$id}";
        }

        $rows = $dbcon->query($sql);

        if ($rows) {
            $id = $rows["id"];
            $subcat = $rows["id_subcategory"];
            $headline = $rows["headline"];
            $path = $rows["file_path"];
        }
        
        if(cls_SessionHandling::SessionIsActive())
        {
            cls_SessionHandling::start();
        
            try {
                $sqlforuserid = "select id from memeuser where nickname like '".cls_SessionHandling::ReturnUserNickname()."'";
                $CurrentUserId = $dbcon->query($sqlforuserid,MYSQLI_NUM);
                $UserInfoForPost="select likedislikes.like_dislike from likedislikes where post_id='{$id}' and user_id='{$CurrentUserId[0]}'";
                $res = $dbcon->query($UserInfoForPost,MYSQLI_NUM);

                if($res!=null)
                {
                    $reviewed=$res[0];
                }
            } catch (Exception $ex) {
                echo 'No valid UserId';
            }
        }
        else
        {
            $this->Userreview=-1;
        }

        $meme = new cls_SingleView($id, $subcat, $headline, $path, $reviewed);
        return $meme->CreateBody();
        
    }
}
