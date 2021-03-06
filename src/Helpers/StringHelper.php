<?php

namespace Manojkiran\LaravelHelpers\Helpers;
use Manojkiran\LaravelHelpers\Helpers\ArrayHelper;

class StringHelper
{
    /**
     * Extracts the string between two substrings
     *
     * @param string   $inputString (The input string)
     * @param string $onLeft (The Starting form String)
     * @param string $onRight (The Ending upto String)
     * @param string $spanUptoLast (Set to true if you need to span upto last of the string)
     *
     * @return string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     * @updated 1.0.7
     */
    public static function between(string $inputString, string $onLeft, string $onRight,bool $spanUptoLast = false)
    {
        $inputString = ' ' . $inputString;
        $initializeString   = strpos($inputString, $onLeft);

        if ($initializeString == 0) 
        {
            return '';
        }

        if ($spanUptoLast == true) 
        {
            $matches = [];
            $regex = "/$onLeft([a-zA-Z0-9_]*)$onRight/";
            preg_match_all($regex, $inputString, $matches);
            return implode('',$matches[1]);
        }
        
        $initializeString += strlen($onLeft);
        $length = strpos($inputString, $onRight, $initializeString) - $initializeString;
        return substr($inputString, $initializeString, $length);
    }


    /**
     * Camelizes string
     *
     * @param string   $inputString the input string
     * @param bool   $upperCaseFirstLetter
     *
     * @return string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function camelize(string $inputString,bool $upperCaseFirstLetter = false)
    {
        $inputString = trim($inputString);

        if ($upperCaseFirstLetter) {
            $inputString = static::upperCaseFirst($inputString);
        } else {
            $inputString = static::lowerCaseFirst($inputString);
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
     * Removes prefix from start of string
     *
     * @param string   $inputString the input string
     * @param string $prefixString
     *
     * @return string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
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
     * @param string   $inputString the input string
     * @param string $suffixString
     *
     * @return string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function chompRight( string $inputString, string $suffixString)
    {
        if (static::endsWith( $inputString, $suffixString)) {

            return mb_substr($inputString, 0, mb_strlen($inputString) - mb_strlen($suffixString));
        }

        return $inputString;
    }

    /**
     * Converts string to camelized class name. First letter is always upper case
     *
     * @param string   $inputString the input string
     *
     * @return string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function classify(string $inputString)
    {
        return static::camelize($inputString, true);
    }


    /**
     * Collapse multiple spaces
     *
     * @param string   $inputString the input string
     *
     * @return string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function collapseWhitespace(string $inputString)
    {
        return preg_replace('/\s+/u', ' ', $inputString);
    }

    /**
     * Check if string contains substring
     *
     * @param string   $inputString the input string
     * @param string $subString
     * @param bool $isCaseSensitive (is Check need to be Performed With case Sensitive default will be true)
     *
     * @return bool
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function contains( string $inputString, string $subString,bool $isCaseSensitive = true)
    {
        return $isCaseSensitive == false ? mb_stripos($inputString, $subString) !== false : 
                mb_strpos($inputString, $subString) !== false;
    }

    /**
     * Count the occurrences of substring in string
     *
     * @param string   $haystack the input string
     * @param string ||  array  $needles
     * @param bool $caseSensitive need to check as case sensitive (defaults to true)
     * @param bool $returnEachCount returns the count with each needles (defaults to false)
     * @param string $returnTypeCount type of returning while $returnEachCount is set to true so try 'ARR' or 'STR'
     * 
     *
     * @return int or array or string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     *  @updated 1.0.7
     */
    public static function countOccurrences(string $haystack ,  $needles , bool $caseSensitive = true , bool $returnEachCount = false,string $returnTypeCount = 'ARR')
    {
        $returnTypeCount = strtoupper($returnTypeCount);
        
        !is_array($needles) ? $needles = explode(' ',$needles) :$needles = $needles;

        //$needles = array_unique($needles);

        foreach ($needles as $eachNeedle) 
        {
            $count[] = substr_count($haystack == false ? strtolower($haystack): $haystack, $caseSensitive == false ? strtolower($eachNeedle): $eachNeedle);
        }
        if ($returnEachCount == true)
        {
            if ($returnTypeCount == 'ARR') 
            {
            return array_combine($needles,$count);
            }
            elseif($returnTypeCount == 'STR')
            {
                return str_replace('=', ':', http_build_query(array_combine($needles,$count), null, ','));
            }else 
            {
                throw new \Exception("Try either ARR or STR", 1);    
            }
            
        }else 
        {
            return  ArrayHelper::arrayAddition($count);
        }

    }

