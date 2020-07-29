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

    public function __construct()
    {
        $this->shelvesBlocks = array();
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

    public function getShelvesBlocks()
    {
        $shelves[0] = new Shelf(64,432, 120,453, "201 Auditorija", array("x++","PHP"));
        $shelves[1] = new Shelf(122,432,179,453, "201 Auditorija", array("C++ pradmenys"));
        $this->shelvesBlocks[0]=new ShelvesBlock(87,1590,151,1691,"2 Aukstas",$shelves);
        $shelves = array();
        $shelves[0] = new Shelf(64,535,120,555,"202 Auditorija",array("Tikimybes","integruotos prog aplinkos"));
        $this->shelvesBlocks[1]=new ShelvesBlock(87,1742,151,1843,"2 Aukstas",$shelves);
    }

    public function getValueFromSelection($button,$value_to_get)
    {
        if (isset($_POST[$button]))
        {
            $this->selectedVal = $_POST[$value_to_get];
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
            echo "ERROR";
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

    public function returnBlocks()
    {
        return $this->shelvesBlocks;
    }
}
?>