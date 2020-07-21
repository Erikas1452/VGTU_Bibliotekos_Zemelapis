<?php

include 'ShelvesBlock.php';
include 'Shelf.php';

class DataGetter
{
    private $database;
    private $connection;

    private $themes;
    private $selected_val;

    private $shelves_blocks;



    public function __construct()
    {
        $this->shelves_blocks = array();
    }

    public function connect()
    {
        $db = "(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST=alma-ora12-test.vgtu.lt)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = alma)))";
        $this->connection = oci_connect('biblioteka', 'wGko4GV86srQ', $db);
    }

    public function getShelvesBlocks()
    {
//        $querry = 'CREATE VIEW lentynu_sarasas AS SELECT pavad_bpt as patalpa, vt_a_zem_blb, vt_p_zem_lent FROM bibl_lentynos JOIN bibl_lent_blokai ON id_blb_lent=id_blb JOIN bibl_patalpos ON id_bpt_blb=id_bpt JOIN bibl_lent_temos ON id_lent=id_lent_lekt JOIN bibl_kng_temos ON id_bkt_lekt=id_bkt;';
//        $results=oci_parse($this->connection,$querry);
//        oci_execute($results);
//
//        $index = 0;
//        while($row=oci_fetch_array($results))
//        {
//            echo $row[1]." ".$row[0];
//        }
//
        $shelves[0] = new Shelf(64,432, 120,453, "201 Auditorija", array("Matematika","Diskrecioji"));
        $shelves[1] = new Shelf(122,432,179,453, "201 Auditorija", array("Istorija"));
        $this->shelves_blocks[0]=new ShelvesBlock(87,1590,151,1691,"2 Aukstas",$shelves);
        $shelves = array();
        $shelves[0] = new Shelf(64,535,120,555,"202 Auditorija",array("Mechanika","Transporto Logistika"));
        $this->shelves_blocks[1]=new ShelvesBlock(87,1742,151,1843,"2 Aukstas",$shelves);
    }

    public function getValueFromSelection($button,$value_to_get)
    {
        if (isset($_POST[$button]))
        {
            $this->selected_val = $_POST[$value_to_get];
        }
    }

    public function getThemes()
    {
//        $querry = 'SELECT PAVAD_LT_BKT, UDK_BKT  FROM bibl_kng_temos';
//        $results=oci_parse($this->connection,$querry);
//        oci_execute($results);
//
//        $index = 0;
//        while($row=oci_fetch_array($results))
//        {
//            $theme = array($row[0],$row[1]);
//            $this->themes[$index] = $theme;
//            $index++;
//        }

        $theme1 = array("Matematika", "001");
        $theme2 = array ("Diskrecioji", "002");
        $theme3 = array("Transporto Logistika", "003");
        $theme4 = array("Istorija", "004");
        $theme5 = array("Mechanika", "005");
        $this->themes[0] = $theme1;
        $this->themes[1] = $theme2;
        $this->themes[2] = $theme3;
        $this->themes[3] = $theme4;
        $this->themes[4] = $theme5;
    }

    public function returnThemes()
    {
        return $this->themes;
    }

    public function returnSelectedValue()
    {
        return $this->selected_val;
    }

    public function returnShelvesBlocks()
    {
        return $this->shelves_block;
    }

    public function returnBlocks()
    {
        return $this->shelves_blocks;
    }
}
?>