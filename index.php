<?php

session_start();

//unset($_SESSION['topmovies']);

    if(!isset($_SESSION['topmovies'])){
        $content = file_get_contents("http://www.imdb.com/movies-in-theaters/?ref_=cs_inth");

        //get titles and pictures
        preg_match_all("/title=\"(.*)\"\nsrc=\"(.*)\"\nitemprop=\"image\" \/>/", $content, $m);

//get descriptions
preg_match_all("/itemprop=\"description\">\n(.*)<\/div/", $content, $n);

//get the rating
//preg_match_all("/span class=\"rating-rating\"><span class=\"value\">(.*)<\/span/", $content, $l);

        //echo "<pre>";
        //print_r($l);
        //exit;

        $json = new stdClass();
        $len = count($m[1]);

        for($i=0;$i<$len;$i++){
            $json->title[$i] = $m[1][$i];
            $json->url[$i] = $m[2][$i];
            $json->description[$i] = $n[1][$i];
        }

        $_SESSION['topmovies']=$json;
        $_SESSION['topmovies_len']=$len;
    }else{
        $json=$_SESSION['topmovies'];
        $len=$_SESSION['topmovies_len'];
    }


    if(isset($_GET['genre'])){

            $content = file_get_contents("http://www.imdb.com/search/title?genres=".strtolower($_GET['genre'])."&title_type=feature&sort=moviemeter,asc");

            preg_match_all("/img src=\"(.*)@.*\" height=\"74\" width=\"54\" alt=\"(.*)\" title/", $content, $k);

            preg_match_all("/class=\"outline\">(.*)<\/span>\n<span class=\"credit\"/", $content, $p);

            preg_match_all("/span class=\"rating-rating\"><span class=\"value\">(.*)10<\/span/", $content, $l);

            $lim=30;

            //merge arrays
            for($i=0;$i<30;$i++){
                $k[1][$i] .= "@._V1_SX150.jpg";
                $k[3][$i] = preg_replace("/<.*?>/" ,"" ,$p[1][$i]);
                $k[4][$i] = substr(preg_replace("/<.*?>/" ,"" ,$l[1][$i]),0,-1);
            }
            for($i=30;$i<count($k[0]);$i++){
                unset($k[1][$i]);
                unset($k[2][$i]);
            }
            unset($k[0]);

            //echo "<pre>";
            //print_r($k);
            //exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Moodvie</title>
    <link rel="stylesheet" href="css/style2.css">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/header.js"></script>

    <script>

    <?php
        if($_GET['genre']){
            echo 'loadpopup=1;';
        }
    ?>

    </script>

</head>
<body id="body">

<header class="header">
    <nav class="nav">
        <div>

            <div id="chart" style="display:table;">
                <div style="display:table-cell;"><i class="fa fa-lg fa-line-chart"></i></div>
                <div style="position:absolute; margin-top: -3px; display:table-cell; cursor:pointer;">Top</div>
            </div>


        </div>
        <div><img class="logo" src="images/logo.png"  /></div>
        <div>



               <span style="display: block;position: fixed;top: 6px;right: 44px;" >Genres</span>
               <img class="genre" src="images/genre.png" id="genre"/>



        </div>
    </nav>
</header>

<div class="intro">


    <h1>Feeling Moody</h1>
    <img class="image" src="images/intro.png" />
    <h1>Pick a movie</h1>

</div>
<div class="topmovies" id="topmovies">


    <?php

        for($i=0;$i<$len;$i++){
            echo '

                    <div class="movie">
                <div class="left">
                    <img class="filmimg" src="imageloader.php?u='.urlencode($json->url[$i]).'" />
                </div>
                <div class="right">
                    <h3 class="title">'.$json->title[$i].'</h3>
                    <p class="text">'.$json->description[$i].'</p>
                </div>
                <div class="clear"></div>
            </div>

            ';
        }

    ?>


    </div>

    <div class="genres" id="genres">
    <div class="container">
        <div class="head">
            <a href="?genre=comedy"><img onclick="comedy();" src="images/comedy.png" /></a>
            <a href="?genre=drama"><img onclick="lonely();" src="images/lonely.png" /></a>
            <a href="?genre=romance"><img onclick="romance()" src="images/lovy-dovy.png" /></a>
            <a href="?genre=animation"><img onclick="lazy()" src="images/lazy.png" /></a>
            <a href="?genre=action"><img onclick="action()" src="images/adventourous.png" /></a>
        </div>
    </div>

        <?php

        if(isset($_GET['genre'])){

            for($i=0;$i<30;$i++){

                echo '

                        <div class="movie">
                    <div class="left">
                        <img class="filmimg" src="imageloader.php?u='.urlencode($k[1][$i]).'" />
                    </div>
                    <div class="right">
                        <h3 class="title">'.$k[2][$i].'</h3>
                        <p class="text">'.$k[3][$i].'</p>
                    </div>
                    <div class="clear"></div>
                </div>

                ';

            }

        }

        ?>


    </div>

</body>
</html>