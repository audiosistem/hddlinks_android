<!DOCTYPE html>
<?php
include ("../common.php");
$page = $_GET["page"];
$search = $_GET['link'];
$page_title=urldecode($_GET['title']);
$width="200px";
$height=intval(200*(214/380))."px";
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>
      <title><?php echo $page_title; ?></title>
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
// https://player.teleon.tv/api/json-channels.php?country=14
$n=0;
echo '<h2>'.$page_title.'</h2>';
echo '<table border="1px" width="100%">'."\n\r";
$title="";
$l=$search;
$l="https://player.teleon.tv/api/json-channels.php?country=".$search;
//echo $l;
$ua = $_SERVER['HTTP_USER_AGENT'];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close($ch);
$x=json_decode($html,1);
//print_r ($x);


for($k=0;$k<count($x);$k++) {
 $link="https://player.teleon.tv/channel/".$x[$k]['slug'];

 $title = trim($x[$k]['title']);
 $descriere=$title;
 $l="link=".urlencode(fix_t($link))."&title=".urlencode(fix_t($title))."&from=teleon&mod=direct";
 $link1="direct_link.php?link=".$link."&title=".urlencode($title)."&from=teleon&mod=direct";

  if ($n == 0) echo "<TR>"."\n\r";
  if ($flash != "mp")
  echo '<td class="mp" width="25%"><a href="'.$link1.'" target="_blank">'.$title.'</a></TD>';
  else
  echo '<TD class="mp"  width="25%">'.'<a onclick="ajaxrequest('."'".$l."')".'"'." style='cursor:pointer;'>".''.$title.'</a></TD>';
    $n++;
    if ($n > 2) {
     echo '</TR>'."\n\r";
     $n=0;
    }
}
 if ($n<3) echo "</TR>"."\n\r";
 echo '</table>';
?>
<div id="overlay"">
  <div id="text">Wait....</div>
</div>
<BODY>
</HTML>