    /**
     * Converts hyphens and camel casing to underscores
     *
     * @param string   $inputString the input string
     *
     * @return string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function dasherize(string $inputString)
    {
        return strtolower(preg_replace('/(?<!^)([A-Z])/', '-$1', str_replace('_', '-', $inputString)));
    }

    /**
     * Check if string ends with substring
     *
     * @param string   $inputString the input string
     * @param string $subString
     *
     * @return bool
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function endsWith( string $inputString, string $subString)
    {
        return mb_substr($inputString, -strlen($subString)) === $subString;
    }

    /**
     * Check if string contains only letters
     *
     * @param string   $inputString the input string
     *
     * @return bool
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function isAlpha( string $inputString)
    {
        return ctype_alpha($inputString);
    }

    /**
     * Check if string contains only alphanumeric
     *
     * @param string   $inputString the input string
     *
     * @return bool
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function isAlphaNumeric( string $inputString)
    {
        return ctype_alnum($inputString);
    }

    /**
     * Checks if letters in given string are all lowercase.
     *
     * @param string   $inputString the input string
     * @param bool   $mbString
     *
     * @return bool
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function isLower( string $inputString, $mbString = false)
    {
        return $mbString
            ? mb_strtolower($inputString, mb_detect_encoding($inputString, 'auto')) === $inputString
            : strtolower($inputString) === $inputString;
    }

    /**
     * Check if string contains only digits
     *
     * @param string   $inputString the input string
     *
     * @return bool
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function isNumeric(string $inputString)
    {
        return ctype_digit($inputString);
    }

    /**
     * Checks if letters in given string are all uppercase.
     *
     * @param string   $inputString the input string
     * @param bool   $mbString
     *
     * @return bool
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function isUpper(string $inputString, $mbString = false)
    {
        return $mbString
            ? mb_strtoupper($inputString, mb_detect_encoding($inputString, 'auto')) === $inputString
            : strtoupper($inputString) === $inputString;
    }

    /**
     * Remove accents from latin characters
     *
     * @param string   $inputString the input string
     *
     * @return string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function latinize(string $inputString)
    {
        $table = [
            'أ' => 'a', 'ب' => 'b', 'ت' => 't', 'ث' => 'th', 'ج' => 'g', 'ح' => 'h', 'خ' => 'kh', 'د' => 'd', 'ذ' => 'th',
            'ر' => 'r', 'ز' => 'z', 'س' => 's', 'ش' => 'sh', 'ص' => 's', 'ض' => 'd', 'ط' => 't', 'ظ' => 'th', 'ع' => 'aa',
            'غ' => 'gh', 'ف' => 'f', 'ق' => 'k', 'ك' => 'k', 'ل' => 'l', 'م' => 'm', 'ن' => 'n', 'ه' => 'h', 'و' => 'o',
            'ي' => 'y', 'Ä' => 'A', 'Ö' => 'O', 'Ü' => 'U', 'ß' => 'ss', 'ä' => 'a', 'ö' => 'o', 'ü' => 'u', 'က' => 'k',
            'ခ' => 'kh', 'ဂ' => 'g', 'ဃ' => 'ga', 'င' => 'ng', 'စ' => 's', 'ဆ' => 'sa', 'ဇ' => 'z', 'စျ' => 'za',
            'ည' => 'ny', 'ဋ' => 't', 'ဌ' => 'ta', 'ဍ' => 'd', 'ဎ' => 'da', 'ဏ' => 'na', 'တ' => 't', 'ထ' => 'ta', 'ဒ' => 'd',
            'ဓ' => 'da', 'န' => 'n', 'ပ' => 'p', 'ဖ' => 'pa', 'ဗ' => 'b', 'ဘ' => 'ba', 'မ' => 'm', 'ယ' => 'y', 'ရ' => 'ya',
            'လ' => 'l', 'ဝ' => 'w', 'သ' => 'th', 'ဟ' => 'h', 'ဠ' => 'la', 'အ' => 'a', 'ြ' => 'y', 'ျ' => 'ya', 'ွ' => 'w',
            'ြွ' => 'yw', 'ျွ' => 'ywa', 'ှ' => 'h', 'ဧ' => 'e', '၏' => '-e', 'ဣ' => 'i', 'ဤ' => '-i', 'ဉ' => 'u',
            'ဦ' => '-u', 'ဩ' => 'aw', 'သြော' => 'aw', 'ဪ' => 'aw', '၍' => 'ywae', '၌' => 'hnaik', '၀' => '0', '၁' => '1',
            '၂' => '2', '၃' => '3', '၄' => '4', '၅' => '5', '၆' => '6', '၇' => '7', '၈' => '8', '၉' => '9', '္' => '',
            '့' => '', 'း' => '', 'ာ' => 'a', 'ါ' => 'a', 'ေ' => 'e', 'ဲ' => 'e', 'ိ' => 'i', 'ီ' => 'i', 'ို' => 'o',
            'ု' => 'u', 'ူ' => 'u', 'ေါင်' => 'aung', 'ော' => 'aw', 'ော်' => 'aw', 'ေါ' => 'aw', 'ေါ်' => 'aw', '်' => 'at',
            'က်' => 'et', 'ိုက်' => 'aik', 'ောက်' => 'auk', 'င်' => 'in', 'ိုင်' => 'aing', 'ောင်' => 'aung', 'စ်' => 'it',
            'ည်' => 'i', 'တ်' => 'at', 'ိတ်' => 'eik', 'ုတ်' => 'ok', 'ွတ်' => 'ut', 'ေတ်' => 'it', 'ဒ်' => 'd',
            'ိုဒ်' => 'ok', 'ုဒ်' => 'ait', 'န်' => 'an', 'ာန်' => 'an', 'ိန်' => 'ein', 'ုန်' => 'on', 'ွန်' => 'un',
            'ပ်' => 'at', 'ိပ်' => 'eik', 'ုပ်' => 'ok', 'ွပ်' => 'ut', 'န်ုပ်' => 'nub', 'မ်' => 'an', 'ိမ်' => 'ein',
            'ုမ်' => 'on', 'ွမ်' => 'un', 'ယ်' => 'e', 'ိုလ်' => 'ol', 'ဉ်' => 'in', 'ံ' => 'an', 'ိံ' => 'ein',
            'ုံ' => 'on', 'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z', 'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z', '°' => 0, '¹' => 1, '²' => 2, '³' => 3, '⁴' => 4, '⁵' => 5, '⁶' => 6, '⁷' => 7, '⁸' => 8, '⁹' => 9,
            '₀' => 0, '₁' => 1, '₂' => 2, '₃' => 3, '₄' => 4, '₅' => 5, '₆' => 6, '₇' => 7, '₈' => 8, '₉' => 9, 'æ' => 'ae',
            'ǽ' => 'ae', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Å' => 'AA', 'Ǻ' => 'A', 'Ă' => 'A', 'Ǎ' => 'A',
            'Æ' => 'AE', 'Ǽ' => 'AE', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'å' => 'aa', 'ǻ' => 'a', 'ă' => 'a',
            'ǎ' => 'a', 'ª' => 'a', '@' => 'at', 'Ĉ' => 'C', 'Ċ' => 'C', 'ĉ' => 'c', 'ċ' => 'c', '©' => 'c', 'Ð' => 'Dj',
            'Đ' => 'D', 'ð' => 'dj', 'đ' => 'd', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ĕ' => 'E', 'Ė' => 'E',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ĕ' => 'e', 'ė' => 'e', 'ƒ' => 'f', 'Ĝ' => 'G', 'Ġ' => 'G',
            'ĝ' => 'g', 'ġ' => 'g', 'Ĥ' => 'H', 'Ħ' => 'H', 'ĥ' => 'h', 'ħ' => 'h', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
            'Ï' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Ǐ' => 'I', 'Į' => 'I', 'Ĳ' => 'IJ', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
            'ï' => 'i', 'ĩ' => 'i', 'ĭ' => 'i', 'ǐ' => 'i', 'į' => 'i', 'ĳ' => 'ij', 'Ĵ' => 'J', 'ĵ' => 'j', 'Ĺ' => 'L',
            'Ľ' => 'L', 'Ŀ' => 'L', 'ĺ' => 'l', 'ľ' => 'l', 'ŀ' => 'l', 'Ñ' => 'N', 'ñ' => 'n', 'ŉ' => 'n', 'Ò' => 'O',
            'Ô' => 'O', 'Õ' => 'O', 'Ō' => 'O', 'Ŏ' => 'O', 'Ǒ' => 'O', 'Ő' => 'O', 'Ơ' => 'O', 'Ø' => 'OE', 'Ǿ' => 'O',
            'Œ' => 'OE', 'ò' => 'o', 'ô' => 'o', 'õ' => 'o', 'ō' => 'o', 'ŏ' => 'o', 'ǒ' => 'o', 'ő' => 'o', 'ơ' => 'o',
            'ø' => 'oe', 'ǿ' => 'o', 'º' => 'o', 'œ' => 'oe', 'Ŕ' => 'R', 'Ŗ' => 'R', 'ŕ' => 'r', 'ŗ' => 'r', 'Ŝ' => 'S',
            'Ș' => 'S', 'ŝ' => 's', 'ș' => 's', 'ſ' => 's', 'Ţ' => 'T', 'Ț' => 'T', 'Ŧ' => 'T', 'Þ' => 'TH', 'ţ' => 't',
            'ț' => 't', 'ŧ' => 't', 'þ' => 'th', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ũ' => 'U', 'Ŭ' => 'U', 'Ű' => 'U',
            'Ų' => 'U', 'Ư' => 'U', 'Ǔ' => 'U', 'Ǖ' => 'U', 'Ǘ' => 'U', 'Ǚ' => 'U', 'Ǜ' => 'U', 'ù' => 'u', 'ú' => 'u',
            'û' => 'u', 'ũ' => 'u', 'ŭ' => 'u', 'ű' => 'u', 'ų' => 'u', 'ư' => 'u', 'ǔ' => 'u', 'ǖ' => 'u', 'ǘ' => 'u',
            'ǚ' => 'u', 'ǜ' => 'u', 'Ŵ' => 'W', 'ŵ' => 'w', 'Ý' => 'Y', 'Ÿ' => 'Y', 'Ŷ' => 'Y', 'ý' => 'y', 'ÿ' => 'y',
            'ŷ' => 'y', 'ა' => 'a', 'ბ' => 'b', 'გ' => 'g', 'დ' => 'd', 'ე' => 'e', 'ვ' => 'v', 'ზ' => 'z', 'თ' => 't',
            'ი' => 'i', 'კ' => 'k', 'ლ' => 'l', 'მ' => 'm', 'ნ' => 'n', 'ო' => 'o', 'პ' => 'p', 'ჟ' => 'zh', 'რ' => 'r',
            'ს' => 's', 'ტ' => 't', 'უ' => 'u', 'ფ' => 'f', 'ქ' => 'k', 'ღ' => 'gh', 'ყ' => 'q', 'შ' => 'sh', 'ჩ' => 'ch',
            'ც' => 'ts', 'ძ' => 'dz', 'წ' => 'ts', 'ჭ' => 'ch', 'ხ' => 'kh', 'ჯ' => 'j', 'ჰ' => 'h', 'ΑΥ' => 'AU',
            'Αυ' => 'Au', 'ΟΥ' => 'OU', 'Ου' => 'Ou', 'ΕΥ' => 'EU', 'Ευ' => 'Eu', 'ΕΙ' => 'I', 'Ει' => 'I', 'ΟΙ' => 'I',
            'Οι' => 'I', 'ΥΙ' => 'I', 'Υι' => 'I', 'ΑΎ' => 'AU', 'Αύ' => 'Au', 'ΟΎ' => 'OU', 'Ού' => 'Ou', 'ΕΎ' => 'EU',
            'Εύ' => 'Eu', 'ΕΊ' => 'I', 'Εί' => 'I', 'ΟΊ' => 'I', 'Οί' => 'I', 'ΎΙ' => 'I', 'Ύι' => 'I', 'ΥΊ' => 'I',
            'Υί' => 'I', 'αυ' => 'au', 'ου' => 'ou', 'ευ' => 'eu', 'ει' => 'i', 'οι' => 'i', 'υι' => 'i', 'αύ' => 'au',
            'ού' => 'ou', 'εύ' => 'eu', 'εί' => 'i', 'οί' => 'i', 'ύι' => 'i', 'υί' => 'i', 'Α' => 'A', 'Β' => 'V',
            'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'I', 'Θ' => 'Th', 'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L',
            'Μ' => 'M', 'Ν' => 'N', 'Ξ' => 'X', 'Ο' => 'O', 'Π' => 'P', 'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'I',
            'Φ' => 'F', 'Χ' => 'Ch', 'Ψ' => 'Ps', 'Ω' => 'O', 'Ά' => 'A', 'Έ' => 'E', 'Ή' => 'I', 'Ί' => 'I', 'Ό' => 'O',
            'Ύ' => 'I', 'Ϊ' => 'I', 'Ϋ' => 'I', 'ϒ' => 'I', 'α' => 'a', 'β' => 'v', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e',
            'ζ' => 'z', 'η' => 'i', 'θ' => 'th', 'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => 'x',
            'ο' => 'o', 'π' => 'p', 'ρ' => 'r', 'ς' => 's', 'σ' => 's', 'τ' => 't', 'υ' => 'i', 'φ' => 'f', 'χ' => 'ch',
            'ψ' => 'ps', 'ω' => 'o', 'ά' => 'a', 'έ' => 'e', 'ή' => 'i', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'i', 'ϊ' => 'i',
            'ϋ' => 'i', 'ΰ' => 'i', 'ώ' => 'o', 'ϐ' => 'v', 'ϑ' => 'th', 'अ' => 'a', 'आ' => 'aa', 'ए' => 'e', 'ई' => 'ii',
            'ऍ' => 'ei', 'ऎ' => 'ऎ', 'ऐ' => 'ai', 'इ' => 'i', 'ओ' => 'o', 'ऑ' => 'oi', 'ऒ' => 'oii', 'ऊ' => 'uu',
            'औ' => 'ou', 'उ' => 'u', 'ब' => 'B', 'भ' => 'Bha', 'च' => 'Ca', 'छ' => 'Chha', 'ड' => 'Da', 'ढ' => 'Dha',
            'फ' => 'Fa', 'फ़' => 'Fi', 'ग' => 'Ga', 'घ' => 'Gha', 'ग़' => 'Ghi', 'ह' => 'Ha', 'ज' => 'Ja', 'झ' => 'Jha',
            'क' => 'Ka', 'ख' => 'Kha', 'ख़' => 'Khi', 'ल' => 'L', 'ळ' => 'Li', 'ऌ' => 'Li', 'ऴ' => 'Lii', 'ॡ' => 'Lii',
            'म' => 'Ma', 'न' => 'Na', 'ङ' => 'Na', 'ञ' => 'Nia', 'ण' => 'Nae', 'ऩ' => 'Ni', 'ॐ' => 'oms', 'प' => 'Pa',
            'क़' => 'Qi', 'र' => 'Ra', 'ऋ' => 'Ri', 'ॠ' => 'Ri', 'ऱ' => 'Ri', 'स' => 'Sa', 'श' => 'Sha', 'ष' => 'Shha',
            'ट' => 'Ta', 'त' => 'Ta', 'ठ' => 'Tha', 'द' => 'Tha', 'थ' => 'Tha', 'ध' => 'Thha', 'ड़' => 'ugDha',
            'ढ़' => 'ugDhha', 'व' => 'Va', 'य' => 'Ya', 'य़' => 'Yi', 'ज़' => 'Za', 'Ā' => 'A', 'Ē' => 'E', 'Ģ' => 'G',
            'Ī' => 'I', 'Ķ' => 'K', 'Ļ' => 'L', 'Ņ' => 'N', 'Ū' => 'U', 'ā' => 'a', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i',
            'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n', 'ū' => 'u', 'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'E', 'Ł' => 'L', 'Ń' => 'N',
            'Ó' => 'O', 'Ś' => 'S', 'Ź' => 'Z', 'Ż' => 'Z', 'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n',
            'ó' => 'o', 'ś' => 's', 'ź' => 'z', 'ż' => 'z', 'Ъ' => '', 'Ь' => '', 'А' => 'A', 'Б' => 'B', 'Ц' => 'C',
            'Ч' => 'Ch', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'E', 'Э' => 'E', 'Ф' => 'F', 'Г' => 'G', 'Х' => 'H', 'И' => 'I',
            'Й' => 'Y', 'Я' => 'Ya', 'Ю' => 'Yu', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P',
            'Р' => 'R', 'С' => 'S', 'Ш' => 'Sh', 'Щ' => 'Shch', 'Т' => 'T', 'У' => 'U', 'В' => 'V', 'Ы' => 'Y', 'З' => 'Z',
            'Ж' => 'Zh', 'ъ' => '', 'ь' => '', 'а' => 'a', 'б' => 'b', 'ц' => 'c', 'ч' => 'ch', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'э' => 'e', 'ф' => 'f', 'г' => 'g', 'х' => 'h', 'и' => 'i', 'й' => 'y', 'я' => 'ya', 'ю' => 'yu',
            'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'ш' => 'sh',
            'щ' => 'shch', 'т' => 't', 'у' => 'u', 'в' => 'v', 'ы' => 'y', 'з' => 'z', 'ж' => 'zh', 'Ç' => 'C', 'Ğ' => 'G',
            'İ' => 'I', 'Ş' => 'S', 'ç' => 'c', 'ğ' => 'g', 'ı' => 'i', 'ş' => 's', 'Ґ' => 'G', 'І' => 'I', 'Ї' => 'Ji',
            'Є' => 'Ye', 'ґ' => 'g', 'і' => 'i', 'ї' => 'ji', 'є' => 'ye', 'ạ' => 'a', 'ả' => 'a', 'ầ' => 'a', 'ấ' => 'a',
            'ậ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ằ' => 'a', 'ắ' => 'a', 'ặ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ẹ' => 'e',
            'ẻ' => 'e', 'ẽ' => 'e', 'ề' => 'e', 'ế' => 'e', 'ệ' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ị' => 'i', 'ỉ' => 'i',
            'ọ' => 'o', 'ỏ' => 'o', 'ồ' => 'o', 'ố' => 'o', 'ộ' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ờ' => 'o', 'ớ' => 'o',
            'ợ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ụ' => 'u', 'ủ' => 'u', 'ừ' => 'u', 'ứ' => 'u', 'ự' => 'u', 'ử' => 'u',
            'ữ' => 'u', 'ỳ' => 'y', 'ỵ' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'Ạ' => 'A', 'Ả' => 'A', 'Ầ' => 'A', 'Ấ' => 'A',
            'Ậ' => 'A', 'Ẩ' => 'A', 'Ẫ' => 'A', 'Ằ' => 'A', 'Ắ' => 'A', 'Ặ' => 'A', 'Ẳ' => 'A', 'Ẵ' => 'A', 'Ẹ' => 'E',
            'Ẻ' => 'E', 'Ẽ' => 'E', 'Ề' => 'E', 'Ế' => 'E', 'Ệ' => 'E', 'Ể' => 'E', 'Ễ' => 'E', 'Ị' => 'I', 'Ỉ' => 'I',
            'Ọ' => 'O', 'Ỏ' => 'O', 'Ồ' => 'O', 'Ố' => 'O', 'Ộ' => 'O', 'Ổ' => 'O', 'Ỗ' => 'O', 'Ờ' => 'O', 'Ớ' => 'O',
            'Ợ' => 'O', 'Ở' => 'O', 'Ỡ' => 'O', 'Ụ' => 'U', 'Ủ' => 'U', 'Ừ' => 'U', 'Ứ' => 'U', 'Ự' => 'U', 'Ử' => 'U',
        ];

        $string = strtr($inputString, $table);

        return $string;
    }


    /**
     * Return the substring denoted by n positive left-most characters
     *
     * @param string   $inputString the input string
     * @param int    $length
     *
     * @return string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function left( string $inputString, int $length)
    {
        $start = 0;

        if ($length < 0) 
        {
            $start = $length;
            $length     = -$length;
        }

        return substr( $inputString, $start, $length);
    }

    /**
     * Return the length of a string
     *
     * @param string   $inputString the input string
     * @param  bool    $mbString to use or not to use mb_strlen
     * 
     * @return int     The length of the input string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function len( string $inputString, $mbString = false)
    {
        return static::length($inputString, $mbString);
    }

    /**
     * Return the length of a string
     *
     * @param  string $inputString the input string
     * @param bool    $inputString     to use or not to use mb_strlen
     *
     * @return int         the length of the input string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function length( string $inputString, $mbString = false)
    {
        return $mbString ? mb_strlen($inputString) : strlen($inputString);
    }

    /**
     * Returns an array with the lines. Cross-platform compatible
     *
     * @param  string $inputString the input string
     *
     * @return array
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function lines( string $inputString)
    {
        return preg_split('/\r\n|\n|\r/', $inputString);
    }

    /**
     * Converts string first char to lowercase
     *
     * @param  string $inputString the input string
     *
     * @return string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function lowerCaseFirst(string $inputString)
    {
        return lcfirst($inputString);
    }

    /**
     * Pads the string in the center with specified character. char may be a string or a number, defaults is a space
     *
     * @param  string $inputString (The input string)
     * @param int    $strLength (Length of the string)
     * @param string $padCharacter (Charcter used to pad the string)
     *
     * @return string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function pad( string $inputString, int $strLength, string $padCharacter = ' ')
    {
        return str_pad($inputString, $strLength, $padCharacter, STR_PAD_BOTH);
    }

    /**
     * Left pads the string
     *
     * @param  string $inputString (The input string)
     * @param int    $strLength (Length of the string)
     * @param string $padCharacter (Charcter used to pad the string)
     *
     * @return string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function padLeft(string $inputString, int $strLength, string $padCharacter = ' ')
    {
        return str_pad($inputString, $strLength, $padCharacter, STR_PAD_LEFT);
    }


    /**
     * Right pads the string
     *
     * @param  string $inputString (The input string)
     * @param int    $strLength (Length of the string)
     * @param string $padCharacter (Charcter used to pad the string)
     *
     * @return string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function padRight(string $inputString, int $strLength, string $padCharacter = ' ')
    {
        return str_pad( $inputString, $strLength, $padCharacter, STR_PAD_RIGHT);
    }


    /**
     * Repeat the string n times
     *
     * @param  string $inputString (The input string)
     * @param int    $nTimes (No of times the string needs to be repeated)
     *
     * @return string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function repeat(string $inputString, int $nTimes)
    {
        return str_repeat($inputString, $nTimes);
    }

    /**
     * Reverses a string
     *
     * @param  string $inputString (The input string)
     *
     * @return string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function reverse(string $inputString)
    {
        return strrev($inputString);
    }

    /**
     * Return the substring denoted by n positive right-most characters
     *
     * @param  string $inputString (The input string)
     * @param int    $nTimes (No of times the string needs to be repeated)
     *
     * @return string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function right( string $inputString, int $nTimes)
    {
        $start = -$nTimes;
        if ($nTimes < 0) {
            $start = 0;
            $nTimes     = -$nTimes;
        }

        return substr($inputString, $start, $nTimes);
    }


    /**
     * Converts the text into a valid url slug. Removes accents from Latin characters
     *
     * @param  string $inputString (The input string)
     *
     * @return string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function slugify(string $inputString)
    {
        $inputString = static::latinize($inputString);
        $inputString = preg_replace('~[^\\pL\d]+~u', '-', $inputString);
        $inputString = trim($inputString, '-');
        $inputString = strtolower($inputString);

        return preg_replace('~[^-\w]+~', '', $inputString);
    }


    /**
     * Check if string starts with substring
     *
     * @param  string $inputString (The input string)
     * @param string $subString (The String Character Starting With)
     *
     * @return bool
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function startsWith(string $inputString,string $subString)
    {
        return mb_strpos($inputString, $subString) === 0;
    }

    /**
     * Returns a new string with all occurrences of [string1],[string2],... removed.
     *
     * @param  string $inputString (The input string)
     * @param string $inputString1
     *
     * @return string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function strip($inputString, $inputString1)
    {
        $totalStringArgs = func_get_args();

        return str_replace(array_slice($totalStringArgs, 1), '', $inputString);
    }

    /**
     * Strip all of the punctuation
     *
     * @param  string $inputString (The input string)
     *
     * @return string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function stripPunctuation(string $inputString)
    {
        return preg_replace('/[^\w\s]|_/', '', $inputString);
    }

    /**
     * Makes a case swapped version of the string
     * @param  string $inputString (The input string)
     * @param  boolean $mbString     to use or not to use multibyte character feature
     * @return string          case swapped version of the input string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function swapCase( string $inputString, $mbString = false)
    {
        return array_reduce(str_split($inputString), function($carry, $item) use ($mbString) {
            return $carry .= static::isLower($item, $mbString) ? static::toUpper($item, $mbString) : static::toLower($item, $mbString);
        }, '');
    }

    /**
     * Creates a title version of the string. Capitalizes all the words and replaces some characters in the string to
     * create a nicer looking title. string_titleize is meant for creating pretty output
     *
     * @param  string $inputString (The input string)
     * @param array  $ignorableWords (The Words Needs to be ignored)
     *
     * @return string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function titleize( string $inputString, array $ignorableWords = [])
    {
        $inputString = preg_replace('/(?<!^)([A-Z])/', ' $1', $inputString);
        $inputString = preg_replace('/[^a-z0-9:]+/i', ' ', $inputString);
        $inputString = trim($inputString);

        return preg_replace_callback(
            '/([\S]+)/u',
            function ($match) use ($ignorableWords) {
                if (in_array(strtolower($match[0]), $ignorableWords)) {
                    return $match[0];
                } else {
                    return ucfirst(strtolower($match[0]));
                }
            },
            $inputString
        );
    }

    /**
     * Makes a string lowercase
     * @param  string $inputString (The input string)
     * @param  boolean $mbString    to use or not to use multibyte character feature
     * @return string         lowercased string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function toLower( string $inputString, $mbString = false)
    {
        return $mbString ? mb_strtolower($inputString, mb_detect_encoding($inputString, 'auto')) : strtolower($inputString);
    }

    /**
     * Join an array into a human readable sentence
     *
     * @param array  $arrayOfString (Array with the string that forms the sentence)
     * @param string $delimiterCharacter (Delimitter Character used to Split the each Words)
     * @param string $lastDelimiter (Last delimiter of the sentence)
     *
     * @return string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function toSentence(array $arrayOfString, string $delimiterCharacter = ', ', string $lastDelimiter = ' and ')
    {
        $lastWord = array_pop($arrayOfString);

        return implode($delimiterCharacter, $arrayOfString) . $lastDelimiter . $lastWord;
    }

    /**
     * The same as string_to_sentence, but adjusts delimeters to use Serial comma)
     *
     * @param array  $arrayOfString (Array with the string that forms the sentence)
     * @param string $delimiterCharacter (Delimitter Character used to Split the each Words)
     * @param string $lastDelimiter (Last delimiter of the sentence)
     *
     * @return string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function toSentenceSerial(array $arrayOfString, string $delimiterCharacter = ', ', string $lastDelimiter = ' and ')
    {
        $lastWord = array_pop($arrayOfString);

        $lastDel = '';
        if (count($arrayOfString) > 1) {
            $lastDel = trim($delimiterCharacter, ' ');
        }

        return implode($delimiterCharacter, $arrayOfString) . $lastDel . $lastDelimiter . $lastWord;
    }


    /**
     * Makes a string uppercase
     * @param  string $inputString (The input string)
     * @param  boolean $mbString    to use or not to use multibyte character feature
     * @return string         uppercased string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function toUpper(string $inputString, $mbString = false)
    {
        return $mbString ? mb_strtoupper($inputString, mb_detect_encoding($inputString, 'auto')) : strtoupper($inputString);
    }


    /**
     * Converts hyphens and camel casing to underscores
     *
     * @param  string $inputString (The input string)
     *
     * @return string
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function underscore(string $inputString)
    {
        return strtolower(preg_replace('/(?<!^)([A-Z])/', '_$1', str_replace('-', '_', $inputString)));
    }

    /**
     * Converts string first char to uppercase
     *
     * @param  string $inputString (The input string)
     *
     * @return string         first uppercased string
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function upperCaseFirst($inputString)
    {
        return ucfirst($inputString);
    }
    /**
    * @function     highlightStringInParagraph
    * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
    * @param        string  $paragraphText
    * @param        string or array  $highlightWords
    * @param        string  $highlightColor(optional)
    * @usage        Highlights the given string in paragraph
    * @return string         highlighits the string with color
    * @version      1.5
    **/
    /*
    |--------------------------------------------------------------------------
    | Highlight the string in paragraph
    |--------------------------------------------------------------------------
    |
    |Usage:
    |Option 1: Highlighting Single word in paragraph
    |echo highlightStringInParagraph("Lorem Ipsum is simply dummy text of the printing and typesetting industry",lorem,'#fa8a1a');
    |
    |Option 2: Highlighting Multiple word in paragraph
    |echo highlightStringInParagraph("Lorem Ipsum is simply dummy text of the printing and typesetting industry",['lorem','ipsum'],'#fa8a1a');
    |
    */
    public static function highlightStringInParagraph(string $paragraphText='', $highlightWords='',$highlightColor='red')
    {
        if (is_array($highlightWords)) 
        {
            foreach($highlightWords as $highlightWord)
            {
                $paragraphText = preg_replace(
                    "|($highlightWord)|Ui" ,
                    "<span style=\"color:".$highlightColor. ";\"><b>$1</b></span>" ,
                    $paragraphText 
                );
            }
        }
        elseif (!is_array($highlightWords)) 
        {
           
            $paragraphText = preg_replace(
                    "|($highlightWords)|Ui" ,
                    "<span style=\"color:".$highlightColor. ";\"><b>$1</b></span>" ,
                    $paragraphText 
                );
        }
        return $paragraphText;
    }
    /**
     * Converts slug generated by Str::slug to normal text
     *
     * @param  string $inputString (The input string)
     *
     * @return string         return the actual string by removing the hyphens
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     */
    public static function strUnslug(string $inputString)
    {
        return ucwords(str_replace('-', ' ', $inputString));
    }
    /**
     * Replace the last Occurence of the string With the spefic string
     *
     * @param  string $findFor (The search string)
     * @param  string $replaceWith (The string to be replaced)
     * @param  string $actualString (The Actual String)
     * @param  string $isCaseSensitive (Is String need to checked with case sensitive)
     * 
     * @return string     return the string with replacing the last occurence
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.4
     * @since      1.0.5
     * @alaiased from stringReplaceBase
     */
    public static function stringReplaceLast(string $findFor , string $replaceWith , string $actualString, bool $isCaseSensitive = true):string
    {
        return static::stringReplaceBase($findFor,$replaceWith,$actualString, $isCaseSensitive == true ? 'strrpos': 'strripos');
    }

