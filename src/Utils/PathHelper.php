<?php

namespace src\Utils;

class PathHelper {
    public static function replaceSeparator(string $path) {
        return preg_replace('/(\\\\+|\/+)/', DIRECTORY_SEPARATOR, $path);
    }
}
