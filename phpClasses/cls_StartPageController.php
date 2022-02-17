<?php

class cls_StartPageController{
    
    protected $offset;
    protected $limit;
    protected $action;
            
    function __construct() {
        
    }
    
    function CreateBodyOnAction()
    {
        $dbcon = new cls_DBCon();
         $passedparams = new cls_StartPageParameter();
         $this->offset = $passedparams->offset;
         $this->action = $passedparams->action;
         $this->limit=20;
         
         $maxoutput = "select count(*) from meme";
         $res=$dbcon->query($maxoutput,MYSQLI_NUM);
         $this->AdjustOffset($res[0]);
         
         $startscreen = new cls_StartPage($this->offset, $this->limit);
         return $startscreen->CreateBody();
         
    }
    
    function AdjustOffset($max)
    {
        if($this->action == "next")
         {
             if ($this->offset + 10 >= $max)
                $this->limit= $max - $this->offset;
            else    
                $this->offset+=10;
         } else if($this->action == "prev")
         {
             if($this->offset!=0)
                $this->offset-=10;
            
            if($this->offset<0)
                $this->offset=0;
            
         }else if($this->action == "ShowTimeline")
         {
             $this->offset=0;
         }
    }
    
}

