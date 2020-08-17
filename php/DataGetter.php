<?php

class DataGetter
{
    private $database;
    private $connection;

    private $themes;
    private $selectedVal;

    private $floors;

    public function __construct()
    {
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

    private function formatSQL(array $params): string
    {
        $sql = '';

        for ($i = 0; $i < \count($params); $i++) {
            if ($i == 0) {
                $sql .= ':' . array_keys($params)[$i];
            } else {
                $sql .= ', :' . array_keys($params)[$i];
            }
        }

        $sql .= '); end;';

        return $sql;
    }

    public function call(string $name, array $params = []): ?array
    {
        $connect = $this->connection;

        $sql = 'BEGIN :r := ' . $name . '(';
        $sql .= $this->formatSQL($params);

        $stmt = oci_parse($connect, $sql);

        foreach ($params as $key => $value) {
            oci_bind_by_name($stmt, ':' . $key, $params[$key], 50000);
        }

        $r = oci_new_descriptor($connect);
        oci_bind_by_name($stmt, ':r', $r, -1, OCI_B_CLOB);

        if(oci_execute($stmt)) return $r ? json_decode($r->load(), true) : $r;
        else return "Error";

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
        $params['id'] = $mapID;
        $params['x'] = round($x,0);
        $params['y'] = round($y,0);

        $stmt = 'bibl_json_pck.get_room_shelf_coords_fnc';

        return json_encode($this->call($stmt,$params));
    }

    public function getFloor($id)
    {

        $params['id'] = $id;
        $params['p_kalba_i'] = "lt";

        $stmt = 'bibl_json_pck.get_floor_map_and_rooms_fnc';

        $obj = $this->call($stmt,$params);
        return array($obj["mapClob"],$obj["rooms"]);
    }

    public function getFloorTabs()
    {
        $params['p_kalba_i'] = "lt";
        $stmt = 'bibl_json_pck.get_all_floors_fnc';

        $obj = $this->call($stmt,$params);

        $index = 0;

        foreach ($obj as $floor)
        {
            foreach ($floor as $data) {
                $temp = array($data["name"], $data["id"]);
                $this->floors[$index] = $temp;
                $index++;
            }
        }
    }

    public function getRoomClick($mapID,$x,$y)
    {
        $params['id'] = $mapID;
        $params['x'] = round($x,0);
        $params['y'] = round($y,0);

        $stmt = "bibl_json_pck.get_room_id_by_coords_fnc";

        return json_encode($this->call($stmt,$params));

    }

    public function getFloorTabsByTopic($topic)
    {
        $params['udk'] = $topic;
        $params['p_kalba_i'] = "lt";

        $stmt = 'bibl_json_pck.get_all_topic_locations_fnc';


        $index = 0;
        $tempTabs = array();

        $obj = $this->call($stmt,$params);

        $obj = $obj["shelves"];
        foreach ($obj as $shelf) {
            if(!in_array($shelf["name"],$tempTabs))
            {
                $tempTabs[$index] = $shelf["name"];

                $temp = array($shelf["name"],$shelf["floorId"]);
                $this->floors[$index] = $temp;

                $index++;
            }
        }
    }

    public function getShelves($topic)
    {
        $params['id'] = $topic;
        $params['p_kalba_i'] = "lt";

        $stmt = 'bibl_json_pck.get_all_topic_locations_fnc';

        return json_encode($this->call($stmt,$params));

    }

    public function getRoom($id)
    {

        $params['id'] = $id;
        $params['p_kalba_i'] = "lt";

        $stmt ='bibl_json_pck.get_room_map_fnc';

        $obj = $this->call($stmt,$params);
        return  $obj["mapClob"];

    }

    public function getShelfThemes($shelfID)
    {
        $params['id'] = $shelfID;
        $params['p_kalba_i'] = "lt";

        $stmt ='bibl_json_pck.get_all_shelf_topics_fnc';

        return json_encode($this->call($stmt,$params));

    }

    public function getThemes()
    {
        $params['p_kalba_i'] = "lt";

        $stmt ='bibl_json_pck.get_all_topic_udks_names_fnc';

        $obj = $this->call($stmt,$params);

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

    public function getTables($id)
    {
        $params['id'] = $id;
        $params['p_kalba_i'] = "lt";

        $stmt ='bibl_json_pck.get_room_table_coords_fnc';

        return json_encode($this->call($stmt,$params));
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