<?php
$newArray = array('jan', 'feb', 'march', 'april', 'may');

foreach ($newArray as $key => $value) {
    if ($value == 'april') {
        unset($newArray[$key]);
    }
}

print_r($newArray);
?>