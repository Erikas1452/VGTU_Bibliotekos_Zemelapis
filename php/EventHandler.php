<?php
class EventHandler extends Display
{
    public function buttonPressed($Button)
    {
        if(isset($_POST[$Button]))
        {
            echo '<br><br>';
            $this->displayImage("images/LT1.jpg",1000,600);
        }
    }
}
?>