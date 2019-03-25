<?php

namespace Manojkiran\LaravelHelpers\Helpers;

class StringHelper
{
    /**
     * Extracts the string between two substrings
     *
     * @param string $inputString
     * @param string $onLeft
     * @param string $onRight
     *
     * @return string
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     */
    public static function between(string $inputString,string $onLeft, string $onRight)
    {
        $inputString = ' ' . $inputString;
        $ini   = strpos( $inputString, $onLeft);

        if ($ini == 0) {
            return '';
        }

        $ini += strlen( $onLeft);
        $len = strpos( $inputString, $onRight, $ini) - $ini;

        return substr( $inputString, $ini, $len);
    }   
}
