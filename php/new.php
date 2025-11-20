<?php

/**
 * Generates a random hexadecimal color code.
 *
 * @return string A random color code in the format #RRGGBB.
 */
function getRandomHexColor(): string
{
    // Generate three random numbers between 0 and 255 for Red, Green, and Blue.
    $red = mt_rand(0, 255);
    $green = mt_rand(0, 255);
    $blue = mt_rand(0, 255);

    // Format the numbers as two-digit hexadecimal strings and concatenate them.
    return '#' . str_pad(dechex($red), 2, '0', STR_PAD_LEFT)
               . str_pad(dechex($green), 2, '0', STR_PAD_LEFT)
               . str_pad(dechex($blue), 2, '0', STR_PAD_LEFT);
}

$randomColor = getRandomHexColor();

echo "Here is a random color code: " . $randomColor . PHP_EOL;

?>