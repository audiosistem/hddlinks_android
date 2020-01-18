<!DOCTYPE html>
<?php
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
function unfuck($js) {
  $js=str_replace('(+[![]]+[+(+!+[]+(!+[]+[])[!+[]+!+[]+!+[]]+[+!+[]]+[+[]]+[+[]]+[+[]])])[+!+[]+[+[]]]',"'y'",$js);
  $js = str_replace('+[]','0',$js);
  $a1 =array(
   'false' => '![]',
   'true' => '!![]',
   'undefined' => '[][[]]',
   'NaN' => '+[![]]',
   'Infinity' => '+(+!+[]+(!+[]+[])[!+[]+!+[]+!+[]]+[+!+[]]+[+[]]+[+[]]+[+[]])',
  );
  foreach($a1 as $key=>$value) {
    $js=str_replace($value,$key,$js);
  }
  preg_match_all("/\[([\+\!]*0\+?)+\]/",$js,$m);
  for ($k=0;$k<count($m[0]);$k++) {
    $s=str_replace("[","",$m[0][$k]);
    $s=str_replace("]","",$s);
    $code="\$v=".$s.";";
    eval ($code);
    $js=str_replace($m[0][$k],"'".$v."'",$js);
  }

  $js=str_replace('([false]0[[]])','(falseundefined)',$js);
  $js=str_replace("(undefined0)'2'",'d',$js);
  $js=str_replace("(false0)'0'","f",$js);
  $js=str_replace("(false0)'1'","a",$js);
  $js=str_replace("(false0)'3'","s",$js);
  $js=str_replace("(false0)'2'","l",$js);
  $js=str_replace("(!false0)'1'","r",$js);
  $js=str_replace("(undefined0)'0'","u",$js);
  $js=str_replace("(undefined0)'1'","n",$js);
  preg_match_all("/\[(.*?)\]/",$js,$m);
  for ($k=0;$k<count($m[0]);$k++) {
    $s=str_replace("[","",$m[0][$k]);
    $s=str_replace("]","",$s);
    $s=str_replace("'","",$s);
    $code="\$v=".$s.";";
    eval ($code);
    $js=str_replace($m[0][$k],"'".$v."'",$js);
  }
  $js=str_replace("(falseundefined)'1'","i",$js);
  $js=str_replace("++","+",$js);
  $js=str_replace("'","",$js);
  $js=str_replace("+","",$js);
  return $js;
}
include ("../common.php");
/* =================================================== */
$l="https://moviegaga.to";
$host=parse_url($l)['host'];
$page = $_GET["page"];
$tip= $_GET["tip"];
$tit=$_GET["title"];
$link=$_GET["link"];
$width="200px";
$height="278px";
/* ==================================================== */
$has_fav="yes";
$has_search="yes";
$has_add="yes";
$has_fs="yes";
$fav_target="moviegaga_s_fav.php?host=https://".$host;
$add_target="moviegaga_s_add.php";
$add_file="";
$fs_target="moviegaga_ep.php";
$target="moviegaga_s.php";
/* ==================================================== */
$base=basename($_SERVER['SCRIPT_FILENAME']);
$p=$_SERVER['QUERY_STRING'];
parse_str($p, $output);

if (isset($output['page'])) unset($output['page']);
$p = http_build_query($output);
if (!isset($_GET["page"]))
  $page=1;
else
  $page=$_GET["page"];
$next=$base."?page=".($page+1)."&".$p;
$prev=$base."?page=".($page-1)."&".$p;
/* ==================================================== */
$tit=unfix_t(urldecode($tit));
$link=unfix_t(urldecode($link));
/* ==================================================== */
if (file_exists($base_cookie."seriale.dat"))
  $val_search=file_get_contents($base_cookie."seriale.dat");
else
  $val_search="";
$form='<form action="'.$target.'" target="_blank">
Cautare serial:  <input type="text" id="title" name="title" value="'.$val_search.'">
<input type="hidden" name="page" id="page" value="1">
<input type="hidden" name="tip" id="tip" value="search">
<input type="hidden" name="link" id="link" value="">
<input type="submit" id="send" value="Cauta...">
</form>';
/* ==================================================== */
if ($tip=="search") {
  $page_title = "Cautare: ".$tit;
  if ($page == 1) file_put_contents($base_cookie."seriale.dat",$tit);
} else
  $page_title=$tit;
/* ==================================================== */

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>
<title><?php echo $page_title; ?></title>
<script type="text/javascript" src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="../jquery.fancybox.min.js"></script>
<link rel="stylesheet" type="text/css" href="../jquery.fancybox.min.css">
<link rel="stylesheet" type="text/css" href="../custom.css" />

