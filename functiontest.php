<?php

$db = "(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST=alma-ora12-test.vgtu.lt)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = alma)))";
$connection = oci_connect('biblioteka', 'wGko4GV86srQ', $db);

if(!$connection) echo "Failed to connect";

//$stid = oci_parse($connection,"begin :a := return_string(); end;");
//oci_bind_by_name($stid, ':a', $myString, 40);
//if(oci_execute($stid))
//{
//    echo $myString;
//}
//else{
//    echo "Error";
//}
//
//echo '<br>';
//echo '<br>';
//echo '<br>';
//
//oci_free_statement($stid);
//
//$stid = oci_parse($connection,"begin :a := return_integer(); end;");
//oci_bind_by_name($stid, ':a', $myInteger, 40);
//if(oci_execute($stid))
//{
//    echo $myInteger;
//}
//else{
//    echo "Error";
//}
//
//echo '<br>';
//echo '<br>';
//echo '<br>';
//
//oci_free_statement($stid);
//$stid = oci_parse($connection,"begin :a := get_clob(); end;");
//oci_bind_by_name($stid, ':a', $res,6000000);
//if(oci_execute($stid))
//{
//    echo $res;
//    $obj = json_decode($res);
//    echo '<br>';
//    print $obj->{'JS'};
//}
//else{
//    echo "Error";
//}
//
//echo '<br>';
//echo '<br>';
//echo '<br>';
//
//oci_free_statement($stid);
//$stid = oci_parse($connection,"begin :a := gauti_visus_kng_pavad_fnc(:lang); end;");
//$lang = "lt";
//oci_bind_by_name($stid,':lang', $lang, 50000);
//$res = oci_new_descriptor($connection);
//oci_bind_by_name($stid, ':a', $res, -1,OCI_B_CLOB);
//if(oci_execute($stid))
//{
//    echo $res->load();
//    $obj = json_decode($res->load(),true);
//    $books = $obj["themes"];
//    echo sizeof($books);
//    foreach ($books as $theme)
//    {
//        echo sizeof($theme);
//        echo $theme["udk"].' '.$theme["name"].'<br>';
//    }
//    echo $obj[0]->{"bookNames"};
//
//}
//else{
//    echo "Error";
//}
//
//echo '<br>';
//echo '<br>';
//echo '<br>';

//oci_free_statement($stid);
//$stid = oci_parse($connection,"begin :a := why_oracle_fnc(); end;");
//oci_bind_by_name($stid, ':a', $res, -1,OCI_B_CLOB);
//if(oci_execute($stid))
//{
//    echo $res->load();
//    $obj = json_decode($res->load());
//    $array = $obj->{"bookNames"};
//    echo sizeof($array);
//    foreach ($array  as $theme)
//    {
//        echo $theme->{"1"};
//    }
//}
//else{
//    echo "Error";
//}
//echo "<br>";
//echo "IMAGE IMAGE IMAGE";
//$res = oci_new_descriptor($connection);;
//oci_free_statement($stid);
//$stid = oci_parse($connection,"begin :a := test_get_blob_png_fnc(); end;");
//oci_bind_by_name($stid, ':a', $res, -1,OCI_B_CLOB);
//if(oci_execute($stid))
//{
//    echo $res->load();
//    $obj = json_decode($res->load(),true);
//    $img = $obj["blob"];
//    echo'<br>';
//    echo $img;
//}
//else{
//    echo "Error";
//}
//
//$source = "data:image/png;base64,".$img;
//$width =600;
//$height=575;
//echo'<img src="'.$source.'"'.' width="'.$width.'" '. 'height="'.$height.' alt="Failed to load image">';
//
//echo '<br>';
//echo '<br>';
//echo '<br>';

//echo "<br>";
//echo "IMAGE IMAGE IMAGE";
//$res = oci_new_descriptor($connection);;
//oci_free_statement($stid);
//$stid = oci_parse($connection,"begin :a := get_all_floors_fnc(); end;");
//oci_bind_by_name($stid, ':a', $res, -1,OCI_B_CLOB);
//if(oci_execute($stid))
//{
//    echo $res->load();
//    $obj = json_decode($res->load(),true);
//    echo sizeof($obj);
//    $img = $obj["floor1"]["mapClob"];
//    echo sizeof($img);
//    echo'<br>';
//    echo $img;
//}
//else {
//    echo "Error";
//}
//
//echo '<br>';
//echo '<br>';
//echo '<br>';

echo "<br>";
$res = oci_new_descriptor($connection);;
oci_free_statement($stid);
$id = 27;
//oci_bind_by_name($stid, ':b', $id,50000);
echo "2";
$stid = oci_parse($connection,"begin :a := get_floor_fnc(:b); end;");
echo "2";
oci_bind_by_name($stid, ':a', $res, -1,OCI_B_CLOB);
oci_bind_by_name($stid, ':b', $id, 50000);
echo "2";

if(oci_execute($stid))
{
    echo "SUCESS";
    echo $res->load();
    $obj = json_decode($res->load(),true);
    echo sizeof($obj);
    echo sizeof($img);
    echo'<br>';
    echo $img;
}
else {
    echo "Error";
}

echo '<br>';
echo '<br>';
echo '<br>';

$data = base64_decode($obj["floor444"]["mapClob"]);

$img = imagecreatefromstring($data);
imagealphablending($img, false);
imagesavealpha($img, true);

ob_start();
imagepng($img);
$contents = ob_get_contents();
ob_end_clean();
$source = "data:image/png;base64," . base64_encode($contents);

$width =600;
$height=575;
echo'<img src="'.$source.'"'.' width="'.$width.'" '. 'height="'.$height.' alt="Failed to load image">';