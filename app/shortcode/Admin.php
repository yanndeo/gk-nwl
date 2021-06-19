<?php
/**
 * @package Newsletter_Geek
 */
namespace App\shortcode;

use App\core\ServiceInterface;

/**
 * Class Admin
 * @package App\shortcode
 */
class Admin implements ServiceInterface
{
    private const MENU_PAGE_POSITION = 111;
    private const MENU_PAGE_TITLE = 'Newsletter';
    private const MENU_ICON = 'dashicons-database';
    public const SETTING_LINKS = '<a href="admin.php?page=newsletter_geek_plugin">Settings</a>';

    /**
     * Load all methods initialized on boot plugin
     */
    public function register(): void
    {
        // TODO: Implement register() method.
        //add new menu on admin to handle our plugin(dashboard)
        add_action('admin_menu', array( $this, 'addView') );
        //add link( settings) on plugin ad redirect to specific page
        add_filter("plugin_action_links_". NWL_PLUGIN_BASENAME  , array( $this, 'addSettingsLink') );
    }



    /**
     * Prepare admin page to manage plugin
     *
     * @return void
     */
    public function addView(): void
    {
        add_menu_page(
            NWL_PLUGIN_NAME.' Plugin',
            self::MENU_PAGE_TITLE,
            'manage_options',
            strtolower( str_replace( ' ', '_', NWL_PLUGIN_NAME . '_plugin' ) ),
            array( $this, 'render' ),
            self::MENU_ICON,
            self::MENU_PAGE_POSITION
        );
    }

    public function render(): void
    {
        require_once NWL_PLUGIN_PATH . NWL_TEMPLATE_FOLDER. DIRECTORY_SEPARATOR.'admin.view.php';
    }

    /**
     * Settings link in plugin
     *
     * @param array $links
     *
     * @return array
     */
    public function addSettingsLink(array $links): array
    {
        array_push($links, self::SETTING_LINKS);

        return $links;
    }

}