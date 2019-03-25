<?php

namespace Manojkiran\LaravelHelpers\Helpers;

class StringHelper
{
    /**
 * Extracts the string between two substrings
 *
 * @param string $input
 * @param string $onLeft
 * @param string $onRight
 *
 * @return string
 *
 * @author Manojkiran.A <manojkiran10031998@gmail.com>
 */
    function between($input='', $onLeft='', $onRight='')
    {
        $input = ' ' . $input;
        $ini   = strpos($input, $onLeft);

        if ($ini == 0) {
            return '';
        }

        $ini += strlen( $onLeft);
        $len = strpos($input, $onRight, $ini) - $ini;

        return substr($input, $ini, $len);
}
}
