<?php

namespace App\Helpers;

use Carbon\Carbon;

class GreetingHelper
{
    /**
     * Get greeting message based on current time
     *
     * @return string
     */
    public static function getGreeting(): string
    {
        $hour = Carbon::now()->hour;

        if ($hour < 12) {
            return 'Morning';
        } elseif ($hour < 17) {
            return 'Afternoon';
        } else {
            return 'Evening';
        }
    }

    /**
     * Get greeting emoji based on current time
     *
     * @return string
     */
    public static function getGreetingEmoji(): string
    {
        $hour = Carbon::now()->hour;

        if ($hour < 12) {
            return '🌅'; // Morning
        } elseif ($hour < 17) {
            return '☀️'; // Afternoon
        } else {
            return '🌙'; // Evening
        }
    }

    /**
     * Get full greeting message with emoji
     *
     * @return string
     */
    public static function getFullGreeting(): string
    {
        return 'Good ' . self::getGreeting() . ' ' . self::getGreetingEmoji();
    }

    /**
     * Get greeting with optional user name
     *
     * @param string|null $name
     * @return string
     */
    public static function greetUser(?string $name = null): string
    {
        $greeting = self::getFullGreeting();
        
        if ($name) {
            return $greeting . ', ' . $name . '!';
        }

        return $greeting;
    }
}
