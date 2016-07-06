<?php

include_once('include/phpMyGraph5.0.php'); 
require('configuration.php');

require "include/gd-text/Box.php";
require "include/gd-text/Color.php";
require "include/gd-text/TextWrapping.php";
require "include/gd-text/HorizontalAlignment.php";
require "include/gd-text/VerticalAlignment.php";

use GDText\Box;
use GDText\Color;

//////////////////////////////////////////////////
function getTrend(array $values) {
    $x_sum = array_sum(array_keys($values));
    $y_sum = array_sum($values);
    $meanX = $x_sum / count($values);
    $meanY = $y_sum / count($values);
    // calculate sums
    $mBase = $mDivisor = 0.0;
    foreach($values as $i => $value) {
        $mBase += ($i - $meanX) * ($value - $meanY);
        $mDivisor += ($i - $meanX) * ($i - $meanX);
    }

    // calculate slope
    $slope = $mBase / $mDivisor;
    return $slope;
}   //  function leastSquareFit()

function standard_deviation($aValues, $bSample = false)
{
    $fMean = array_sum($aValues) / count($aValues);
    $fVariance = 0.0;
    foreach ($aValues as $i)
    {
        $fVariance += pow($i - $fMean, 2);
    }
    $fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
    return (float) sqrt($fVariance);
}

//////////////////////////////////////////////////////


//if(!isset($_GET['text'])) $_GET['text'] = "Hello, world!";
//

$cfg['width'] = $_GET["width"] ;
$cfg['height'] = $_GET["height"];
$cfg['key-color'] = "00a2e8";
$cfg['column-color'] = "00a2e8";
$cfg['value-label-color'] = "000000";
$cfg['box-background-color'] = "ffffff";
$cfg['background-color'] = "ffffff";
//$cfg['background-color'] = "f0f0f0";
$cfg['box-border-visible']=false;
//keyvisible = affichage de l'echelle du temps

$text=null;


$hint = array(
		    "ph"=>array("up"=>array(
		                    "high"=>"le Ph a grimpé à un niveau anormalement elevé.\nVous devriez vérifier le fonctionnement du régulateur\nou injecter du Ph-",
		                    "low"=>"le Ph est faible mais en augmentation, c'est bon signe.\nA surveiller cependant.",
		                    "correct"=>"le PH à augementé à un niveau correct.\nSurveiller qu'il ne dépasse pas 7.5 dans pes prochaines heures."),
		                "down"=>array(
		                    "high"=>"le Ph diminue mais reste trop elevé.\nC'est bon signe mais à surveiller.",
		                    "low"=>"Le Ph est en train de chuter.\nIl est conseillé de l'augmenter avec du Ph+",
		                    "correct"=>"Attention le Ph est dans les normes\nmais il diminue. A surveiller"),
		                "stable"=>array(
		                    "high"=>"le Ph reste au dessus de la norme.\nIl est conseillé d'augmenter le traitement Ph-\nou vérifier le bon réglage de votre régulateur.",
		                    "low"=>"le Ph reste en dessous de la norme.\nIl est conseillé d'augmenter le traitement Ph+\nou vérifier le bon réglage de votre régulateur.",
		                    "correct"=>"le Ph reste stable et dans les normes.\nC'est bon signe!"),
		                "unsstable"=>array(
		                    "high"=>"le Ph ",
		                    "low"=>"le Ph ",
		                    "correct"=>"le Ph "),		                    
                ),
		    "orp"=>array("up"=>array(
		                    "high"=>"orp up high",
		                    "low"=>"orp up low",
		                    "correct"=>"orp up correct"),
		                "down"=>array(
		                    "high"=>"orp down high",
		                    "low"=>"orp down low",
		                    "correct"=>"orp down correct"),
		                "stable"=>array(
		                    "high"=>"orp stable high",
		                    "orp"=>"ph stable low",
		                    "correct"=>"orp stable correct"),
		                "unstable"=>array(
		                    "high"=>"orp unstable high",
		                    "orp"=>"ph unstable low",
		                    "correct"=>"orp unstable correct"	),	                    
                    ),
		    "temperature"=>array("up"=>array(
	                                "high"=>"temperature up high",
	                                "low"=>"temperature up low",
	                                "correct"=>"temperature up correct"),
		                        "down"=>array(
		                            "high"=>"temperature down high",
		                            "low"=>"temperature down low",
		                            "correct"=>"temperature down correct"),
		                        "stable"=>array(
		                            "high"=>"temperature stable high",
		                            "low"=>"temperature stable low",
		                            "correct"=>"temperature stable correct"),
		                        "unstable"=>array(
		                            "high"=>"orp unstable high",
		                            "orp"=>"ph unstable low",
		                            "correct"=>"orp unstable correct"),			                            
                )
            );

// connect to the database
if (!$link = mysql_connect($options["database"]["host"], $options["database"]["username"], $options["database"]["password"])) {
    echo 'Could not connect to mysql';
    exit;
}


if (!mysql_select_db($options["database"]["name"], $link)) {
    echo 'Could not select database :'.$options["database"]["name"];
    exit;
}

