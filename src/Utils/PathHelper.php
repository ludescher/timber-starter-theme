<?php

namespace src\Utils;

class PathHelper {
    public static function replaceSeparator(string $path) {
        return preg_replace('/(\\\\+|\/+)/', DIRECTORY_SEPARATOR, $path);
    }

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

    public static function replaceParameters(string $path) {
        $subst = '(?P<$1>\\d+)';
        return preg_replace('/{(-?[a-zA-Z]+)}/', $subst, $path);
    }

    public static function replaceWithParameters(string $path, array $args) {
        return preg_replace_callback('/{(-?[a-zA-Z]+)}/',function($match) use ($args) {return $args[$match[1]];}, $path);
    }
}
