<?php
/**
 * @package Newsletter_Geek
 */
namespace App\shortcode;
/**
 * Class Helper
 * @package App\shortcode
 */
class Helper
{
    /**
     * Get real user ip address
     *
     * @return mixed|string
     */
    public static function getClientIP() 
    {
        $ipAddress = '';
        if (isset($_SERVER['REMOTE_ADDR']))
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['HTTP_CLIENT_IP']))
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];

        return $ipAddress;
    }
}