    /**
     * Replace the first Occurence of the string With the spefic string
     *
     * @param  string $findFor (The search string)
     * @param  string $replaceWith (The string to be replaced)
     * @param  string $actualString (The Actual String)
     * @param  string $isCaseSensitive (Is String need to checked with case sensitive)
     * 
     * @return string     return the string with replacing the first occurence
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.4
     * @since      1.0.5
     * @alaiased from stringReplaceBase
     */
    
    public static function stringReplaceFirst(string $findFor , string $replaceWith , string $actualString,bool $isCaseSensitive = true):string
    {
        return static::stringReplaceBase($findFor,$replaceWith,$actualString, $isCaseSensitive == true ? 'strpos': 'stripos');
    }
    /**
     * Replace the First Occurence or Last Occurence of the string With the spefic string
     *
     * @param  string $findFor (The search string)
     * @param  string $replaceWith (The string to be replaced)
     * @param  string $actualString (The Actual String)
     * @param  string $methodName (The Method to get the  String Position) 
     * @return string     return the string with replacing the First Occurence or Last Occurence
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.3
     * @since      1.0.5
     * @see https://stackoverflow.com/questions/1252693/using-str-replace-so-that-it-only-acts-on-the-first-match/1252710#1252710
     * @updated      1.0.6
     */
    
