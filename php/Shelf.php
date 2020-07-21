<?php
    class Shelf
    {
        private $x1;
        private $x2;
        private $y1;
        private $y2;
        private $themes;
        private $room;

        function __construct($x1, $y1, $x2, $y2, $room,$themes)
        {
            $this->themes = array();

            $this->room=$room;

            $this->x1 = $x1;
            $this->x2 = $x2;
            $this->y1 = $y1;
            $this->y2 = $y2;

            $this->themes = $themes;
        }

        public function returnThemes()
        {
            return $this->themes;
        }

        public function returnCoordinates()
        {
            return array($this->x1,$this->y1,$this->x2,$this->y2);
        }

        public function returnRoom()
        {
            return $this->room;
        }
    }
?>