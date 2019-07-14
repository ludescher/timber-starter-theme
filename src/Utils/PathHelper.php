<?php

namespace src\Utils;

class PathHelper {

    /**
     * replaces a slash, double slash, back slash or double back slash to a system specific separator
     * 
     * @param String $path
     * @return String 
     */
    public static function replaceSeparator(string $path):string {
        return preg_replace('/(\\\\+|\/+)/', DIRECTORY_SEPARATOR, $path);
    }

    /**
     * get all Url parameters like "/posts/{id}" => id
     * and add them to a array with custom content
     * 
     * @param String $path
     * @param Int $index
     * @param String|Array $value
     * @return String|Array
     */
    public static function getPathparameters(string $path, int $index = 0, $value = null) {
        $result = [];
        preg_match_all('/{(-?[a-z]+)}/', $path, $matches, PREG_SET_ORDER, 0);
        foreach ($matches as $match) {
            if (is_null($value)) {
                $result[] = $match[$index];
            } else {
                $result[$match[$index]] = $value;
            }
        }
        return $result;
    }

    /**
     * it replaces the nice Url parameters with wordpress specific parameters
     * "/posts/{id}" to "/posts/(?P<id>\d+)"
     * 
     * @param String $path
     * @return String
     */
    public static function replaceParameters(string $path):string {
        $subst = '(?P<$1>\\d+)';
        return preg_replace('/{(-?[a-zA-Z]+)}/', $subst, $path);
    }

    /**
     * replaces the annotation url with real data
     * "/posts/{id}" to "/posts/2"
     * 
     * @param String $path
     * @param Array $args
     * @return String
     */
    public static function replaceWithParameters(string $path, array $args):string {
        return preg_replace_callback('/{(-?[a-zA-Z]+)}/',function($match) use ($args) {return $args[$match[1]];}, $path);
    }
}
