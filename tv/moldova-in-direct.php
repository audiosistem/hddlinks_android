<!DOCTYPE html>
<?php
error_reporting(0);
include ("../common.php");
include ("../util.php");
$width="200px";
$height=intval(200*(176/268))."px";
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>
      <title>Moldova in Direct</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../custom.css" />
<script type="text/javascript">
function ajaxrequest(link) {
  var request =  new XMLHttpRequest();
  on();
  var the_data = link;
  var php_file='direct_link.php';
  request.open('POST', php_file, true);			// set the request

  // adds a header to tell the PHP script to recognize the data as is sent via POST
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(the_data);		// calls the send() method with datas as parameter

  // Check request status
  // If the response is received completely, will be transferred to the HTML tag with tagID
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      off();
      document.getElementById("mytest1").href=request.responseText;
      document.getElementById("mytest1").click();
    }
  }
}
</script>
</head>
<body>
<script>
function on() {
    document.getElementById("overlay").style.display = "block";
}

function off() {
    document.getElementById("overlay").style.display = "none";
}
</script>
   <a href='' id='mytest1'></a>
<?php
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
if (file_exists($base_pass."player.txt")) {
$flash=trim(file_get_contents($base_pass."player.txt"));
} else {
$flash="direct";
}
if (file_exists($base_pass."mx.txt")) {
$mx=trim(file_get_contents($base_pass."mx.txt"));
} else {
$mx="ad";
}
$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
if ($flash != "mp") {
if (preg_match("/android|ipad/i",$user_agent) && preg_match("/chrome|firefox|mobile/i",$user_agent)) $flash="chrome";
}
$n=0;
/////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////
$ua="Mozilla/5.0 (Windows NT 10.0; rv:99.0) Gecko/20100101 Firefox/99.0";
$cookie=$base_cookie."hdpopcorns.dat";
echo '<h2>Moldova in Direct</H2>';
echo '<table border="1px" width="100%">'."\n\r";
$link="https://www.trm.md/ro/moldova-in-direct/";
$link="http://trm.md/ro/moldova-in-direct/";
$link="http://www.trm.md/ro/moldova-in-direct";
//$link="https://www.trm.md/ro/moldova-1";
$link="https://www.trm.md/ro/joi-cu-liliana-barbarosie";
$link="https://www.trm.md/ro/joi-cu-liliana-barbarosie";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $link);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
  curl_setopt($ch, CURLOPT_TIMEOUT, 25);
  $html = curl_exec($ch);
  curl_close($ch);
  //echo $html;
//$html = file_get_contents($link);
$videos = explode('div class="_dq-news-read-more', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1=explode('alt="',$video);
    $t2=explode('"',$t1[1]);
    $title=$t2[0];

    $t1=explode('src="',$video);
    //$t2=explode('value="',$t1[1]);
    $t3=explode('"',$t1[1]);
    $image="../filme/r_m.php?file=https://www.trm.md".$t3[0];
    $image="https://www.trm.md".$t3[0];
    $t1=explode('href="',$video);
    $t2=explode('"',$t1[1]);
    $link="https://www.trm.md".$t2[0];
    //$link=str_replace("tiny-","",$image);
    //$link=str_replace("jpg","mp4",$link);
    $link1="direct_link.php?link=".$link."&title=".urlencode(fix_t($title))."&from=moldova&mod=direct";
    $l="link=".urlencode(fix_t($link))."&title=".urlencode(fix_t($title))."&from=moldova&mod=direct";
  if ($link && $title) {
  if ($n==0) echo '<TR>';
  if ($flash == "flash")
  echo '<td class="mp" align="center" width="25%"><a href="'.$link1.'" target="_blank"><img src="'.$image.'" width="'.$width.'" height="'.$height.'"><BR>'.$title.'</a></TD>';
    else
  echo '<td class="mp" align="center" width="25%">'.'<a onclick="ajaxrequest('."'".$l."')".'"'." style='cursor:pointer;'>".'<img src="'.$image.'" width="'.$width.'" height="'.$height.'"><BR>'.$title.'</a></TD>';

  $n++;
  if ($n == 4) {
  echo '</tr>';
  $n=0;
  }
  }
}
$n=0;
$link="https://www.trm.md/ro/miezul-zilei";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $link);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
  curl_setopt($ch, CURLOPT_TIMEOUT, 25);
  $html = curl_exec($ch);
  curl_close($ch);
