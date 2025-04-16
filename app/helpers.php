<?php

if (!function_exists('initials')) {
    function initials($name)
    {
        $words = explode(' ', $name);
        $initials = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }

        return $initials;
    }
}
