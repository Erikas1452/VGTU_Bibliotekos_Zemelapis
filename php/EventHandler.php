<?php

class EventHandler extends Display
{
    public function onButtonDisplayImage($button,$image)
    {
        if(isset($_POST[$button]))
        {
            echo '<br><br>';
            $this->displayImage($image,693,542);
        }
    }
}
?>