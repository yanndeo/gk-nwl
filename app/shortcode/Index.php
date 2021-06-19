<?php
/**
 * @package Newsletter_Geek
 */
namespace App\shortcode;

use App\core\ServiceInterface;

/**
 * Manage shortcode
 * Class Index
 * @package App\shortcode
 */
class Index implements ServiceInterface
{

    public const SHORTCODE_TAG_NAME = 'nwl_form';
    //also make sure this is used to execute the ajax request
    public const WP_PHP_AJAX_ACTION = 'save_user_email' ;

    /**
     * Load all methods initialized on boot plugin
     */
    public function register(): void
    {
        // TODO: Implement register() method.
        //register shortcode
        add_shortcode(self::SHORTCODE_TAG_NAME, array( $this, 'render' ) );
        //permit and handle ajx req. for users connected and no connected
        add_action( 'wp_ajax_' . self::WP_PHP_AJAX_ACTION, array( $this, 'handleAjaxRequest' ) );
        add_action( 'wp_ajax_nopriv_' . self::WP_PHP_AJAX_ACTION, array( $this, 'handleAjaxRequest' ) );
    }



    public function render(): void
    {
        require_once NWL_PLUGIN_PATH . NWL_TEMPLATE_FOLDER. DIRECTORY_SEPARATOR.'form.view.php';
    }

    /**
     * Call class that handle all process
     * after form submission
     */
    public function handleAjaxRequest()
    {
        HandleForm::processing($_POST['user_email']);
    }

}