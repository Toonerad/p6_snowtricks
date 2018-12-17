<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 17/12/2018
 * Time: 13:55
 */

namespace App\Service;

/**
 * Class Slugify
 * @package App\Service
 */
class Slugify
{

    /**
     * @param $text
     * @return null|string|string[]
     */
    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

}