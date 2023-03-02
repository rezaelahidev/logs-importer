<?php

/**
 * Retrieve the random value of passed array.
 *
 * @param array $arr
 *
 * @since 1.0.0
 * @return string
 */
function randomValue(array $arr): string
{
    if (empty($arr)) {

        throw new Exception('The "$arr" variable was empty!', 500);
    }

    $random_index = array_rand($arr);

    return $arr[$random_index] ?? $arr[0];
}
