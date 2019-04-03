<?php

namespace Manojkiran\LaravelHelpers\Helpers;

use RecursiveIteratorIterator;
use RecursiveArrayIterator;
use Exception;
class ArrayHelper
{
    /**
     * Exclude the array values from the array
     *
     * @param string   $originalArray the input array
     * @param array[]   $arrayExcludeable array of values that needs to excluded
     * @param bool $preserveKeys need actual keys of the array
     *
     * @return array
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.4
    */
    public static function arrayExcludeValues(array $originalArray ,$arrayExcludeable ,bool $preserveKeys = true)
    {
        !is_array($arrayExcludeable) ? $arrayExcludeable = explode(' ',$arrayExcludeable) :$arrayExcludeable = $arrayExcludeable;
        return  $preserveKeys == false ? array_values(array_diff($originalArray, $arrayExcludeable)) : array_diff($originalArray, $arrayExcludeable);
    }
    
    /**
     * Exclude the array keys from the array
     *
     * @param string   $originalArray the input array
     * @param array[]   $arrayExcludeable array of keys that needs to excluded
     * @param bool $preserveKeys need actual keys of the array
     *
     * @return array
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.4
    */
    public static function arrayExcludeKeys(array $originalArray,$arrayExcludeable,bool $preserveKeys = true)
    {
        !is_array($arrayExcludeable) ? $arrayExcludeable = explode(' ',$arrayExcludeable) :$arrayExcludeable = $arrayExcludeable;

        foreach($arrayExcludeable as $excludeKey)
        {
            unset($originalArray[$excludeKey]);
        }

        return  $preserveKeys == false ? array_values($originalArray) : $originalArray; 
    }

    /**
     * Include the array values from the array
     *
     * @param string   $originalArray the input array
     * @param array[]   $arrayIncludeable array of values that needs to included
     * @param bool $preserveKeys need actual keys of the array
     *
     * @return array
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.4
    */

    public static function arrayOnlyValues(array $originalArray ,$arrayIncludeable ,bool $preserveKeys = true)
    {
        return  $preserveKeys == false ? array_values(array_diff($originalArray, static::arrayExcludeValues($originalArray,$arrayIncludeable))) : array_diff($originalArray, static::arrayExcludeValues($originalArray,$arrayIncludeable));
    }

    /**
     * Include the array keys from the array
     *
     * @param string   $originalArray the input array
     * @param array[]   $arrayIncludeable array of keys that needs to included
     * @param bool $preserveKeys need actual keys of the array
     *
     * @return array
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.4
    */

    public static function arrayOnlyKeys(array $originalArray ,$arrayIncludeable ,bool $preserveKeys = true)
    {
        return  $preserveKeys == false ? array_values(array_diff($originalArray, static::arrayExcludeKeys($originalArray,$arrayIncludeable))) : array_diff($originalArray, static::arrayExcludeKeys($originalArray,$arrayIncludeable));
    }

    /**
     * Sort an array by keys based on another array
     *
     * @param array   $originalArray the input array
     * @param array   $orderArray the  array order which need to mapped as order
     * 
     * @return array
     * 
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.4
     * @see https://github.com/JBZoo/Utils
     */
    public static function sortByArray(array $originalArray, array $orderArray)
    {
        return array_merge(array_flip($orderArray), $originalArray);
    }

    /**
     * Add the array values
     *
     * @param array   $numbersArray the input array
     * 
     * @return int
     * 
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.4
     */
    public static function arrayAddition(array $numbersArray)
    {
        if (count($numbersArray) >= 2 ) 
        {
            $result = 0;
            foreach ($numbersArray as $numbersArray)
            {
                $result += $numbersArray;
            }

            return $result;
        }else {
            return current($numbersArray);
        }
    }
     /**
     * Subtracts the array values
     *
     * @param array   $numbersArray the input array
     * 
     * @return int
     * 
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.4
     */
    public static function  arraySubtraction(array $numbersArray)
    {    
        if (count($numbersArray) >= 2 ) 
        {
            $result = reset($numbersArray);

            foreach ($numbersArray as $numbersArray)
            {
                if ($numbersArray != $result) 
                {
                    $result -= $numbersArray;
                }
            }
            return $result;  
        }else {
            return current($numbersArray);
        }
    }
     /**
     * Multiplies the array values
     *
     * @param array   $numbersArray the input array
     * 
     * @return int
     * 
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.4
     */
    public static function arrayMultiplication(array $numbersArray)
    {
        if (count($numbersArray) >= 2 ) 
        {
            $result = 1;
            
        foreach ($numbersArray as $numbersArray)
            {
                $result *= $numbersArray;
            }
            return $result;
        }else {
            return current($numbersArray);
        }
    }

