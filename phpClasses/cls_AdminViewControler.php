<?php

include_once 'cls_Autoloader.php';
class cls_AdminViewControler
{
    function __construct()
    {
    }

    function CreateBodyOnAction()
    {

        $dbcon = new cls_DBCon();
        $parameter = new cls_AdminViewParameter();

        $id = $parameter->id_meme;
        $subcat = $parameter->subcategory;
        $headline = $parameter->headline;
        $path = $parameter->filepath;
        $reviewed = $parameter->Userreview;

        $sql = "";

        if ($parameter->action == "del_user") {
            $sql = "delete from memeuser where id={$parameter->id_user}";
            $dbcon->query_exec($sql);
            $sql = "select * from meme where id={$parameter->id_meme}";
            $rows = $dbcon->query($sql);
        }

        if ($parameter->action == "del_meme") {
            $sql = "delete from meme where id={$parameter->id_meme}";
            $dbcon->query_exec($sql);
            $sql = "select * from meme where id > {$parameter->id_meme} and id_subcategory={$parameter->subcategory} order by id limit 1";
            $rows = $dbcon->query($sql);
            if ($rows == null) {
                $sql = "select * from meme where id < {$parameter->id_meme} and id_subcategory={$parameter->subcategory} order by id desc limit 1 ";
                $rows = $dbcon->query($sql);
                if ($rows == null) {
                }
            }
        }

        if ($parameter->action == "next") {
            $sql = "select * from meme where id > {$parameter->id_meme} and id_subcategory={$parameter->subcategory} order by id limit 1";
            $rows = $dbcon->query($sql);
            if ($rows == null) {
                $sql = "select * from meme where id < {$parameter->id_meme} and id_subcategory={$parameter->subcategory} order by id limit 1 ";
                $rows = $dbcon->query($sql);
            }
        }

        if ($parameter->action == "previous") {
            $sql = "select * from meme where id < {$parameter->id_meme} and id_subcategory={$parameter->subcategory} order by id desc limit 1 ";
            $rows = $dbcon->query($sql);
            if ($rows == null) {
                $sql = "select * from meme where id > {$parameter->id_meme} and id_subcategory={$parameter->subcategory} order by id desc limit 1 ";
                $rows = $dbcon->query($sql);
            }
        }

        if ($parameter->action == "preview" || $parameter->action == "show") {
            $sql = "select * from meme where id >= {$parameter->id_meme} order by id limit 1";
            $rows = $dbcon->query($sql);
            if ($rows == null) {
                $sql = "select * from meme where id < {$parameter->id_meme} order by id limit 1 ";
                $rows = $dbcon->query($sql);
            }
        }

        if ($rows) {
            $id = $rows["id"];
            $subcat = $rows["id_subcategory"];
            $headline = $rows["headline"];
            $path = $rows["file_path"];
        }

        $meme = new cls_AdminView($id, $subcat, $headline, $path, $reviewed);

        return $meme->CreateBody();
    }
}