<script type="text/javascript">
var id_link="";
function ajaxrequest(link) {
  var request =  new XMLHttpRequest();
  var the_data = link;
  var php_file='<?php echo $add_target; ?>';
  request.open("POST", php_file, true);			// set the request

  // adds a header to tell the PHP script to recognize the data as is sent via POST
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(the_data);		// calls the send() method with datas as parameter

  // Check request status
  // If the response is received completely, will be transferred to the HTML tag with tagID
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      alert (request.responseText);
    }
  }
}
function isValid(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode,
    self = evt.target;
    if (charCode == "49") {
     id = "imdb_" + self.id;
     id_link=self.id;
     val_imdb=document.getElementById(id).value;
     msg="imdb.php?" + val_imdb;
     document.getElementById("fancy").href=msg;
     document.getElementById("fancy").click();
    } else if  (charCode == "51") {
      id = "fav_" + self.id;
      val_fav=document.getElementById(id).value;
      ajaxrequest(val_fav);
    }
    return true;
}
   function zx(e){
     var instance = $.fancybox.getInstance();
     var charCode = (typeof e.which == "number") ? e.which : e.keyCode
     if (charCode == "13"  && instance !== false) {
       $.fancybox.close();
       setTimeout(function(){ document.getElementById(id_link).focus(); }, 500);
     } else if (charCode == "53" && e.target.type != "text") {
      document.getElementById("send").click();
     } else if (charCode == "50" && e.target.type != "text") {
      document.getElementById("fav").click();
    }
   }
function isKeyPressed(event) {
  if (event.ctrlKey) {
    id = "imdb_" + event.target.id;
    val_imdb=document.getElementById(id).value;
    msg="imdb.php?" + val_imdb;
    document.getElementById("fancy").href=msg;
    document.getElementById("fancy").click();
  }
}
$(document).on('keyup', '.imdb', isValid);
document.onkeypress =  zx;
</script>
</head>
<body>
<a id="fancy" data-fancybox data-type="iframe" href=""></a>
<?php
$w=0;
$n=0;
echo '<H2>'.$page_title.'</H2>'."\r\n";