    /**
     * Flattern tha arry with the keys with seperator
     *
     * @param array   $originlArray the input array
     * @param string   $seperator Seperator for each key
     * 
     * @return array
     * 
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.4
     * @see  https://stackoverflow.com/a/40217420/8487424
     */
    public static function arrayFlattenKeys(array $originlArray,string $seperator='.')
    {
        $recursiveIteratorObj = new RecursiveIteratorIterator(new RecursiveArrayIterator($originlArray),RecursiveIteratorIterator::SELF_FIRST);

        $arrayPaths = []; $finalResult = [];

        foreach ($recursiveIteratorObj as $leafKey => $leafValue) 
        {
            $arrayPaths[$recursiveIteratorObj->getDepth()] = $leafKey;

            if (!is_array($leafValue)) 
            {
                $finalResult[ implode($seperator, array_slice($arrayPaths, 0, $recursiveIteratorObj->getDepth() + 1)) ] = $leafValue;
            }
        }

        return $finalResult;
    }
    
    /**
     * Flattern tha arry with the keys with seperator
     *
     * @param array   $originlArray the input array
     * @param string   $seperator Seperator for each key
     * 
     * @return array
     * 
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.4
     * @see https://stackoverflow.com/a/10424516/8487424
     */
    public static function arrayFlattenKeysAlt(array $originlArray,string $seperator='.')
    {
        $recursiveIteratorObj = new RecursiveIteratorIterator(new RecursiveArrayIterator($originlArray));

        $finalResult = [];

        foreach ($recursiveIteratorObj as $leafKey => $leafValue) 
        {
            $totalKeysArr = [];
            
            foreach (range(0, $recursiveIteratorObj->getDepth()) as $depthKey => $depthValue) 
            {
                $totalKeysArr[] = $recursiveIteratorObj->getSubIterator($depthValue)->key();
            }
            
            $finalResult[ join($seperator, $totalKeysArr) ] = $leafValue;
        }

        return $finalResult;
    }

    /**
     * Flattern tha array to single dimension
     *
     * @param array   $originlArray the input array
     * @param string   $flattenType Flatten method AWR (array_walk_recursive) and RI (RecursiveIteratorIterator)
     * 
     * @return array
     * 
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.4
     * @see https://stackoverflow.com/a/10424516/8487424
     */

    public static function arrayFlattenSingle(array $multiDimensionalArray ,$flattenType = 'AWR')
    {
        $flattenType = strtoupper($flattenType);

        if ($flattenType == 'RI') 
        {
            return static::arrayFlattenSingleRI($multiDimensionalArray);
        }

        elseif ($flattenType == 'AWR') 
        {    
            return static::arrayFlattenSingleAWR($multiDimensionalArray);
        }
        else
        {
            throw new Exception("The Array Cannot BE Flatten with $flattenType CHOOSE Neither RI OR AWR", E_USER_ERROR);
        }                
    }

    /**
     * Flattern tha array to single dimension with array_walk_recursive method
     *
     * @param array   $originlArray the input array
     * @param string   $flattenType Flatten method AWR (array_walk_recursive) and RI (RecursiveIteratorIterator)
     * 
     * @return array
     * 
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.4
     * @see https://stackoverflow.com/a/10424516/8487424
     */
    public static  function arrayFlattenSingleAWR(array $multiDimensionalArray)
    {
        $singleDimensionalArray = array();
        array_walk_recursive($multiDimensionalArray, function($array) use (&$singleDimensionalArray) { $singleDimensionalArray[] = $array; });
        return $singleDimensionalArray;
    }
    /**
     * Flattern tha array to single dimension with RecursiveArrayIterator and RecursiveIteratorIterator class
     *
     * @param array   $originlArray the input array
     * @param string   $flattenType Flatten method AWR (array_walk_recursive) and RI (RecursiveIteratorIterator)
     * 
     * @return array
     * 
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.0
     * @since      1.0.4
     * @see https://stackoverflow.com/a/10424516/8487424
     */
    public static function arrayFlattenSingleRI(array $multiDimensionalArray)
    {
        $recursiveIteratorArray = new RecursiveIteratorIterator(new RecursiveArrayIterator($multiDimensionalArray));
        foreach($recursiveIteratorArray as $recursiveIteratorArrayKey => $recursiveIteratorArrayValue) 
        {
            $singleDimensionalArray[] = $recursiveIteratorArrayValue;
        }
        return $singleDimensionalArray;
    }
    /**
     * Check if the array is multi dimensional
     *
     * @param  string $array (The array to be passes )
     * 
     * @return bool    
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.1
     * @since      1.0.5
     * @see https://pageconfig.com/post/checking-multidimensional-arrays-in-php
     */
    public static function isArrayMulti( array $array ) 
    {
        rsort( $array );
        return isset( $array[0] ) && is_array( $array[0] );
    }
    /**
     * Check if the array is single dimensional 
     *
     * @param  string $array (The array to be passes )
     * 
     * @return bool    
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @version      1.1
     * @since      1.0.5
     * @see https://pageconfig.com/post/checking-multidimensional-arrays-in-php
     */
    public static function isArraySingle(array $array )
    {
        return !static::isArrayMulti($array);
    }
}