<?php

if (!function_exists('shorten_str')) {
    function shorten_str(mixed $value, int $length = 20): string
    {
        $value = (string) $value;

        if (strlen($value) > $length) {
            $str = substr($value, 0, $length);
            return rtrim($str) . '...';
        }

        return $value;
    }
}