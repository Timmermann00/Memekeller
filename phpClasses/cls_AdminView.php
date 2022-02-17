<?php

class cls_AdminView
{
    protected $id_meme;
    protected $idsub;
    protected $headline;
    protected $filepath;
    protected $reviewed;
    protected $posted;
    protected $dbcon;

    function __construct($memeid, $idsubcat, $head, $path, $review)
    {
        $this->id_meme = $memeid;
        $this->idsub = $idsubcat;
        $this->headline = $head;
        $this->filepath = $path;
        $this->reviewed = $review;
        $this->dbcon = new cls_DBCon();
    }

    function CreateBody()
    {
        $s = "<div class='outer-window'>
            <div class='header'>
                <div class='logo'>
                <img src='../MemeData/Logo/MemekellerLogo.jpg' />
                </div>
                <div class='nav-Bar'>
                " . $this->CreateNavBarOptions() . "
                </div>
            </div>
            <div class='middle'>
                <div class='top-user'>" . $this->CreateTableAllUser() . "</div>
                <div class='main-content'>
                        <div class='meme-window'>
                        <img src='{$this->filepath}'/>
                        </div>
                        " . $this->CreatePreviews() . "               
                         <form method='get' id='idform'>
                          <input hidden type='text'  name='id' value='{$this->id_meme}'>   
                        </form>
                        <button class='btn-prev' form='idform' type='submit' name='action' value='previous'>Previous</button>
                        <button class='btn-next' form='idform' type='submit' name='action' value='next'>Next</button>
                        <div class='btn-Review'>
                        <div class='AmountLikes'>{$this->ReturnAmountLikes()}</div>
                        <div class='AmountDislikes'>{$this->ReturnAmountDislikes()}</div>
                        <button class='btn' id='like'><i class='fa fa-thumbs-up fa-lg' aria-hidden='true'></i></button>
                        <button class='btn' id='dislike'><i class='fa fa-thumbs-down fa-lg' aria-hidden='true'></i></button>
                        </div>
                        <form method='get' id='idform_del'>
                            <input hidden type='text' name='id' value='{$this->id_meme}'>
                        </form>
                        <button class='btn-del' form='idform_del' type='submit' name='action' value='del_meme'>Löschen</button>
                </div>
            </div>
            <div class='footer'></div>
        </div>";
        return $s;
    }

    function  CreatePreviews()
    {
        $s = "";
        $newprev = "";
        $getrandomid = "Select id,file_path,id_subcategory from meme where id_subcategory={$this->idsub} order by rand() Limit 1";
        $prevarray = array();
        for ($i = 1; $i <= 3; $i++) {
            while (true) {
                $newprev = $this->dbcon->query($getrandomid, MYSQLI_NUM);
                if ($newprev[0] != $this->id_meme && !in_array($newprev[0], $prevarray)) {
                    $prevarray[$i - 1] = $newprev[0];
                    break;
                }
            }
            $s .= "<div class='preview{$i}'>";
            $s .= "<a href=AdminView.php?id={$newprev[0]}&action=preview>";
            $s .= "<img src='$newprev[1]'/>";
            $s .= "</a>";
            $s .= "</div>";
        }
        return $s;
    }

    function CreateTableAllUser()
    {
        $s = "<table class= width=100%>"
            . "<tr><th>Name</th><th>Posts</th></tr>";
        $getalluser = "select id, nickname, count(id_user) as AnzahlPost from memeuser left JOIN collection on memeuser.id=collection.id_user group by nickname union 
        select id, nickname, count(id_user) as AnzahlPost from memeuser left JOIN collection on memeuser.id=collection.id_user group by id;";
        $tablerows = $this->dbcon->query_all($getalluser);
        for ($i = 0; $i < sizeof($tablerows); $i++) {
            $s .= "<tr><td>{$tablerows[$i]["nickname"]}</td>";
            $s .= "<td>{$tablerows[$i]["AnzahlPost"]}</td>";
            $s .= "<td><form method='get' id='idform" . $i . "'><input hidden type='text' name='id' value='{$this->id_meme}'><input hidden type='text' name='id_user' value='{$tablerows[$i]['id']}'></form></td>";
            $s .= "<td><button class='del_user' form='idform" . $i . "' type='submit' name='action' value='del_user'>Löschen</button></td></tr>";
        }
        $s .= "</table>";
        return $s;
    }

    function CreateNavBarOptions()
    {
        $s = "<a href='Startpage.php'>Home</a>"
            . "<div class='dropdown'>
                  <button class='dropbtn'>Dropdown 
                  <i class='fa fa-caret-down'></i>
                  </button>
                  <div class='dropdown-content'>";
        $getsubcategorie = "Select subcategorie.bezeichnung from subcategorie";
        $amount_subcat = $this->dbcon->query_all($getsubcategorie, MYSQLI_NUM);

        for ($i = 1; $i <= sizeof($amount_subcat); $i++) {
            if ($i != $this->idsub) {
                $selectsmallestid = "select id from meme where id_subcategory={$i} order by id asc limit 1";
                $smalesid = $this->dbcon->query($selectsmallestid);
                $s .= "<a href='AdminView.php?id={$smalesid["id"]}&action=show'>{$amount_subcat[$i - 1][0]}</a>";
            }
        }
        return $s .= "</div></div>";
    }
    function ReturnAmountDislikes()
    {
        $getmemelikes = "select count(likedislikes.like_dislike) as dislikes from likedislikes where post_id={$this->id_meme} and likedislikes.like_dislike=0;";
        $res = $this->dbcon->query($getmemelikes);
        return $res['dislikes'];
    }

    function ReturnAmountLikes()
    {
        $getmemelikes = "select count(likedislikes.like_dislike) as likes from likedislikes where post_id={$this->id_meme} and likedislikes.like_dislike=1;";
        $res = $this->dbcon->query($getmemelikes);
        return $res['likes'];
    }
}
