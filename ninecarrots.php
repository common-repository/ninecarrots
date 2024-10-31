<?php
/**
 * @package ninecarrots
 * @version 1.0
 */
/*
Plugin Name: NineCarrots
Plugin URI: http://wordpress.org/extend/plugins/ninecarrots/
Description: Map local businesses and their commitments to local community interests. You need to <a href="plugins.php?page=ninecarrots-location-config">configure your location</a> to centre the map on your local community. Use the <a target="_blank" href="http://9carrots.org">9carrots.org interface</a> to add businesses.
Author: Annesley Newholm
Version: 1.0
Author URI: http://9carrots.org/
*/
/*  Copyright 2011  Annesley Newholm  (email : annesley_newholm@yahoo.it)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
function ninecarrots_parse_request( $wp )
{
    $request_uri = $_SERVER['REQUEST_URI'];
    $map_path    = get_option('ninecarrots_map_path');
    if (
        (($map_path == '' || !isset($map_path)) && ($request_uri == '/?page=map' || $request_uri == '/?p=map' || $request_uri == '/map'))
        || (($map_path != '' && isset($map_path)) && $request_uri == $map_path)
    ) {
        $display_options   = get_option('ninecarrots_display_options', 'F');
        $display_poweredby = get_option('ninecarrots_display_poweredby') == 'on';
        $common_options    = "display_poweredby=$display_poweredby";
        if ($display_options == 'F') { //FULL PAGE mode
            print('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">');
            print('<html lang="en"><head></head><body>');
            switch (get_option('ninecarrots_location_type', 'W')) {
                case 'W': {
                    print("<script src=\"http://9carrots.org/embed?$common_options\"></script>"); 
                    break;
                }
                case 'G': {
                    $localgroup = get_option('ninecarrots_local_group', 'www');
                    print("<script src=\"http://$localgroup.9carrots.org/embed?$common_options\"></script>"); 
                    break;
                }
                case 'L': {
                    $location = urlencode(get_option('ninecarrots_location', 'London, UK'));
                    $zoom     = get_option('ninecarrots_zoom', '13');
                    print("<script src=\"http://9carrots.org/embed?location=$location&zoom=$zoom&$common_options\"></script>"); 
                    break;
                }
            }
            print('</body></html>');
            exit();
        } else {
            //POST mode
            print('POST mode not supported yet...');
            exit();
        }
    }
    return;
}
add_action( 'template_redirect', 'ninecarrots_parse_request' );

if (is_admin()) require_once(dirname( __FILE__ ) . '/admin.php');
?>
