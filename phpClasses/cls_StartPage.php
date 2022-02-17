<?php

include_once 'cls_Autoloader.php';

class cls_StartPage
{
    protected $offset;
    protected $limit;
    protected $dbcon;

    function __construct($tableoff, $tablelimit)
    {
        $this->offset = $tableoff;
        $this->limit = $tablelimit;
        $this->dbcon = new cls_DBCon();
    }

    function CreateBody()
    {
        cls_SessionHandling::start();
        cls_SessionHandling::AddPreviousLink("../FrontEndHtmlPhp/StartPage.php?offset={$this->offset}&limit={$this->limit}&action=return");

        $UserState = new cls_UserFunc();
        $s = "  <div class='outer-window'>
            <div class='header'>
                <div class='logo'>
                <img src='../MemeData/Logo/MemekellerLogo.jpg' />
                </div>
                <div class='nav-Bar'>
                " . $this->CreateNavBarOptions() . "
                </div>
                <a class='UserIcon' href=" . $UserState->CheckLoginState() . ">
                   <img src='../MemeData/UserIcon/ProfileIcon.png'/>
                </a>   
            </div>
            <div class='middle'>
                <div class='filter'>
                    <div class='Searchdiv'>
                        <input
                            class='Filterinput'
                            id='filterinput'
                            type       = 'text' 
                            onpaste    = 'ProccesInputData();'
                            oninput    = 'ProccesInputData();'
                        />
                    </div>
                    <div class='Tablediv'>
                        <table class='Filtertable' id='filtertable'></table>
                    </div>
                </div>
                <div class='main-content'>
                <h3 class='TimlineTitle'>TimeLine</h3>
                <h3 class='ImageHeader'>Image</h3>
                <h3 class='HeadlineHerder'>Headline</h3>
                <h3 class='PostedHeder'>Posted</h3>
                         <div class='TimeTable'>
                         ".$this->LoadDataTableForTimeLine()."
                         </div>          
                         <form method='get' id='offsetform'>
                            <input hidden type='text'  id='offset' name='offset' value='{$this->offset}'>
                        </form>
                            <button class='btn-prev' form='offsetform' type='submit' name='action' value='prev'>Previous</button>
                            <button class='btn-next' form='offsetform' type='submit' name='action' value='next'>Next</button>
                        </div>
                </div>
            <div class='footer'> <a href='../Impressum/Impressum.html'> Impressum </a> <a href='../Impressum/Kontakt.html'> Kontakt </a></div>
        </div>";

        return $s;
    }

    function LoadDataTableForTimeLine()
    {
        $sql = "select id,file_path,headline,posted from meme order by posted desc limit {$this->offset},{$this->limit}";

        $res = $this->dbcon->query_all($sql);

        $s = "<table border=1 frame=hsides rules=rows >"
            . "<tbody>";

        for ($i = 0; $i < sizeof($res); $i++) {
            $s .= "<tr><td>"
                . "<a href='SingleView.php?id={$res[$i]["id"]}&action=show'>"
                . "<img class='tableimg' src='{$res[$i]["file_path"]}'/> "
                . "</a></td>"
                . "<td>{$res[$i]['headline']}</td>"
                . "<td>{$res[$i]['posted']}</td>"
                . "</td></tr>";
        }
        $s .= "</tbody></table>";
        return $s;
    }

    function CreateNavBarOptions()
    {
        $s = "<div class='dropdown'>
                  <button class='dropbtn'>Subkategorien 
                  <i class='fa fa-caret-down'></i>
                  </button>
                  <div class='dropdown-content'>";
        $getsubcategorie = "Select subcategorie.bezeichnung from subcategorie";
        $amount_subcat = $this->dbcon->query_all($getsubcategorie, MYSQLI_NUM);

        for ($i = 1; $i <= sizeof($amount_subcat); $i++) {
            $selectsmallestid = "select id from meme where id_subcategory={$i} order by id asc limit 1";
            $smalesid = $this->dbcon->query($selectsmallestid);
            $s .= "<a href='SingleView.php?id={$smalesid["id"]}&action=show'>{$amount_subcat[$i - 1][0]}</a>";
        }
        return $s .= "</div></div>";
    }
}
