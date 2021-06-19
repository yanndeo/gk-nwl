<?php
/**
 * @package Newsletter_Geek
 */
namespace App\core;
/**
 * Interface ServiceInterface
 * @package App\core
 */
interface ServiceInterface
{
    /**
     * Load all methods initialized on boot plugin
     */
    public function register(): void;
}