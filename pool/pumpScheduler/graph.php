<?php

include_once('include/phpMyGraph5.0.php'); 
require('configuration.php');

$cfg['width'] = $_GET["width"] ;
$cfg['height'] = $_GET["height"];
//keyvisible = affichage de l'echelle du temps
$cfg['key-visible']=true;

// connect to the database
if (!$link = mysql_connect($options["database"]["host"], $options["database"]["username"], $options["database"]["password"])) {
    echo 'Could not connect to mysql';
    exit;
}


if (!mysql_select_db($options["database"]["name"], $link)) {
    echo 'Could not select database :'.$options["database"]["name"];
    exit;
}

$sql = "select ".$_GET["graph"].",id, timeStamp from (select ".$_GET["graph"].", id, timeStamp from measures order by id desc limit ".intval($_GET["period"]).") tempTable order by timeStamp asc";
//echo $sql; exit;
$result = mysql_query($sql, $link);

if (!$result) {
    echo mysql_error();
    exit;
}

$data = array();
while ($row = mysql_fetch_assoc($result)){
    $date = strtotime($row['timeStamp']);
    $hour = date('H', $date);    
    //$data[$row['timeStamp']] = $row[$_GET["graph"]];
    $data[$hour] = $row[$_GET["graph"]];    
    //echo "<br>".$row['timeStamp']." ". $row[$_GET["graph"]]." ".$hour;
}
//exit;

header("Content-type: image/png");
//Create phpMyGraph instance
$graph = new phpMyGraph();
//Parse
if ($_GET["type"]=="bar"){
    $cfg['label']=$_GET["title"];
    //$cfg['label-visible']=false;
    $cfg['value-label-visible']=false;
    $cfg['zero-line-visible']=false;
    $cfg['key-visible']=false;
    $cfg['value-visible']=false;
    $cfg['box-border-visible']=false;
    $cfg['horizontal-divider-visible']=false;  
    $cfg['average-line-visible']=false;
    //$cfg['column-divider-visible']=false;
    $cfg['background-color']="F0F0F0";    

    $graph->parseVerticalSimpleColumnGraph($data,$cfg);
}
else 
    $graph->parseVerticalLineGraph($data,$cfg);

?>