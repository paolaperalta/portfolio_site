<?php 
// Get neccesery color
$hex = $_GET['color'];


// 
$r = hexdec(substr($hex, 0,2));
$g = hexdec(substr($hex, 2,2));
$b = hexdec(substr($hex, 4,2));

create_image($r, $g, $b); 
exit(); 

function create_image($r, $g, $b) { 
  
    //Set the image width and height 
    $width = 100; 
    $height = 20;  

    //Create the image resource 
    $image = ImageCreate($width, $height);  

    //We are making three colors, white, black and gray 
    $black = ImageColorAllocate($image, $r, $g, $b); 

    //Make the background black 
    ImageFill($image, 0, 0, $black); 
 
    //Tell the browser what kind of file is come in 
    header("Content-Type: image/jpeg"); 

    //Output the newly created image in jpeg format 
    ImageJpeg($image); 
    
    //Free up resources
    ImageDestroy($image); 
} 
?>