    public static function stringReplaceBase(string $findFor , string $replaceWith , string $actualString ,string $methodName):string
    {
        $stringPositionOccurrence = $methodName($actualString, $findFor);
        
        if ($stringPositionOccurrence !== false) 
        {
            return substr_replace($actualString, $replaceWith, $stringPositionOccurrence, strlen($findFor));
        }
        return $actualString;
    }

    /**
     * Reverses the Sentence without reversing the words
     *
     * @param  string $sentence (The Passes Sentence)
     * 
     * @return string    
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     * @since      1.0.6
     * @usage   reverseSentenceWithoutReversingWords(Laravel is Open Source FrameWork.It Was Developed By Taylor Otwell.);
     * @result  Otwell. Taylor By Developed Was FrameWork.It Source Open is Laravel
     */
    public static function reverseSentenceWithoutReversingWords(string $sentence):string
    {
        return implode(" ", array_reverse(explode(" ", $sentence)));
    }

    /**
     * Reverses the Words in Sentence without reversing the Sentence
     *
     * @param  string $sentence (The Passes Sentence)
     * 
     * @return string   
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     * @since      1.0.6
     * @usage   reverseWordsWithoutReversingSentence(Laravel is Open Source FrameWork.It Was Developed By Taylor Otwell.);
     * @result  levaraL si nepO ecruoS tI.kroWemarF saW depoleveD yB rolyaT .llewtO
     */
    public static function reverseWordsWithoutReversingSentence(string $sentence):string
    {
        return implode(" ", array_map('strrev',explode(" ", $sentence)));
    }
    /**
     * Reverses the Words in Sentence without reversing the Sentence
     *
     * @param  string $sentence (The Passes Sentence)
     * 
     * @return string   
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     * @since      1.0.6
     * @usage   reverseSenetenceWithReversingWords(Laravel is Open Source FrameWork.It Was Developed By Taylor Otwell.);
     * @result  .llewtO rolyaT yB depoleveD saW tI.kroWemarF ecruoS nepO si levaraL
     */
    public static function reverseSenetenceWithReversingWords(string $sentence):string
    {
        return implode(" ", array_reverse(array_map('strrev',explode(" ", $sentence))));
    }
    /**
     * Replaces the string with the other string with limit count and starting position
     *
     * @param  string $findFor (The Prase need to searched within the string)
     * @param  string $replaceWith (The Prase need to replaced with)
     * @param  string $actualString (The Actual String)
     * @param  int $replaceLimit (The Number of times need the replacements to be done)
     * @param  int $startingStringPosition (The String Position Needs to starts from default will be zero)
     * 
     * 
     * @return string   
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     * @since      1.0.7
     * 
     */
    public static function stringReplaceLimit(string $findFor , string $replaceWith , string $actualString, int $replaceLimit = 0 ,int  $startingStringPosition = 0) 
    {
        if ($replaceLimit <= 0) 
        {
            return $actualString;
        }
        else 
        {
            $startingStringPosition > strlen($actualString) ? $startingStringPosition = strlen($actualString) : '';

            $pos = strpos($actualString,$findFor ,$startingStringPosition);

            if ($pos !== false) 
            {
                $newstring = substr_replace($actualString, $replaceWith , $pos, strlen($findFor));

                return static::stringReplaceLimit($findFor, $replaceWith ,$newstring, $replaceLimit-1, $pos+strlen($replaceWith));
            }
            else 
            {
                return $actualString;
            }
        }
    }
    /**
     * Replaces the string with the other string with limit count and starting position from the front side of the string
     *
     * @param  string $findFor (The Prase need to searched within the string)
     * @param  string $replaceWith (The Prase need to replaced with)
     * @param  string $actualString (The Actual String)
     * @param  int $replaceLimit (The Number of times need the replacements to be done)
     * @param  int $startingStringPosition (The String Position Needs to starts from default will be zero)
     * 
     * 
     * @return string   
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     * @since      1.0.7
     * @alaiased from stringReplaceLimit
     * 
     */
    public static function stringReplaceLimitFront(string $findFor , string $replaceWith ,string $actualString, int $replaceLimit = 0, int $startingStringPosition = 0)
    {
        return static::stringReplaceLimit($findFor,$replaceWith,$actualString,$replaceLimit,$startingStringPosition);
    }
    /**
     * Replaces the string with the other string with limit count and starting position from the back side of the string
     *
     * @param  string $findFor (The Prase need to searched within the string)
     * @param  string $replaceWith (The Prase need to replaced with)
     * @param  string $actualString (The Actual String)
     * @param  int $replaceLimit (The Number of times need the replacements to be done)
     * @param  int $startingStringPosition (The String Position Needs to starts from default will be zero)
     * 
     * 
     * @return string   
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.2
     * @since      1.0.7
     * @alaiased from stringReplaceLimit
     * 
     */
    public static function stringReplaceLimitBack(string $findFor , string $replaceWith , string $actualString,int $replaceLimit = 0 , int $startingStringPosition = 0)
    {
        $reversedString = static::reverseSentenceWithoutReversingWords($actualString);

        if ($reversedString == $actualString) 
        {
            $reversedString = strrev($actualString);
            return strrev(static::stringReplaceLimit($findFor,$replaceWith,$reversedString,$replaceLimit,$startingStringPosition));
        }
        else 
        {
            return static::reverseSentenceWithoutReversingWords(static::stringReplaceLimit($findFor,$replaceWith,$reversedString,$replaceLimit,$startingStringPosition));
        }
    }
    /**
     * Generated the random String by following Crteria ['ALPNUM','ALPHA','HEXDEC','NUM','NOZERO','DISTINCT']
     *
     * @param  string $generatorType (Type of random string needs to generated)
     * @param  int $length (lrngth of the generated random) 
     * 
     * @return string   
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.8
     * @credit   github gist
     * 
     */
    public static function generateRandomBase(string $generatorType = 'ALPNUM',int $length = 8):string
    {
        switch (strtoupper($generatorType)) {
            case 'ALPNUM':
                $randomText = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'ALPHA':
                $randomText = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'HEXDEC':
                $randomText = '0123456789abcdef';
                break;
            case 'NUM':
                $randomText = '0123456789';
                break;
            case 'NOZERO':
                $randomText = '123456789';
                break;
            case 'DISTINCT':
                $randomText = md5(uniqid() . time() . mt_rand());
                break;
            case 'HUMANREADABLE':
                // https://gist.github.com/sepehr/3371339
                $finalRandomString     = '';
                $aplhaVowels     = ["a","e","i","o","u"];
                $aplhaConsonants = [
                                    'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 
                                    'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'
                                ];  
                srand((double) microtime() * 1000000);
                $maxLength = $length/2;
                
                for ($ctrlVarb = 1; $ctrlVarb <= $maxLength; $ctrlVarb++)
                {
                    $finalRandomString .= $aplhaConsonants[rand(0,19)];
                    $finalRandomString .= $aplhaVowels[rand(0,4)];
                }
                return $finalRandomString;

                break;
            default:
                $randomText = (string)$generatorType;
                break;
        }


        $cryptoRandomSecure = function ($minimumLength = '', $maximumLength = '') {

            $numberRange = $maximumLength - $minimumLength;

            if ($numberRange < 0) {
                return $minimumLength; // not so random...
            }

            $numberRangeLog   = log($numberRange, 2);
            $bytesLength  = (int)($numberRangeLog / 8) + 1; // length in bytes
            $bitsLength   = (int)$numberRangeLog + 1; // length in bits
            $filterRandom = (int)(1 << $bitsLength) - 1; // set all lower bits to 1
            do {
                $randomGen = hexdec(bin2hex(openssl_random_pseudo_bytes($bytesLength)));
                $randomGen = $randomGen & $filterRandom; // discard irrelevant bits
            } while ($randomGen >= $numberRange);
            return $minimumLength + $randomGen;
        };

        $generatedRandom = "";

        $maximumLength   = strlen($randomText);

        for ($i = 0; $i < $length; $i++) {
            $generatedRandom .= $randomText[$cryptoRandomSecure(0, $maximumLength)];
        }

        return $generatedRandom;
    }
    /**
     * Generated the random Aplhanumeric String
     *
     * @param  string $generatorType (Type of random string needs to generated)
     * @param  int $length (lrngth of the generated random) 
     * 
     * @return string   
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.8
     * @alaiased from generateRandomBase
     * 
     */    
    public function generateAlphaNumericRandom(int $length = 10):string
    {
        return static::generateRandomBase('ALPNUM',$length);
    }
    /**
     * Generated the random Alpha String
     *
     * @param  string $generatorType (Type of random string needs to generated)
     * @param  int $length (lrngth of the generated random) 
     * 
     * @return string   
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.8
     * @alaiased from generateRandomBase
     * 
     */    
    public function generateAlphaRandom(int $length = 10):string
    {
        return static::generateRandomBase('ALPHA',$length);
    }

