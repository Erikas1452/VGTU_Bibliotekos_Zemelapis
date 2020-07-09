<?php
class Display
{
    public function displaySelection($selections, $name)
    {
        echo '<select name="'.$name.'"';
        foreach ($selections as $item)
        {
            echo '<option value="' . $item . '">' . $item . '</option>';
        }
        echo '</select>';
    }

    public function displayButton($text, $name)
    {
        echo '<input type="submit"'.'name="'.$name.'" value="'.$text.'"/>';
    }

    public function displayImage($path,$width,$height)
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