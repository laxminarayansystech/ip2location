<?php
/**
 * Created by PhpStorm.
 * User: Rumi
 * Date: 10/24/2018
 * Time: 7:15 PM
 */
class IP
{
    public static function domain_2_ip($domain = "")
    {
        if (filter_var($domain, FILTER_VALIDATE_IP)) {
            return $domain;
        } else {
            $ip = gethostbyname($domain);
            if (!filter_var($ip, FILTER_VALIDATE_IP)) {
                return false;
            } else {
                return $ip;
            }
        }
    }
}