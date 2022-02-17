<?php

include_once 'cls_Autoloader.php';

class cls_SingleViewParameter
{
    protected $id;
    protected $subcategory;
    protected $headline;
    protected $filepath;
    protected $action;
    protected $dbcon;

    function __construct()
    {

        $this->dbcon = new cls_DBCon();

        $sql = "select count(*) as maxrange from meme";

        $maxrange_forID = $this->dbcon->query($sql);
        $options = array("options" => array("default" => 1, "min_range" => 1, "max_range" => $maxrange_forID["maxrange"]));
        $this->id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT, $options);

        $defaultid = "select id from meme where id >= {$this->id} order by id limit 1";
        $checkforid = $this->dbcon->query($defaultid);

        if ($checkforid["id"] != $this->id) {
            $this->id = $checkforid["id"];
        }

        $options = array("options" => array("default" => "show"));
        $this->action = filter_input(INPUT_GET, "action", FILTER_DEFAULT, $options);

        $valid_actions = array("next", "previous", "preview", "show");

        if (!in_array($this->action, $valid_actions))
            $this->action = "show";


        $sql = "select * from meme where id={$this->id}";
        $DatafromId = $this->dbcon->query($sql);

        $this->subcategory = $DatafromId["id_subcategory"];
        $this->headline = $DatafromId["headline"];
        $this->filepath = $DatafromId["file_path"];
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
