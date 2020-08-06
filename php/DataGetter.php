<?php

include 'ShelvesBlock.php';
include 'Shelf.php';

class DataGetter
{
    private $database;
    private $connection;

    private $themes;
    private $selectedVal;

    private $shelvesBlocks;
    private $floors;

    public function __construct()
    {
        $this->shelvesBlocks = array();
        $this->floors = array();
    }

    public function connect()
    {
        $db = "(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST=alma-ora12-test.vgtu.lt)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = alma)))";
        $this->connection = oci_connect('biblioteka', 'wGko4GV86srQ', $db);
        if(!$this->connection){
            oci_error();
            oci_close($this->connection);
        }
    }

    public function getValueFromSelection($button,$value_to_get)
    {
        if (isset($_POST[$button]))
        {
            $this->selectedVal = $_POST[$value_to_get];
        }
    }

    public function getShelf($mapID,$x,$y)
    {
        $newX = round($x,0);
        $newY = round($y, 0);
        $res = oci_new_descriptor($this->connection);
        $stmt = oci_parse($this->connection,"begin :res := get_coords_fnc(:id, :x, :y); end;");
        oci_bind_by_name($stmt, ':res', $res, -1,OCI_B_CLOB);
        oci_bind_by_name($stmt, ':id', $mapID, 50000);
        oci_bind_by_name($stmt, ':x', $newX, 50000);
        oci_bind_by_name($stmt, ':y', $newY, 50000);
        if(oci_execute($stmt))
        {
            return $res->load();
        }
        else {
            echo "Error";
        }
    }

    public function getFloor($id)
    {
        $res = oci_new_descriptor($this->connection);
        $lang = "lt";
        $stmt = oci_parse($this->connection,"begin :a := get_floor_fnc(:b, :lang); end;");
        oci_bind_by_name($stmt, ':a', $res, -1,OCI_B_CLOB);
        oci_bind_by_name($stmt, ':b', $id, 50000);
        oci_bind_by_name($stmt, ':lang', $lang, 50000);
        if(oci_execute($stmt))
        {
            $obj = json_decode($res->load(),true);
            return array($obj["mapClob"],$obj["patalpos"]);
        }
        else {
            echo "Error while getting floor";
        }
    }

    public function getFloorTabs()
    {
        $stmt = oci_parse($this->connection,"begin :a := get_all_floors_fnc(); end;");
        $res = oci_new_descriptor($this->connection);
        oci_bind_by_name($stmt, ':a', $res, -1,OCI_B_CLOB);


        $index = 0;
        if(oci_execute($stmt))
        {
            $obj = json_decode($res->load(),true);

            foreach ($obj as $floor)
            {
                foreach ($floor as $data) {
                    $temp = array($data["floor"], $data["id"]);
                    $this->floors[$index] = $temp;
                    $index++;
                }
            }
        }
        else {
            echo "Error while getting tab names";
        }
    }

    public function getRoom($id)
    {
        $res = oci_new_descriptor($this->connection);
        $lang = "en";
        $stmt = oci_parse($this->connection,"begin :a := get_room_fnc(:b, :lang); end;");
        oci_bind_by_name($stmt, ':a', $res, -1,OCI_B_CLOB);
        oci_bind_by_name($stmt, ':b', $id, 50000);
        oci_bind_by_name($stmt, ':lang', $lang, 50000);

        if(oci_execute($stmt))
        {
            $obj = json_decode($res->load(),true);
            return $obj["mapClob"];
        }
        else {
            echo "Error while getting room map";
        }
    }

    public function getShelfThemes($shelfID)
    {
        $res = oci_new_descriptor($this->connection);
        $lang = "lt";
        $stmt = oci_parse($this->connection,"begin :res := get_all_shelf_topics_fnc(:id, :lang); end;");
        oci_bind_by_name($stmt, ':res', $res, -1,OCI_B_CLOB);
        oci_bind_by_name($stmt, ':id', $shelfID, 50000);
        oci_bind_by_name($stmt, ':lang', $lang, 50000);

        if(oci_execute($stmt))
        {
            return $res->load();
        }
        else {
            echo "Error";
        }
    }

    public function getThemes()
    {

        $stmt = oci_parse($this->connection,"begin :json := gauti_visus_kng_pavad_fnc(:lang); end;");
        $lang = "lt";
        oci_bind_by_name($stmt,':lang', $lang, 50000);
        $res = oci_new_descriptor($this->connection);
        oci_bind_by_name($stmt, ':json', $res, -1,OCI_B_CLOB);


        if(oci_execute($stmt))
        {
            $obj = json_decode($res->load(),true);
            $size = 0;
            foreach ($obj as $themes) {
                foreach ($themes as $theme) {
                    $index = 0;
                    $tempTheme = array();
                    foreach ($theme as $value) {
                        $tempTheme[$index] = $value;
                        $index++;
                    }
                    $this->themes[$size] = $tempTheme;
                    $size++;
                }
            }
        }
        else {
            echo "Error while getting all themes";
        }
    }

    public function returnThemes()
    {
        return $this->themes;
    }

    public function returnSelectedValue()
    {
        return $this->selectedVal;
    }


    public function returnFloorNames()
    {
        return $this->floors;
    }
}
?>