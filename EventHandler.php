<?php

class EventHandler extends Display
{
    public function buttonPressed($button,$image)
    {
        if(isset($_POST[$button]))
        {
            echo '<br><br>';
            $this->displayImage($image,1000,600);
        }
    }
}
?>