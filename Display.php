<?php
class Display
{
    //Fills the list but does not gives the value back on selection
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
                    echo'<td>'.$theme[1].'</td>';
                    echo'<td>'.$theme[0].'</td>';
                    echo'</tr>';
                }
        echo '</table>';
    }

    public function displayButton($text, $name)
    {
        echo '<input type="submit"'.'name="'.$name.'" value="'.$text.'"/>';
    }

    public function displayImage($path,$width,$height)
    {
        echo'<img src="'.$path.'"'.' width="'.$width.'" '. 'height="'.$height.'">';
    }

    public function displayImageRotated($path,$width,$height)
    {
        echo'<img src="'.$path.'"'.' width="'.$width.'" '. 'height="'.$height.'">';
    }

    public function displayCanvas($id,$width,$height)
    {
        echo '<canvas id="'.$id.'"'.'width="'.$width. '" height="'.$height.'" 
        style="border:1px solid #c3c3c3;"> </canvas>';
    }
}
?>