<?php

include_once('include/phpMyGraph5.0.php'); 

$cfg['width'] = 300 ;
$cfg['height'] = 100;
$cfg['average-line-visible']=false;
$cfg['label']=$_GET["period"];

switch($_GET["graph"]){
    
    case 'orp':
    $data = array(
        '00' => 700,
        '01' => 750,
        '02' => 730,
        '03' => 650,
        '04' => 600,
        '05' => 630,
        '06' => 700,
        '07' => 600,
        '08' => 700,
        '09' => 720,
        '10' => 730
    );
    break;
    
    case 'temperature':
    $data = array(
        '00' => 10,
        '01' => 12,
        '02' => 13,
        '03' => 15,
        '04' => 10,
        '05' => 12,
        '06' => 10,
        '07' => 10,
        '08' => 17,
        '09' => 12,
        '10' => 16
    );
    break;
    
    case 'ph':
    $data = array(
        '00' => 7.01,
        '01' => 7.25,
        '02' => 7.30,
        '03' => 6.7,
        '04' => 6.50,
        '05' => 6.20,
        '06' => 7.10,
        '07' => 6.20,
        '08' => 7.00,
        '09' => 7.10,
        '10' => 7.15
    );
    break;    
	
	default:
		echo "No graph specified, call with?&graph=[temperature|orp|pg]";
		return;
	break;
}

header("Content-type: image/png");
//Set data
//$query="select col1, col2 from tab1 where sub_project = 'sometext'";
//$result=mysql_query($query);
//$row = mysql_fetch_assoc($result);
//$data = array(
//    $row['col1'] => $row['col2'],
//);
//Create phpMyGraph instance
$graph = new phpMyGraph();

//Parse
$graph->parseVerticalLineGraph($data,$cfg);
?>