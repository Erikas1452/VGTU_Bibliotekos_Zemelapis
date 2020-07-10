<?php

class EventHandler extends Display
{
    public function onButtonDisplayImage($button,$image)
    {
        if(isset($_POST[$button]))
        {
            echo $_Post[$button];
            echo '<br><br>';
            $this->displayImage($image,1000,600);
        }
    }
    public function Find
}
?>