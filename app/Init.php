<?php
/**
 * @package Newsletter_Geek
 */
namespace App;

use App\core\Enqueue;
use App\core\ServiceInterface;
use App\shortcode\Admin;
use App\shortcode\Index;

/**
 * Class Init
 * @package App
 */
final class Init {

    /**
     * Store all the classes inside an array
     *
     * @return array Full list of classes[]
     */
    public static function getServices(): array
    {
        return [
            Enqueue::class,
            Index::class,
            Admin::class,
        ] ;
    }

    /**
     * Loop thought the classes, initialize them,
     * and call the register() method if it exists
     *
     * @return void
     */
    public static function registerServices(): void
    {
        foreach (self::getServices() as $class) {
            $service = self::instantiate($class);
            if ($service instanceof ServiceInterface) {
                $service->register();
            }
        }
    }

    /**
     * Initialize the classes
     *
     * @param string $class
     * @return object instance new instance of the class
     */
    private static function instantiate(string $class): object
    {
        return (new $class());
    }

}