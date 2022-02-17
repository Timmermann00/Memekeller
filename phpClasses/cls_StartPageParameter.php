<?php
class cls_StartPageParameter
{

    protected $action;
    protected $offset;
    protected $dbcon;

    function __construct()
    {

        $this->dbcon = new cls_DBCon();

        $sql = "select count(*) as maxrange from meme";
        $maxrange_foroffset = $this->dbcon->query($sql);
        $options = array("options" => array("default" => 0, "min_range" => 0, "max_range" => $maxrange_foroffset["maxrange"]));
        $this->offset = filter_input(INPUT_GET, "offset", FILTER_VALIDATE_INT, $options);

        $options = array("options" => array("default" => "ShowTimeline"));
        $this->action = filter_input(INPUT_GET, "action", FILTER_DEFAULT, $options);

        $valid_actions = array("next", "prev", "ShowTimeline", "return");

        if (!in_array($this->action, $valid_actions))
            $this->action = "ShowTimeline";
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
