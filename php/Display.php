<?php
class Display
{
    //Fills the list but does not gives the value back on selection
    /*
    public function displayList($selections, $name)
    {
        echo '<input list="'.$name.'" placeholder="">';
        echo '<datalist id="'.$name.'">';
        foreach ($selections as $item)
        {
            echo '<option value="'.$item.'">'.$item.'</option>';
        }
        echo '</datalist>';
    }
    */

    public function displayTable($themes)
    {
        echo '<table>';
            echo'<tr>';
                echo'<th>Vieta lentynoje</th>';
                echo'<th>Tema</th>';
                echo'</tr>';
                foreach ($themes as $theme)
                {
                    echo'<tr>';
                    echo'<td>'.$theme[0].'</td>';
                    echo'<td>'.$theme[1].'</td>';
                    echo'</tr>';
                }
        echo '</table>';
    }

    public function displayTabs($tabs,&$index)
    {
        echo'<div class="subTabButtons">';
        foreach($tabs as $tab)
        {
            echo'<button onclick="showSubContent('.$index.')">'.$tab.'</button>';
            $index++;

        }
        echo'</div>';
    }

    public function fillContentWithMaps($maps,$handler)
    {
        //button content
        for($i = 0; $i < sizeof($maps); $i++)
        {
            echo'<div class="subTabContent">';
            $this->displayImage($maps[$i]->returnBase64(),450,300); // <-- Needs a way to find out which map print-out
            echo'</div>';
        }
    }

    public function displayButton($text, $name)
    {
        echo '<input type="submit"'.'name="'.$name.'" value="'.$text.'"/>';
    }

    public function displayImage($source,$width,$height)
    {
        echo'<img src="'.$source.'"'.' width="'.$width.'" '. 'height="'.$height.' alt="Failed to load image">';
    }
}
?>