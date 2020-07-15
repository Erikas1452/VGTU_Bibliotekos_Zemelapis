<?php

function someFunc($a)
{
    echo $a;
}

function callFunc($name)
{
    $name('funky!');
}

callFunc('someFunc');