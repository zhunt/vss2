<?php
class UtilitiesComponent extends Object {
    // org. from: http://strictcoder.blogspot.com/2009_08_01_archive.html
    // optional: return IP or encoded IP address, default true
    function getRealIpAddr( $ipToInt = true) {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip=$_SERVER['HTTP_CLIENT_IP']; // share internet
        } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR']; // pass from proxy
        } else {
            $ip=$_SERVER['REMOTE_ADDR'];
        }

        if ( $ipToInt ) {
            // Converts 64.233.16.6 to 1089015814
            $ip_aton = sprintf("%u", ip2long($ip));
            $ip_aton = (substr($ip,0,3)>127) ?
                ((ip2long($ip) & 0x7FFFFFFF) + 0x80000000) : ip2long($ip);
            return $ip_aton;
        } else {
            return $ip;
        }
    }
}