// use order by timeStamp to really get the last value but they are aggregated by day...
$sql = "select ".$_GET["graph"].",id, timeStamp from (select ".$_GET["graph"].", id, timeStamp from measures order by timeStamp desc limit ".intval($_GET["period"]).") tempTable order by timeStamp asc";
// use order by id for test purpose
// *******
//$sql = "select ".$_GET["graph"].",id, timeStamp from (select ".$_GET["graph"].", id, timeStamp from measures order by id desc limit ".intval($_GET["period"]).") tempTable order by id asc";
//echo $sql; exit;
$result = mysql_query($sql, $link);

if (!$result) {
    echo mysql_error();
    exit;
}

$data = array();
while ($row = mysql_fetch_assoc($result)){
    $date = strtotime($row['timeStamp']);
    $hour = date('DH', $date);    
    $data[$row['timeStamp']] = $row[$_GET["graph"]];
    // ******* HOUR
    //$data[$hour] = $row[$_GET["graph"]];    
   // echo "<br>".$row['timeStamp']." ". $row[$_GET["graph"]]." ".$hour;
}
//exit;

header("Content-type: image/png");
//Create phpMyGraph instance
$graph = new phpMyGraph();
//Parse
switch ($_GET["type"]){
    case "barType":
        $cfg['label']=$_GET["title"];
        //$cfg['label-visible']=false;
        $cfg['value-label-visible']=false;
        $cfg['zero-line-visible']=false;
        $cfg['key-visible']=false;
        $cfg['value-visible']=false;
        $cfg['horizontal-divider-visible']=false;  
        $cfg['average-line-visible']=false;
        //$cfg['column-divider-visible']=false;
        $cfg['key-visible']=true;
    
        $graph->parseVerticalSimpleColumnGraph($data,$cfg);
    break;
    case "lineType":
        $cfg['key-visible']=true;
        $graph->parseVerticalLineGraph($data,$cfg);
    break;
    case "textType":
        switch ($_GET["period"]){
            case 8:
                $text.="Ces dernières 8 heures,";
            break;
            case 24:
                $text.="Au cours de cette dernière journée,";
            break;
            case 168:
                $text.="Sur la semaine,";
            break;
            default:
                $text.="Sur une periode de ".$_GET["period"]."heures,";
            break;
        }
        $values = array();
        foreach ($data as $value) {
            $values[] =  $value;
        }
        $trend=getTrend($values);
        $avg=array_sum($values) / count($values);
        $avg=($avg+$values[count($values)-1])/2;
        // we ponderate the average by re-avergaring with the last measure to make sure the instant value is not falsing the overall estimation

        $ratio=$trend/$avg;
        $threshold=0.005;

        $trendIndicator="stable";
        if ($ratio>$threshold) $trendIndicator="up";
        if ($ratio<-$threshold) $trendIndicator="down";
        $stdev = standard_deviation($values);
        $ratioDev=$stdev/$avg;
        if ($ratioDev>0.03) $trendIndicator="unstable";
        
        
        $reference=0;
        switch ($_GET["graph"]){
            case "ph":
                $reference=7.3;                
            break;
            case "orp";
                $reference=700;
            break;
            case "temperature";
                $reference=27;
            break;
            default:
            break;
        }

        $diffVal = $avg-$reference;
        $ecartVal = $diffVal/$reference;
        $currentValueIndicator = "correct"; 
        
        if ($ecartVal>0.09){ 
             $currentValueIndicator = "high";
        }else if ($ecartVal<-0.09){ 
             $currentValueIndicator = "low";
        }

        //$text.="\nTrend:".$trend;
        //$text.="\naverage:".$avg;
        //$text.="\nratio:".$ratio;
        //$text.="\ntrend:".$trendIndicator;
        //$text.="\nvalue:".$currentValueIndicator;
        //$text.="\navg:".$avg;
        //$text.="\nreference:".$reference;
        //$text.="\ndiffVal:".$diffVal;
        //$text.="\necartVal:".$ecartVal;
        //$text.="\ncurrentValueIndicator:".$currentValueIndicator;
        
        $text.="\n".$hint[$_GET["graph"]][$trendIndicator][$currentValueIndicator];

        //print_r($data); echo "<br>"; print_r($values); echo "<br>".$text; exit;

    default:
        if ($text==null) $text="unknown or undefined graph type ".$_GET["type"];

        $im = imagecreate($cfg['width'], $cfg['height']);
        $backgroundColor = imagecolorallocate($im, 255, 255, 255);
        imagecolortransparent($img, $backgroundColor);

        $box = new Box($im);
        $box->setFontFace('./fonts/Roboto-Regular.ttf'); // http://www.dafont.com/franchise.font
        $box->setFontColor(new Color(0, 0, 0, 50));
        $box->setTextShadow(new Color(200, 200, 200), 2, 2);
        $box->setFontSize(15);
        $box->setBox(10, 10, 460, 460);
        $box->setTextAlign('left', 'top');
        $box->draw($text);
        
        header("Content-type: image/png");
        imagepng($im);

    break;    
}

?>