<?php

namespace App\Services\Helpers;

use Illuminate\Support\Str as SupportStr;

class Str
{
    /**
     * Separate camel cased string with separator
     * @param string $separator
     * @param string $str
     * @return string
     */
    public static function camelToLowerCaseAndSeparateWith($separator, $str)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', "$separator$0", $str));
    }

    /**
     * Separate camel cased string with separator
     * @param string $separator
     * @param string $str
     * @return string
     */
    public static function camelCaseSeparateWith($separator, $str)
    {
        return preg_replace('/(?<!^)[A-Z]/', "$separator$0", $str);
    }

    /**
     * Transform singular work to plural
     * @param string $word
     * @return string
     */
    public static function singularToPlural($words)
    {
        $words_arr = explode(' ', $words);

        if (count($words_arr) > 1) {
            $last_word = array_pop($words_arr);
            $words_arr[] = static::singularToPlural($last_word);
            $word = implode(' ', $words_arr);
        } else {
            $word = $words;

            if (SupportStr::endsWith($word, 'y')) {
                $word = SupportStr::replaceLast('y', 'ies', $word);
            } else {
                $word .= 's';
            }
        }

        return $word;
    }
}