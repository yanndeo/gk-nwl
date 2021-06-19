<?php
/**
 * @package Newsletter_Geek
 */
namespace App\core;

use App\shortcode\HandleForm;

/**
 * Class Activation
 * @package App\core
 */
class Activation {

    /**
     * Flush rewrite rules and
     * create file csv with head if is not exist
     */
    public static function handle()
    {
        flush_rewrite_rules();
        HandleForm::createFileWithHeaders();
    }

}