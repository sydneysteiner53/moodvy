<?php

if(isset($_GET['u'])){
    $sourcecode = GetImageFromUrl(urldecode($_GET['u']));

    //$savefile = fopen(' /img/uploads/' . $iconfilename, 'w');
    //fwrite($savefile, $sourcecode);
    //fclose($savefile);

    header('Content-type: image/jpeg');
    echo $sourcecode;
}

function GetImageFromUrl($link){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch,CURLOPT_URL,$link);
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result=curl_exec($ch);
    curl_close($ch);
    return $result;
}

?>