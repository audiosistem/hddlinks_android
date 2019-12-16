<?php
 /* get youtube video (live or not)
 * Copyright (c) 2019 vb6rocod
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
function youtube($file) {
function _splice($a,$b) {
	return  array_slice($a,$b);
}

function _reverse($a,$b) {
	return  array_reverse($a);
}

function _slice($a,$b) {
	$tS = $a[0];
	$a[0] = $a[$b % count($a)];
	$a[$b] = $tS;
	return  $a;
}
if(preg_match('/youtube\.com\/(v\/|watch\?v=|embed\/)([\w\-]+)/', $file, $match)) {
  $id = $match[2];
  $l = "https://www.youtube.com/watch?v=".$id;
  $html="";
  $p=0;

  while($html == "" && $p<10) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; rv:61.0) Gecko/20100101 Firefox/61.0');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close($ch);
  $p++;
  }

  $html = str_between($html,'ytplayer.config = ',';ytplayer.load');
  $parts = json_decode($html,1);


  $r1=json_decode($parts['args']['player_response'],1);
 if (isset($r1['streamingData']["hlsManifestUrl"])) {
      $url=$r1['streamingData']["hlsManifestUrl"];
      $ua="Mozilla/5.0 (Windows NT 5.1; rv:22.0) Gecko/20100101 Firefox/22.0";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
      curl_setopt($ch, CURLOPT_USERAGENT, $ua);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
      curl_setopt($ch, CURLOPT_TIMEOUT, 15);
      $h = curl_exec($ch);
      curl_close($ch);

      $a1=explode("\n",$h);
      if (preg_match("/\.m3u8/",$h)) {
       preg_match_all("/RESOLUTION\=(\d+)/i",$h,$m);
       $max_res=max($m[1]);
       for ($k=0;$k<count($a1);$k++) {
        if (strpos($a1[$k],$max_res) !== false) {
         $r=trim($a1[$k+1]);
         break;
        }
       }
      }
    return $r;
  } else {
  $videos=array();
  if (isset($r1['streamingData']['formats'][0]['url'])) {
  for ($k=0;$k<count($r1['streamingData']['formats']);$k++) {
    $videos[$r1['streamingData']['formats'][$k]['itag']]=$r1['streamingData']['formats'][$k]['url'];
  }
  } else if (isset($r1['streamingData']['formats'][0]['cipher'])) {
  for ($k=0;$k<count($r1['streamingData']['formats']);$k++) {
    $t1=explode("url=",$r1['streamingData']['formats'][$k]['cipher']);
    $videos[$r1['streamingData']['formats'][$k]['itag']]=urldecode($t1[1])."&".$t1[0];
  }
  }
  if (isset($videos['37']))
    $video= $videos['37'];
  else if (isset($videos['22']))
    $video= $videos['22'];
  else if (isset($videos['18']))
    $video= $videos['18'];
  else
    $video="";
  if ($video) {
  parse_str($video, $output);
  if (!isset($output['s'])) {
    $r=$video;
  } else {
  $sA="";
  $s=$output["s"];
  $tip=$output["sp"];
  $l = "https://s.ytimg.com".$parts['assets']['js'];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close($ch);
  $html1=str_replace("\n","",$html);
  preg_match('/([A-Za-z]{2})=function\(a\){a=a\.split\(\"\"\)/',$html1,$m);
  $sig=$m[1];
  $find='/\s?'.$sig.'=function\((?P<parameter>[^)]+)\)\s?\{\s?(?P<body>[^}]+)\s?\}/';
  preg_match($find,$html1,$m1);
  //print_r ($m1);  //UK=function(a){a=a.split("")
  //[parameter] = a
  //[body] = a=a.split("");TK.z6(a,23);TK.p8(a,2);TK.d4(a,55);TK.z6(a,6);return a.join("")
  //z6:function(a,b){var c=a[0];a[0]=a[b%a.length];  ----> _slice($sA,23)
  //var TK={p8:function(a,b){a.splice(0,b)} splice($sA,2)
  //d4:function(a){a.reverse()}}
  //z6:function(a,b){var c=a[0];a[0]=a[b%a.length];  ---> _slice($sA,6);

  // caut foate functiile de genul XY:function(a,b)
  preg_match_all("/\w{2}\:function\(\w,\w\)\{[\w\s\=\[\]\=\%\.\;\(\)\,]*\}/",$html1,$m3);

  $a=array(); // funtii gasite $a[XY]= splice etc
  for ($k=0;$k<count($m3[0]);$k++) {
    preg_match("/(\w{2})(\:function\(\w,\w\)\{)([\w\s\=\[\]\=\%\.\;\(\)\,]*)\}/",$m3[0][$k],$m4);
    //print_r ($m4);
    $a[$m4[1]]=$m4[3];
  }

  // caut toate functiile de genul XY:function(a)
  preg_match_all("/\w{2}\:function\(\w\)\{[\;\.\s\w\,\"\:\(\)\{\{]*\}/",$html1,$m2);
  for ($k=0;$k<count($m2[0]);$k++) {
     preg_match("/(\w{2})(\:function\(\w\)\{)([\;\.\s\w\,\"\:\(\)\{\{]*)\}/",$m2[0][$k],$m5);
     $a[$m5[1]]=$m5[3];
  }
  $x3 = preg_replace("/\w{2}\./","",$m1["body"]);
  $f=explode(";",$x3);
  for ($k=0;$k<count($f);$k++) {
    if (preg_match("/split/",$f[$k]))
      $sA = str_split($s);
    elseif (preg_match("/join/",$f[$k]))
      $sA = implode($sA);
    elseif (preg_match("/(\w+)\(\w+,(\d+)/",$f[$k],$r1)) { //AT(a,33)
       if (!$a[$r1[1]]) //daca nu exista nicio functie..... nu cred ca e cazul
          $sA = _slice($sA,$r1[2]); //????
       else {
         if (preg_match("/splice/",$a[$r1[1]]))
            $sA = _splice($sA,$r1[2]);
         elseif (preg_match("/reverse/",$a[$r1[1]]))
            $sA = _reverse($sA,$r1[2]);
         elseif (preg_match("/\w%\w\.length/",$a[$r1[1]]))
            $sA = _slice($sA,$r1[2]);
       }
    }
  }
  $signature = $sA;
  $r=$video."&".$tip."=".$signature;
}
} else {
 $r="";
}

return $r;
}
} else
  return "";
}
?>
