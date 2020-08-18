<?php

$db = "(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST=alma-ora12-test.vgtu.lt)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = alma)))";
$connection = oci_connect('biblioteka', 'wGko4GV86srQ', $db);

$res = oci_new_descriptor($connection);
$mapID = $_POST['map'];
$stmt = oci_parse($connection,"begin :res := get_all_room_shelf_coords_fnc(:id); end;");
oci_bind_by_name($stmt, ':res', $res, -1,OCI_B_CLOB);
oci_bind_by_name($stmt, ':id', $mapID, 50000);

if(oci_execute($stmt))
{
echo $res->load();
}