echo '<table border="1px" width="100%" style="table-layout:fixed;">'."\r\n";
echo '<TR>'."\r\n";
if ($page==1) {
   if ($tip == "release") {
   if ($has_fav=="yes" && $has_search=="yes") {
     echo '<TD class="nav"><a id="fav" href="'.$fav_target.'" target="_blank">Favorite</a></TD>'."\r\n";
     echo '<TD class="form" colspan="2">'.$form.'</TD>'."\r\n";
     echo '<TD class="nav" align="right"><a href="'.$next.'">&nbsp;&gt;&gt;&nbsp;</a></TD>'."\r\n";
   } else if ($has_fav=="no" && $has_search=="yes") {
     echo '<TD class="nav"><a id="fav" href="">Reload...</a></TD>'."\r\n";
     echo '<TD class="form" colspan="2">'.$form.'</TD>'."\r\n";
     echo '<TD class="nav" align="right"><a href="'.$next.'">&nbsp;&gt;&gt;&nbsp;</a></TD>'."\r\n";
   } else if ($has_fav=="yes" && $has_search=="no") {
     echo '<TD class="nav"><a id="fav" href="'.$fav_target.'" target="_blank">Favorite</a></TD>'."\r\n";
     echo '<TD class="nav" colspan="3" align="right"><a href="'.$next.'">&nbsp;&gt;&gt;&nbsp;</a></TD>'."\r\n";
   } else if ($has_fav=="no" && $has_search=="no") {
     echo '<TD class="nav" colspan="4" align="right"><a href="'.$next.'">&nbsp;&gt;&gt;&nbsp;</a></TD>'."\r\n";
   }
   } else {
     echo '<TD class="nav" colspan="4" align="right"><a href="'.$next.'">&nbsp;&gt;&gt;&nbsp;</a></TD>'."\r\n";
   }
} else {
   echo '<TD class="nav" colspan="4" align="right"><a href="'.$prev.'">&nbsp;&lt;&lt;&nbsp;</a> | <a href="'.$next.'">&nbsp;&gt;&gt;&nbsp;</a></TD>'."\r\n";
}
echo '</TR>'."\r\n";
$ua="Mozilla/5.0 (Windows NT 10.0; rv:71.0) Gecko/20100101 Firefox/7";
if ($tip=="release") {
  $ref="https://".$host."/browse?t=1&p=".$page;
  $l="https://".$host."/live";
  $post="active=true";
  $head=array('Accept: text/html, */*; q=0.01',
   'Accept-Language: ro-RO,ro;q=0.8,en-US;q=0.6,en-GB;q=0.4,en;q=0.2',
   'Accept-Encoding: deflate',
   'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
   'X-Requested-With: XMLHttpRequest',
   'Content-Length: 11',
   'Origin: https://'.$host.'',
   'Connection: keep-alive',
   'Referer: '.$ref.'');
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$l);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt ($ch, CURLOPT_POST, 1);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close ($ch);
} else {
  $search=str_replace(" ","%20",$tit);
  $l="https://".$host."/search?q=".$search."&p=".$page;
  $head=array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    'Accept-Language: ro-RO,ro;q=0.8,en-US;q=0.6,en-GB;q=0.4,en;q=0.2',
    'Accept-Encoding: deflate',
    'Connection: keep-alive',
    'Referer: https://'.$host.'');
  $ch = curl_init($l);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  $t1=explode('cf.k =',$h);
  $t2=explode(';',$t1[1]);
  $js=trim($t2[0]);
  $jj=unfuck($js);
  $data_e="";
  $data_i="";
  $t1=explode('csdiff',$h);
  $t2=explode(';',$t1[1]);
  $code="\$timestamp".str_replace('new Date().getTime()/1000','time()',$t2[0]).";";
  eval ($code);
  $csdiff = $timestamp;
  $timestamp=floor(time() - $csdiff);
  $token=md5($jj.$data_e.$data_i.$timestamp);
  $head=array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    'Accept-Language: ro-RO,ro;q=0.8,en-US;q=0.6,en-GB;q=0.4,en;q=0.2',
    'Accept-Encoding: deflate',
    'Connection: keep-alive',
    'Cookie: timestamp='.$timestamp.'; token='.$token.'',
    'Referer: https://'.$host.'');
  curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
  $h = curl_exec($ch);
  curl_close ($ch);
}
$videos = explode('li class="grid', $h);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $year="";
  $t1=explode('href="',$video);
  $t2=explode('"',$t1[1]);
  $link="https://".$host.$t2[0];
  $t2 = explode('>', $t1[2]);
  $t3 = explode('<',$t2[1]);
  $title = $t3[0];
  $title = prep_tit($title);
  $t1 = explode('src="', $video);
  $t2 = explode('"', $t1[1]);
  $image = trim($t2[0]);
  if (strpos($image,"http") === false) $image="https:".$image;
  $t1=explode('"dateCreated">',$video);
  $t2=explode('<',$t1[1]);
  $year=$t2[0];
  $imdb="";
  $tit_imdb=$title;
  if (preg_match("/season-(\d+)/i",$link,$m))
    $sez=$m[1];
  else
    $sez="1";
  $link_f=$fs_target.'?tip=series&link='.urlencode($link).'&title='.urlencode(fix_t($title)).'&image='.$image."&sez=".$sez."&ep=&ep_tit=&year=".$year;
  if ($title) {
  if ($n==0) echo '<TR>'."\r\n";
  $val_imdb="tip=series&title=".urlencode(fix_t($tit_imdb))."&year=".$year."&imdb=".$imdb;
  $fav_link="mod=add&title=".urlencode(fix_t($title))."&link=".urlencode($link)."&image=".urlencode($image)."&year=".$year;
  if (strpos($image,"i.imgur.com") !== false) $image="r_m.php?file=".$image;
  if ($tast == "NU") {
    echo '<td class="mp" width="25%"><a href="'.$link_f.'" id="myLink'.$w.'" target="_blank" onmousedown="isKeyPressed(event)">
    <img id="myLink'.$w.'" src="'.$image.'" width="'.$width.'" height="'.$height.'"><BR>'.$title.' ('.$year.')</a>
    <input type="hidden" id="imdb_myLink'.$w.'" value="'.$val_imdb.'">'."\r\n";
    if ($has_add=="yes")
      echo '<a onclick="ajaxrequest('."'".$fav_link."'".')" style="cursor:pointer;">*</a>'."\r\n";
    echo '</TD>'."\r\n";
  } else {
    echo '<td class="mp" width="25%"><a class ="imdb" id="myLink'.$w.'" href="'.$link_f.'" target="_blank">
    <img src="'.$image.'" width="'.$width.'" height="'.$height.'"><BR>'.$title.' ('.$year.')</a>
    <input type="hidden" id="imdb_myLink'.$w.'" value="'.$val_imdb.'">'."\r\n";
    if ($has_add == "yes")
      echo '<input type="hidden" id="fav_myLink'.$w.'" value="'.$fav_link.'"></a>'."\r\n";
    echo '</TD>'."\r\n";
  }
  $w++;
  $n++;
  if ($n == 4) {
  echo '</tr>'."\r\n";
  $n=0;
  }
  }
 }

/* bottom */
  if ($n < 4 && $n > 0) {
    for ($k=0;$k<4-$n;$k++) {
      echo '<TD></TD>'."\r\n";
    }
    echo '</TR>'."\r\n";
  }
echo '<tr>
<TD class="nav" colspan="4" align="right">'."\r\n";
if ($page > 1)
  echo '<a href="'.$prev.'">&nbsp;&lt;&lt;&nbsp;</a> | <a href="'.$next.'">&nbsp;&gt;&gt;&nbsp;</a></TD>'."\r\n";
else
  echo '<a href="'.$next.'">&nbsp;&gt;&gt;&nbsp;</a></TD>'."\r\n";
echo '</TR>'."\r\n";
echo "</table>"."\r\n";
echo "</table>";
?></body>
</html>
