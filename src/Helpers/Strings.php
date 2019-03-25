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
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
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

    /**
 * Camelizes string
 *
 * @param string $inputString
 * @param bool   $upperCaseFirstLetter
 *
 * @return string
 *
 * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
 */
    public static function camelize($inputString, $upperCaseFirstLetter = false)
    {
        $inputString = trim($inputString);

        if ($upperCaseFirstLetter) {
            $inputString = ucfirst($inputString);
        } else {
            $inputString = lcfirst($inputString);
        }

        $inputString = preg_replace('/^[-_]+/', '', $inputString);

        $inputString = preg_replace_callback(
            '/[-_\s]+(.)?/u',
            function ($match) {
                if (isset($match[1])) {
                    return strtoupper($match[1]);
                } else {
                    return '';
                }
            },
            $inputString
        );

        $inputString = preg_replace_callback(
            '/[\d]+(.)?/u',
            function ($match) {
                return strtoupper($match[0]);
            },
            $inputString
        );

        return $inputString;
    }
    
}
