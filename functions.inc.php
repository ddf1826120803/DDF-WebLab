<?php

function generateLink($url, $label, $class) {
   $link = '<a href="' . $url . '" class="' . $class . '">';
   $link .= $label;
   $link .= '</a>';
   return $link;
}


function outputPostRow($number)  {
    include("travel-data.inc.php");
    switch($number){
      case 1:display($thumb1,$title1,$userName1,$reviewsRating1,$reviewsNum1,$excerpt1,$date1);break;
      case 2:display($thumb2,$title2,$userName2,$reviewsRating2,$reviewsNum2,$excerpt2,$date2);break;
      case 3:display($thumb3,$title3,$userName3,$reviewsRating3,$reviewsNum3,$excerpt3,$date3);break;
    }
}
function display($thumb,$title,$username,$reviewsRating,$reviewsNum,$excerpt,$date){
  $img='<img class="col-md-4" src="images/'.$thumb.'">';
  echo $img;
  $div2 = '<div class="col-md-8">';
  $h2 = '<h2>'.$title.'</h2>';
  $p1='<p>POSTED BY '.generateLink("#",$username,"").'<span style="float:right">'.$date.'</span>'.'</p>';
  $imgTag = constructRating($reviewsRating);
  $span = '<span> '.$reviewsNum.' REVIEWS'.'</span>';
  $p2 = '<p>'.$imgTag.$span.'</p>';
  $p3 ='<p>'.$excerpt.'</p>';
  $btn = '<p><a class="btn btn-warning btn-md">Read more &raquo;</a></p>';
  echo $div2.$h2.$p1.$p2.$p3.$btn.'</div>';
  echo '<div style="clear:both;"></div>';
  echo '<hr/>';
}
/*

/*
  Function constructs a string containing the <img> tags necessary to display
  star images that reflect a rating out of 5
*/
function constructRating($rating) {
    $imgTags = "";
    
    // first output the gold stars
    for ($i=0; $i < $rating; $i++) {
        $imgTags .= '<img src="images/star-gold.svg" width="16" />';
    }
    
    // then fill remainder with white stars
    for ($i=$rating; $i < 5; $i++) {
        $imgTags .= '<img src="images/star-white.svg" width="16" />';
    }    
    
    return $imgTags;    
}

?>