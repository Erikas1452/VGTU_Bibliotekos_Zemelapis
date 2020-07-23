<?php

class EventHandler extends Display
{
    public function onButtonDisplayImage($button,$source)
    {
        if(isset($_POST[$button]))
        {
            echo '<br><br>';
            $this->displayImage($source,693,542);
        }
    }
}
?>