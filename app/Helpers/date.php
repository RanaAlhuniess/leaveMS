<?php

use Carbon\Carbon;

if (!function_exists('formatDate')) {
    /**
     * @throws Exception
     */
    function formatDate($dateStr): string
    {
        $dateTimeObj = Carbon::createFromFormat('Y-m-d H:i:s', $dateStr);
        // Check if the time is valid
        if ($dateTimeObj === false) {
            throw new Exception("Invalid time string: $dateStr");
        }

        return $dateTimeObj->format('Y-m-d H:i:s');
    }
}

if (!function_exists('now')) {
    function now(): string
    {
        return Carbon::now()->format('Y-m-d H:i:s');
    }
}