//$html = file_get_contents($link);
$videos = explode('div class="_dq-news-read-more', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1=explode('alt="',$video);
    $t2=explode('"',$t1[1]);
    $title=$t2[0];

    $t1=explode('src="',$video);
    //$t2=explode('value="',$t1[1]);
    $t3=explode('"',$t1[1]);
    $image="http://www.trm.md".$t3[0];
    $t1=explode('href="',$video);
    $t2=explode('"',$t1[1]);
    $link="http://www.trm.md".$t2[0];
    //$link=str_replace("tiny-","",$image);
    //$link=str_replace("jpg","mp4",$link);
    $link1="direct_link.php?link=".$link."&title=".urlencode(fix_t($title))."&from=moldova&mod=direct";
    $l="link=".urlencode(fix_t($link))."&title=".urlencode(fix_t($title))."&from=moldova&mod=direct";
  if ($link && $title) {
  if ($n==0) echo '<TR>';
  if ($flash != "mp")
  echo '<td class="mp" align="center" width="25%"><a href="'.$link1.'" target="_blank"><img src="'.$image.'" width="'.$width.'" height="'.$height.'"><BR>'.$title.'</a></TD>';
    else
  echo '<td class="mp" align="center" width="25%">'.'<a onclick="ajaxrequest('."'".$l."')".'"'." style='cursor:pointer;'>".'<img src="'.$image.'" width="'.$width.'" height="'.$height.'"><BR>'.$title.'</a></TD>';

  $n++;
  if ($n == 4) {
  echo '</tr>';
  $n=0;
  }
  }
}
//echo "</table>";

$n=0;
$link="http://www.trm.md/ro/buna-seara";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $link);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
  curl_setopt($ch, CURLOPT_TIMEOUT, 25);
  $html = curl_exec($ch);
  curl_close($ch);
//$html = file_get_contents($link);
$videos = explode('div class="_dq-news-read-more', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1=explode('alt="',$video);
    $t2=explode('"',$t1[1]);
    $title=$t2[0];

    $t1=explode('src="',$video);
    //$t2=explode('value="',$t1[1]);
    $t3=explode('"',$t1[1]);
    $image="http://www.trm.md".$t3[0];
    $t1=explode('href="',$video);
    $t2=explode('"',$t1[1]);
    $link="http://www.trm.md".$t2[0];
    //$link=str_replace("tiny-","",$image);
    //$link=str_replace("jpg","mp4",$link);
    $link1="direct_link.php?link=".$link."&title=".urlencode(fix_t($title))."&from=moldova&mod=direct";
    $l="link=".urlencode(fix_t($link))."&title=".urlencode(fix_t($title))."&from=moldova&mod=direct";
  if ($link && $title) {
  if ($n==0) echo '<TR>';
  if ($flash != "mp")
  echo '<td class="mp" align="center" width="25%"><a href="'.$link1.'" target="_blank"><img src="'.$image.'" width="'.$width.'" height="'.$height.'"><BR>'.$title.'</a></TD>';
    else
  echo '<td class="mp" align="center" width="25%">'.'<a onclick="ajaxrequest('."'".$l."')".'"'." style='cursor:pointer;'>".'<img src="'.$image.'" width="'.$width.'" height="'.$height.'"><BR>'.$title.'</a></TD>';

  $n++;
  if ($n == 4) {
  echo '</tr>';
  $n=0;
  }
  }
}

$n=0;
$link="https://www.trm.md/ro/editii-speciale";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $link);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
  curl_setopt($ch, CURLOPT_TIMEOUT, 25);
  $html = curl_exec($ch);
  curl_close($ch);
//$html = file_get_contents($link);
$videos = explode('div class="_dq-news-read-more', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1=explode('alt="',$video);
    $t2=explode('"',$t1[1]);
    $title=$t2[0];

    $t1=explode('src="',$video);
    //$t2=explode('value="',$t1[1]);
    $t3=explode('"',$t1[1]);
    $image="http://www.trm.md".$t3[0];
    $t1=explode('href="',$video);
    $t2=explode('"',$t1[1]);
    $link="http://www.trm.md".$t2[0];
    //$link=str_replace("tiny-","",$image);
    //$link=str_replace("jpg","mp4",$link);
    $link1="direct_link.php?link=".$link."&title=".urlencode(fix_t($title))."&from=moldova&mod=direct";
    $l="link=".urlencode(fix_t($link))."&title=".urlencode(fix_t($title))."&from=moldova&mod=direct";
  if ($link && $title) {
  if ($n==0) echo '<TR>';
  if ($flash != "mp")
  echo '<td class="mp" align="center" width="25%"><a href="'.$link1.'" target="_blank"><img src="'.$image.'" width="'.$width.'" height="'.$height.'"><BR>'.$title.'</a></TD>';
    else
  echo '<td class="mp" align="center" width="25%">'.'<a onclick="ajaxrequest('."'".$l."')".'"'." style='cursor:pointer;'>".'<img src="'.$image.'" width="'.$width.'" height="'.$height.'"><BR>'.$title.'</a></TD>';

  $n++;
  if ($n == 4) {
  echo '</tr>';
  $n=0;
  }
  }
}
echo "</table>";
?>
<div id="overlay"">
  <div id="text">Wait....</div>
</div>
</body>
</html>
