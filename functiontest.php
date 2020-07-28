<?php
$db = "(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST=alma-ora12-test.vgtu.lt)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = alma)))";
$connection = oci_connect('biblioteka', 'wGko4GV86srQ', $db);

if(!$connection) echo "Failed to connect";

$stid = oci_parse($connection,"begin :a := return_string(); end;");
oci_bind_by_name($stid, ':a', $myString, 40);
if(oci_execute($stid))
{
    echo $myString;
}
else{
    echo "Error";
}

oci_free_statement($stid);

$stid = oci_parse($connection,"begin :a := return_integer(); end;");
oci_bind_by_name($stid, ':a', $myInteger, 40);
if(oci_execute($stid))
{
    echo $myInteger;
}
else{
    echo "Error";
}

oci_free_statement($stid);
$stid = oci_parse($connection,"begin :a := get_clob(); end;");
oci_bind_by_name($stid, ':a', $res,6000000);
if(oci_execute($stid))
{
    echo $res;
    $obj = json_decode($res);
    echo '<br>';
    print $obj->{'JS'};
}
else{
    echo "Error";
}

oci_free_statement($stid);
$stid = oci_parse($connection,"begin :a := gauti_visus_kng_pavad_fnc(); end;");
oci_bind_by_name($stid, ':a', $res,1000000);
if(oci_execute($stid))
{
    echo $res;
    //$obj = json_decode($res);
    //foreach ($obj->{"bookNames"} as $name) echo $name.'<br>';
}
else{
    echo $res;
    echo "Error";
}