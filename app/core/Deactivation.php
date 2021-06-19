<?php
/**
 * @package Newsletter_Geek
 */
namespace App\core;

/**
 * Class Deactivation
 * @package App\core
 */
class Deactivation
{

    public static function handle()
    {
        flush_rewrite_rules();
    }
}