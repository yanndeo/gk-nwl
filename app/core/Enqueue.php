<?php
/**
 * @package Newsletter_Geek
 */
namespace App\core;

/**
 * Class Enqueue
 * @package App\core
 */
class Enqueue implements ServiceInterface
{
    private const CSS_SCRIPT_NAME = 'gk_plugin_style';
    private const JS_MAIN_SCRIPT_NAME = 'gk_plugin_script';
    public const JS_HELPER_SCRIPT_NAME = 'gk_plugin_helper_script';
    public const WP_PHP_AJAX_REQ_GLOBAL_OBJ = 'my_ajax_obj';
    public const WP_PHP_AJAX_REQ_URL = 'admin-ajax.php';
    private const DEPT_VERSION = '1.9';

    public function register():void
    {
        // TODO: Implement register() method.
        //add all assets files - admin
        add_action('admin_enqueue_scripts',  array( $this, 'enqueueAdmin' ) );
        //add all assets files - front
        add_action('wp_enqueue_scripts', array( $this, 'enqueueFront') );
        //register javascript file as module ( to use import, export js)
        add_filter('script_loader_tag', array($this, 'handleAttributeModuleOnScript') , 10, 4);
    }


    /**
     * Load files css/js Front side
     *
     * @return void
     */
    public function enqueueFront(): void
    {
        wp_enqueue_style(self::CSS_SCRIPT_NAME, NWL_PLUGIN_URL . 'assets/css/gkpluginstyle.css' );
        wp_enqueue_script(self::JS_MAIN_SCRIPT_NAME,  NWL_PLUGIN_URL . 'assets/js/gkpluginscript.js', array( 'jquery' ),self::DEPT_VERSION,true );
        wp_enqueue_script(self::JS_HELPER_SCRIPT_NAME, NWL_PLUGIN_URL . 'assets/js/helper.js', array( self::JS_MAIN_SCRIPT_NAME ),self::DEPT_VERSION,true );
        //prepare data for ajx req. from front side
        wp_localize_script(
            self::JS_MAIN_SCRIPT_NAME,
            self::WP_PHP_AJAX_REQ_GLOBAL_OBJ,
            array(
                'ajax_url' => admin_url( self::WP_PHP_AJAX_REQ_URL ),
                'nonce'  => wp_create_nonce( WP_PHP_AJX_REQ_NONCE_SECURITY )
            )
        );
    }


    /**
     * Load files css/js to Admin side
     *
     * @return void
     */
    public function enqueueAdmin(): void { }

    /**
     * Loop and call private fn addTypeAttribute
     *
     * @param $tag
     * @param $handle
     * @param $src
     *
     * @return string
     */
    public function handleAttributeModuleOnScript( string $tag, string $handle, string $src ): string
    {
        $identifiers = [
            self::JS_MAIN_SCRIPT_NAME,
            self::JS_HELPER_SCRIPT_NAME,
        ];

        foreach ( $identifiers as $identifier ) {
            $tag =  $this->addTypeAttribute($tag, $handle, $src , $identifier);
        }

        return $tag;
    }

    /**
     * @param string $tag
     * @param string $handle
     * @param string $src
     * @param string $identifier
     *
     * @return string
     */
    private function addTypeAttribute( string $tag, string $handle, string $src , string $identifier ): string
    {
        // if not your script, do nothing and return original $tag
        if ( $identifier !== $handle ) {
            return $tag;
        }
        // change the script tag by adding type="module" and return it.
        $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';

        return $tag;
    }

}