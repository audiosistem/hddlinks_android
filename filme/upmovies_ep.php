<!DOCTYPE html>
<?php
error_reporting(0);
include ("../common.php");
$tit=unfix_t(urldecode($_GET["title"]));
$image=$_GET["image"];
$link=urldecode($_GET["link"]);
$tip=$_GET["tip"];
$year=$_GET['year'];
$sez=$_GET['sez'];
/* ======================================= */
$width="200px";
$height="100px";
$fs_target="upmovies_fs.php";
$has_img="no";
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="../custom.css" />
<title><?php echo $tit; ?></title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

</head>
<body>
<?php

function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
if (preg_match("/(:|-)?\s+Season\s+(\d+)/i",$tit,$m)) {
  $tit=trim(str_replace($m[0],"",$tit));
}
echo '<h2>'.$tit.'</h2>';

  $episod="1";
  $season=$sez;
  $host=parse_url($link)['host'];
  $last_good="https://".$host;
  $ua="Mozilla/5.0 (Windows NT 10.0; rv:75.0) Gecko/20100101 Firefox/75.0";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $link);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_REFERER,$last_good);
  curl_setopt($ch, CURLOPT_ENCODING,"");
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
  curl_setopt($ch, CURLOPT_TIMEOUT, 25);
  $h = curl_exec($ch);
  curl_close($ch);
  //echo $h;
  $m=array();
  $videos=explode('<a class="episode episode_series_link',$h);
  unset($videos[0]);
  $videos = array_values($videos);
  foreach($videos as $video) {
   $t1=explode('href="',$video);
   $t2=explode('"',$t1[1]);
   $t3=explode(">",$t1[1]);
   $t4=explode("<",$t3[1]);
   $m[$t4[0]]=$t2[0];
  }
  //print_r ($m);
$n=0;

echo '<table border="1" width="100%">'."\n\r";
echo '<TR><td class="sez" style="color:black;background-color:#0a6996;color:#64c8ff;text-align:center" colspan="3">Sezonul '.($sez).'</TD></TR>';

$t1=explode("- Season",$tit);
$tit1=trim($t1[0]);
$t1 = explode("- Miniseries",$tit1);
$tit1=trim($t1[0]);

foreach ($m as $key=>$value) {
  $episod=$key;
  $link = $value;
  //print_r ($m[1]);
  //echo $z;
  $title = "";

  $ep_tit=$title;
  $img_ep=$image;
  $season=$sez;


  if ($ep_tit)
   $ep_tit_d=$season."x".$episod." ".$ep_tit;
  else
   $ep_tit_d=$season."x".$episod;

  $link_f=$fs_target.'?tip=series&link='.urlencode($link).'&title='.urlencode(fix_t($tit)).'&image='.$img_ep."&sez=".$season."&ep=".$episod."&ep_tit=".urlencode(fix_t($ep_tit))."&year=".$year;
   if ($n == 0) echo "<TR>"."\n\r";
   if ($has_img == "yes")
    echo '<TD class="mp" width="33%">'.'<a id="sez'.$sez.'" href="'.$link_f.'" target="_blank"><img width="'.$width.'" height="'.$height.'" src="'.$img_ep.'"><BR>'.$ep_tit_d.'</a></TD>'."\r\n";
   else
    echo '<TD class="mp" width="33%">'.'<a id="sez'.$sez.'" href="'.$link_f.'" target="_blank">'.$ep_tit_d.'</a></TD>'."\r\n";
   $n++;
   if ($n == 3) {
    echo '</TR>'."\n\r";
    $n=0;
   }
}  
  if ($n < 3 && $n > 0) {
    for ($k=0;$k<3-$n;$k++) {
      echo '<TD></TD>'."\r\n";
    }
    echo '</TR>'."\r\n";
  }
echo '</table>';
?>
</body>
</html>