    /**
     * Generated the random HEXDEC String
     *
     * @param  string $generatorType (Type of random string needs to generated)
     * @param  int $length (lrngth of the generated random) 
     * 
     * @return string   
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.8
     * @alaiased from generateRandomBase
     * 
     */    
    public function generateHexDecRandom(int $length = 10):string
    {
        return static::generateRandomBase('HEXDEC',$length);
    }
    /**
     * Generated the random DISTINCT String
     *
     * @param  string $generatorType (Type of random string needs to generated)
     * @param  int $length (lrngth of the generated random) 
     * 
     * @return string   
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.8
     * @alaiased from generateRandomBase
     * 
     */    
    public function generateDistinctRandom(int $length = 10):string
    {
        return static::generateRandomBase('DISTINCT',$length);
    }
    /**
     * Generated the random DISTINCT String
     *
     * @param  string $generatorType (Type of random string needs to generated)
     * @param  int $length (lrngth of the generated random) 
     * 
     * @return string   
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.8
     * @alaiased from generateRandomBase
     * 
     */    
    public function generateCustomRandom(string $yourString,int $length = 10):string
    {
        return static::generateRandomBase($yourString,$length);
    }
    /**
     * Generated the random DISTINCT String
     *
     * @param  string $generatorType (Type of random string needs to generated)
     * @param  int $length (lrngth of the generated random) 
     * 
     * @return string   
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.8
     * @alaiased from generateRandomBase
     * 
     */    
    public function generateHumanReadableRandom(int $length = 10):string
    {
        return static::generateRandomBase('HUMANREADABLE',$length);
    }
    // HUMANREADABLE
      
}
