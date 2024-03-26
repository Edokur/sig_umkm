<?php
//memanggil file json
$json_url = "https://kependudukan.jogjaprov.go.id/statistik/get/penduduk/pendidikan/15/0/00/04/34.json";
$content=@file_get_contents("$json_url");
$json = json_decode($content, true);

// var_dump($json);die;
echo '<pre>'; print_r($json); echo '</pre>'; die;

//memanggil judul statistik
$judulstatistik="";
if(!empty($json[0]["judulstatistik"])){
$judulstatistik = $json[0]["judulstatistik"];
}

//memanggil isi statistik
$isistatistik="";
if(!empty($json[0]["isistatistik"])){
$isistatistik = $json[0]["isistatistik"];
}

//memanggil isi statistik
$isistatistik="";
if(!empty($json[0]["isistatistik"])){
$isistatistik = $json[0]["isistatistik"];
}

//memanggil koordinat pusat statistik
$koordinatpusat="";
if(!empty($json[0]["koordinatpusat"])){
$koordinatpusat = $json[0]["koordinatpusat"];
}

//memanggil koordinat peta statistik
$petagis="";
if(!empty($json[0]["petagis"])){
$petagis = $json[0]["petagis"];
}

//menampilkan judul dan isi statistik
echo"$judulstatistik $isistatistik";


// //Mengurai isi statistik
// echo"<h3>Menampilkan semua</h3>";
// echo"<table>";
// echo"<tr> <th>NamaWilayah</th> <th>Pria</th> <th>Wanita</th> <th>TotPW</th> <th>Luas Wilayah</th> <th>Koordinat</th> <th>Map Poligon</th> </tr>";
// for($i=0;$i<count($json);$i++){
//     $NamaWilayah="";
//     if(!empty($json[$i]["NamaWilayah"])){$NamaWilayah = $json[$i]["NamaWilayah"];}
//     $Pria="";
//     if(!empty($json[$i]["Pria"])){$Pria = $json[$i]["Pria"];}
//     $Wanita="";
//     if(!empty($json[$i]["Wanita"])){$Wanita = $json[$i]["Wanita"];}
//     $TotPW="";
//     if(!empty($json[$i]["TotPW"])){$TotPW = $json[$i]["TotPW"];}
//     $longitude="";
//     if(!empty($json[$i]["longitude"])){$longitude = $json[$i]["longitude"];}
//     $latitude="";
//     if(!empty($json[$i]["latitude"])){$latitude = $json[$i]["latitude"];}
//     $luaswilayah="";
//     if(!empty($json[$i]["luaswilayah"])){$luaswilayah = $json[$i]["luaswilayah"];}
//     $map="";
//     if(!empty($json[$i]["map"])){$map = $json[$i]["map"];}
//     echo"<tr><td>$NamaWilayah</td><td>$Pria</td><td>$Wanita</td><td>$TotPW</td><td>$luaswilayah Km2</td><td>$latitude, $longitude</td><td>$map</td></tr>";
// }
// echo"</table>";
?>