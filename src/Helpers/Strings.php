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
    /**
     * Check if string starts with substring
     *
     * @param string $inputString
     * @param string $subString
     *
     * @return bool
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     */
     public static function startsWith(string  $inputString, string $subString)
    {
        return mb_strpos($inputString, $subString) === 0;
    }

    /**
     * Check if string ends with substring
     *
     * @param string $inputString
     * @param string $subString
     *
     * @return bool
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
    */
    public static function endsWith(string $inputString, string $subString)
    {
        return mb_substr($inputString, -strlen($subString)) === $subString;
    }

    /**
     * Removes prefix from start of string
     *
     * @param string $inputString
     * @param string $prefixString
     *
     * @return string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     */
    public static function chompLeft(string $inputString, string $prefixString)
    {
        if (static::startsWith($inputString, $prefixString)) {
            return mb_substr($inputString, mb_strlen($prefixString));
        }
        return $inputString;
    }

    /**
     * Removes suffix from end of string
     *
     * @param string $inputString
     * @param string $suffixString
     *
     * @return string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     */
    public static function chompRight(string $inputString, string $suffixString)
    {
        if ( static::endsWith($inputString, $suffixString)) {
            return mb_substr($inputString, 0, mb_strlen($inputString) - mb_strlen($suffixString));
        }

        return $inputString;
    }
    /**
     * Converts string to camelized class name. First letter is always upper case
     *
     * @param string $string
     *
     * @return string
     * @author Aurimas Niekis <aurimas@niekis.lt>
     */
    function classify($string)
    {
        return camelize($string, true);
    }
    
}
