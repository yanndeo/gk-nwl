<?php
/**
 * @package Newsletter_Geek
 */
namespace App\shortcode;

/**
 * Check and Save email into file .txt
 *
 *  @package App\shortcode
 */
class HandleForm
{
    public const EXTENSION_FILE = 'csv';
    public const FILE_NAME = 'database';
    public const PATH_FOLDER_FILE = 'shortcode';
    public const FIELDS_FILE = array('EMAIL_USER', 'CREATED_AT', 'IP_USER', 'IP_WEBSITE', 'DOMAIN');

    /**
     * Validation server side
     * nonce must be checked
     *
     * @param string $data
     */
    public static function processing(string $data)
    {
        if ( check_ajax_referer(WP_PHP_AJX_REQ_NONCE_SECURITY ) ) {
            $email = filter_var($data, FILTER_SANITIZE_EMAIL);
            if ( !filter_var($email, FILTER_VALIDATE_EMAIL ) ) {
                wp_send_json_error(); //BAD_REQUEST
            } else {
                self::save($email) ? wp_send_json_success(null, 201) : null ;
            }
        } else {
            wp_send_json_error('please contact administrator', 500);
        }
    }

    /**
     * Save data to csv file
     * line by line
     *
     * @param string $data
     *
     * @return bool
     */
    private static function save(string $data): bool
    {
        $file = self::getFilePath();

        if ( file_exists( $file) ) {
            $line = [
                $data,
                (new \DateTime())->format('Y/m/d'),
                Helper::getClientIP(),
                gethostbynamel(get_site_url())[0],
                get_site_url()
            ];

            $fp = fopen($file, 'a+');
            fputcsv($fp, $line, ',');

            return fclose($fp);
        }

        return false;
    }

    /**
     * Create new file with headers
     * if file already exist, conserve it with all data
     * if file don't exist, create new empty file with headers
     * fopen can't create folder. Need to use mkdir
     *
     * @return bool
     */
    public static function createFileWithHeaders(): bool
    {
        if ( !file_exists(self::getFilePath() ) ) {
            $headLine = self::FIELDS_FILE;
            $fp = fopen(self::getFilePath(), 'w');
            fputcsv($fp, $headLine, ',');

            return fclose($fp);
        }

        return false;
    }

    /**
     * Getter file(path)
     *
     * @return string
     */
    public static function getFilePath(): string
    {
        return
            NWL_PLUGIN_PATH .                                                                           // root plugin
            'app'. DIRECTORY_SEPARATOR .                                                                // app/
            self::PATH_FOLDER_FILE . DIRECTORY_SEPARATOR. self::FILE_NAME .'.' .self::EXTENSION_FILE ;  // shortcode/database.csv
    }

}
