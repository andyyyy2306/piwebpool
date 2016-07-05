<?php

require "includes/gd-text/Box.php";
require "includes/gd-text/Color.php";
require "includes/gd-text/TextWrapping.php";
require "includes/gd-text/HorizontalAlignment.php";
require "includes/gd-text/VerticalAlignment.php";

use GDText\Box;
use GDText\Color;

$im = imagecreatetruecolor(500, 500);
$backgroundColor = imagecolorallocate($im, 0, 18, 64);
imagefill($im, 0, 0, $backgroundColor);

$box = new Box($im);
$box->setFontFace('./Roboto-Regular.ttf'); // http://www.dafont.com/franchise.font
$box->setFontColor(new Color(255, 75, 140));
$box->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
$box->setFontSize(10);
$box->setBox(20, 20, 460, 460);
$box->setTextAlign('left', 'top');
$box->draw("Franchise\nBold");

header("Content-type: image/png");
imagepng($im);