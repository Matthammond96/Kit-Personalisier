<?php

class archCord {
  public $x;
  public $y;
  public $r;

  function __construct($cordX, $cordY){
    $this->x = $cordX;
    $this->y = $cordY;
  }
}

$cordArray = array();

$text = '';
$bgImage = 'img/home-kit.jpg';

if ( $_GET['kitname'] == '' ) {
    $text = "kaneagaga";
} else {
    $text = $_GET['kitname'];
}

$text = strtoupper($text);
$r = 0;
$fontSize = 20;

$my_img = imagecreatefromjpeg($bgImage);

$fontname = 'font/Spurs_V1_004.ttf';
$text_colour = imagecolorallocate( $my_img, 116, 133, 201 );
imagealphablending($my_img, true);
imagesavealpha($my_img, true);

$lineX = 0;
$lineY = 180;
$radX = 150;
$radY = 70;
$offsetX = 5;
$offsetY = 30;
$offsetR = 0.5;

$hx = (imagesx($my_img) / 2) - $offsetX;
$hy = (imagesy($my_img) / 2) - $offsetY;

$stepsI = 360;
$steps = 2 * pi() / $stepsI;
$loopsCount = 0;

for ($theta = (2 * pi() / 2) + $offsetR; $theta < (2 * pi()) - $offsetR; $theta += $steps) {
  $a = ($hx + $radX * cos($theta)) - $lineX;
  $k = ($hy + $radY * sin($theta)) - $lineY;

  $ac = $a - $hx;
  $ysss = abs($k - $hy);

  $powAC = pow(2, $ac);
  $powYSSSS = pow(2, $ysss);
  $missingLength = sqrt($powAC + $powYSSSS);
  $expML = log($missingLength, 15);

  $ytest = $ac / $expML;

  $angle = acos($ytest) * 180 / Pi();
  echo round($ac) . '   /   ' . round($expML) . '     =     ' . $ytest . '    :    ' . $angle . '<br>';

  $cord = new archCord;
  $cord->x = $a;
  $cord->y = $k;
  $cord->r = 90 - $angle;

  $cordArray[$loopsCount] = $cord;
  $loopsCount++;
}

for ($m = 0; $m < 360; $m++) {
    $drawX = $cordArray[$m]->x;
    $drawY = $cordArray[$m]->y;

    $letter = '.';

    imagettftext($my_img, $fontSize, $r, $drawX, $drawY, $text_colour, $fontname, $letter);
}

$stringLength = strlen($text);
$arrayCount = count($cordArray);
$emcrement = 10;

for ($n = 0; $n < $stringLength; $n++) {
  $difference = ($n) - ($stringLength / 2);
  $letterSteps = $difference * $emcrement;

  $middleValue = $arrayCount / 2;


  $centering = $stringLength * 2;

  $letterX = $cordArray[$middleValue + $letterSteps + ($emcrement / 2)]->x;
  $letterY = $cordArray[$middleValue + $letterSteps + ($emcrement / 2)]->y;
  $letterR = $cordArray[$middleValue + $letterSteps + ($emcrement / 2)]->r;

  imagettftext($my_img, $fontSize, $letterR, $letterX, $letterY, $text_colour, $fontname, $text[$n]);
}

header( "Content-type: image/png" );
imagepng( $my_img );

imagecolordeallocate( $text_color );
imagedestroy( $my_img );

?>
