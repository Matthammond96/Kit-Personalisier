<?php
// Corridante Class
class archCord {
  public $x;
  public $y;
  public $r;

  function __construct($cordX, $cordY){
    $this->x = $cordX;
    $this->y = $cordY;
  }
}

// Declare Array
$cordArray = array();

// Pull Text From URL
$text = '';
if ( $_GET['kitname'] == '' ) {
    $text = "mosi";
} else {
    $text = $_GET['kitname'];
}

// Setting up image
$r = 0;
$text = strtoupper($text);
$fontSize = 26.5;
$bgImage = 'img/home-kit.jpg';
$my_img = imagecreatefromjpeg($bgImage);
$fontname = 'font/Spurs_V1_004.ttf';
$text_colour = imagecolorallocate( $my_img, 22, 26, 74);
imagealphablending($my_img, true);
imagesavealpha($my_img, true);

// Radius of X & Y
$radX = 400;
$radY = 400;
// Setting Offset Values
$offsetX = 7.5;
$offsetY = -168;
$offsetR = 1.22;

// Setting desired centre point
$hx = (imagesx($my_img) / 2) - $offsetX;
$hy = (imagesy($my_img) / 2) - $offsetY;

// Number of sets in curve
$stepsI = 1260;
$steps = 2 * pi() / $stepsI;
$loopsCount = 0;

for ($theta = (2 * pi() / 2) + $offsetR; $theta < (2 * pi()) - $offsetR; $theta += $steps) {
  //Creating Curves X & Y Corrdiantes
  $curveX = $hx + $radX * cos($theta);
  $curveY = $hy + $radY * sin($theta);

  // Mapping out Triangles Vertexs
  $Ax = $curveX;
  $Ay = $hy;
  $Bx = $hx;
  $By = $hy;
  $Cx = $curveX;
  $Cy = $curveY;

  // Working out Existing Sides Length
  $AB = $Bx - $Ax;
  $AC = $By - $Cy;

  // Working out Missing Side Length
  $AB2 = pow($AB, 2);
  $AC2 = pow($AC, 2);
  $CB = sqrt($AB2 + $AC2);

  // Working out The Angle
  $Z = rad2deg(acos($AB / $CB)) - 90;

  // Adding the X,Y and R to object Array
  $cord = new archCord;
  $cord->x = $curveX;
  $cord->y = $curveY;
  $cord->r = $Z;
  $cordArray[$loopsCount] = $cord;
  $loopsCount++;
}

// Defininf String Length, Array Count and Emcerment amount between letters
$stringLength = strlen($text);
$arrayCount = count($cordArray);
$emcrement = 10.5;

// Function used to visually draw curve
for ($m = 0; $m < $arrayCount; $m++) {
    $drawX = $cordArray[$m]->x;
    $drawY = $cordArray[$m]->y;

    $letter = '.';

    // imagettftext($my_img, $fontSize, $r, $drawX, $drawY, $text_colour, $fontname, $letter);

    // Vissuallising The horizontal Line
    // imageline($my_img, $cordArray[0]->x, $cordArray[0]->y, $cordArray[$arrayCount - 1]->x, $cordArray[$arrayCount - 1]->y, 255);
}

$extraspacing;

// Loop through Letters
for ($n = 0; $n < $stringLength; $n++) {
  // Centering Word on Curve
  $difference = $n - ($stringLength / 2);
  $letterSteps = $difference * $emcrement;
  $middleValue = $arrayCount / 2;

  // Fetching Curve Values from Object Array
  $letterX = $cordArray[$middleValue + $letterSteps + 5.8]->x;
  $letterY = $cordArray[$middleValue + $letterSteps + 5.8]->y;
  $letterR = $cordArray[$middleValue + $letterSteps + 5.8]->r * -1;

  switch ($text[$n]) {
    case 'M':
      $extraspacing = 4;
    break;
  }

  // Adding the Letters to the Image
  imagettftext($my_img, $fontSize, $letterR, $letterX, $letterY - 5, $text_colour, $fontname, $text[$n]);
}

// Required for image rendering
header( "Content-type: image/png" );
imagepng( $my_img );
imagecolordeallocate( $text_color );
imagedestroy( $my_img );

?>
