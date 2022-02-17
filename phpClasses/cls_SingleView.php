<?php

class cls_SingleView
{
    protected $id;
    protected $idsub;
    protected $headline;
    protected $filepath;
    protected $reviewed;
    protected $posted;
    protected $dbcon;

    function __construct($memeid, $idsubcat, $head, $path, $review)
    {
        $this->id = $memeid;
        $this->idsub = $idsubcat;
        $this->headline = $head;
        $this->filepath = $path;
        $this->reviewed = $review;
        $this->dbcon = new cls_DBCon();
    }

    function CreateBody()
    {
        cls_SessionHandling::start();
        cls_SessionHandling::AddPreviousLink("../FrontEndHtmlPhp/SingleView.php?id={$this->id}&action=show");
        $Userstate = new cls_UserFunc();
        $s = "  <div class='outer-window'>
            <div class='header'>
                <div class='logo'>
                <img src='../MemeData/Logo/MemekellerLogo.jpg' />
                </div>
                <div class='nav-Bar'>
                " . $this->CreateNavBarOptions() . "
                </div>
                <a class='UserIcon' href=" . $Userstate->CheckLoginState() . ">
                   <img src='../MemeData/UserIcon/ProfileIcon.png'/>
                </a>   
            </div>
            <div class='middle'>
                <div class='top-user'>" . $this->CreateTableActiveUser() . "</div>
                <div class='main-content'>
                        <div class='meme-window'>
                        <img src='{$this->filepath}'/>
                        </div>
                        " . $this->CreatePreviews() . "               
                         <form method='get' id='idform'>
                          <input hidden type='text'  id='idmeme' name='id' value='{$this->id}'>
                          <input hidden type='text'  id='reviewed' value='{$this->reviewed}'>
                        </form>
                        <button class='btn-prev' form='idform' type='submit' name='action' value='previous'>Previous</button>
                        <button class='btn-next' form='idform' type='submit' name='action' value='next'>Next</button>
                        <div class='btn-Review'>
                        <div class='AmountLikes' id='likecounter'>{$this->ReturnAmountLikes()}</div>
                        <div class='AmountDislikes' id='dislikecounter'>{$this->ReturnAmountDislikes()}</div>
                        <button class='btn' id='like'><i class='fa fa-thumbs-up fa-lg' aria-hidden='true'></i></button>
                        <button class='btn' id='dislike'><i class='fa fa-thumbs-down fa-lg' aria-hidden='true'></i></button>
                        </div>
                </div>
                <div class='top-memes'>" . $this->CreateTablePopularmemes() . "</div>
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
                if ($newprev[0] != $this->id && !in_array($newprev[0], $prevarray)) {
                    $prevarray[$i - 1] = $newprev[0];
                    break;
                }
            }
            $s .= "<div class='preview{$i}'>";
            $s .= "<a href=SingleView.php?id={$newprev[0]}&action=preview>";
            $s .= "<img src='$newprev[1]'/>";
            $s .= "</a>";
            $s .= "</div>";
        }
        return $s;
    }

    function CreateTableActiveUser()
    {
        $s = "<table width=100%>"
            . "<tr><th>Name</th><th>Posts</th></tr>";
        $getactiveuser = "select nickname,count(id_user) as AnzahlPost from collection join memeuser on id_user=id group by id_user limit 10";
        $tablerows = $this->dbcon->query_all($getactiveuser);
        for ($i = 0; $i < sizeof($tablerows); $i++) {
            $s .= "<tr><td>{$tablerows[$i]["nickname"]}</td>";
            $s .= "<td>{$tablerows[$i]["AnzahlPost"]}</td></tr>";
        }
        $s .= "</table>";
        return $s;
    }

    function CreateTablePopularmemes()
    {
        $s = "<table heigth=100% width=100%>"
            . "<tr><th>Headline</th><th>Likes</th></tr>";
        $getpopularmemes = "select post_id,headline,count(likedislikes.like_dislike) as likes from likedislikes join meme on meme.id=likedislikes.post_id where like_dislike=1 group by post_id order by likes desc limit  10;";
        $tablerows = $this->dbcon->query_all($getpopularmemes);
        for ($i = 0; $i < sizeof($tablerows); $i++) {
            $s .= "<tr><td><a style='text-decoration:none' href=SingleView.php?id={$tablerows[$i]["post_id"]}&action=show>{$tablerows[$i]["headline"]}</a></td>";
            $s .= "<td>{$tablerows[$i]["likes"]}</td></tr>";
        }
        $s .= "</table>";
        return $s;
    }

    function CreateNavBarOptions()
    {
        $s = "<a href='StartPage.php'>Home</a>"
            . "<div class='dropdown'>
                  <button class='dropbtn'>Subkategorien
                  <i class='fa fa-caret-down'></i>
                  </button>
                  <div class='dropdown-content'>";
        $getsubcategorie = "Select subcategorie.bezeichnung from subcategorie";
        $amount_subcat = $this->dbcon->query_all($getsubcategorie, MYSQLI_NUM);

        for ($i = 1; $i <= sizeof($amount_subcat); $i++) {
            if ($i != $this->idsub) {
                $selectsmallestid = "select id from meme where id_subcategory={$i} order by id asc limit 1";
                $smalesid = $this->dbcon->query($selectsmallestid);
                $s .= "<a href='SingleView.php?id={$smalesid["id"]}&action=show'>{$amount_subcat[$i - 1][0]}</a>";
            }
        }
        return $s .= "</div></div>";
    }

    function ReturnAmountDislikes()
    {
        $getmemelikes = "select count(likedislikes.like_dislike) as dislikes from likedislikes where post_id={$this->id} and likedislikes.like_dislike=0;";
        $res = $this->dbcon->query($getmemelikes);
        return $res['dislikes'];
    }

    function ReturnAmountLikes()
    {
        $getmemelikes = "select count(likedislikes.like_dislike) as likes from likedislikes where post_id={$this->id} and likedislikes.like_dislike=1;";
        $res = $this->dbcon->query($getmemelikes);
        return $res['likes'];
    }
}
