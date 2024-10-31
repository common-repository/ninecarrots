<?php
add_action( 'admin_menu', 'ninecarrots_config_page' );
//add_action( 'admin_menu', 'ninecarrots_stats_page' );
ninecarrots_admin_warnings();

function ninecarrots_admin_init() {
    global $wp_version;
    
    // all admin functions are disabled in old versions
    if ( !function_exists('is_multisite') && version_compare( $wp_version, '2.0', '<' ) ) {
        
        function ninecarrots_version_warning() {
            echo "
            <div id='ninecarrots-warning' class='updated fade'><p><strong>".sprintf(__('NineCarrots %s requires WordPress 2.0 or higher.'), NINECARROTS_VERSION) ."</strong> ".sprintf(__('Please <a href="%s">upgrade WordPress</a> to a current version.'), 'http://codex.wordpress.org/Upgrading_WordPress'). "</p></div>
            ";
        }
        add_action('admin_notices', 'ninecarrots_version_warning'); 
        
        return; 
    }

    /*
    if ( function_exists( 'get_plugin_page_hook' ) )
        $hook = get_plugin_page_hook( 'ninecarrots-stats-display', 'index.php' );
    else
        $hook = 'dashboard_page_ninecarrots-stats-display';
    add_action('admin_head-'.$hook, 'ninecarrots_stats_script');
    */
}
add_action('admin_init', 'ninecarrots_admin_init');

function ninecarrots_nonce_field($action = -1) { return wp_nonce_field($action); }

function ninecarrots_config_page() {
	if ( function_exists('add_submenu_page') )
		add_submenu_page('plugins.php', __('NineCarrots Config'), __('NineCarrots Config'), 'manage_options', 'ninecarrots-location-config', 'ninecarrots_location_conf');
}

function ninecarrots_stats_page() {
	if ( function_exists('add_submenu_page') )
		add_submenu_page('index.php', __('NineCarrots Stats'), __('NineCarrots Stats'), 'manage_options', 'ninecarrots-stats-display', 'ninecarrots_stats_display');

}

function ninecarrots_css() {
    wp_enqueue_style('ninecarrots', WP_PLUGIN_URL . '/ninecarrots/ninecarrots.css');
}

function ninecarrots_script() {
    wp_enqueue_script("jquery");
    wp_enqueue_script('ninecarrots', WP_PLUGIN_URL . '/ninecarrots/ninecarrots.js', array('jquery'));
}

add_action( 'admin_print_styles', 'ninecarrots_css' );
add_action( 'admin_print_scripts', 'ninecarrots_script' );

function ninecarrots_location_conf() {
  global $ninecarrots_nonce;
  
  if (isset($_POST['submit'])) {
    if ( function_exists('current_user_can') && !current_user_can('manage_options') ) die(__('Cheatin&#8217; uh?'));
    print('<div id="message" class="updated fade"><p><strong>Options saved</strong></p></div>');
    $new_map_path = $_POST['form_path'];
    if ($new_map_path != '' && $new_map_path != '/') {
        if (substr($new_map_path, 0, 1) != '/') $new_map_path = "/$new_map_path";
        update_option('ninecarrots_map_path', $new_map_path);
    }
    if (isset($_POST['form_location_type']))     update_option('ninecarrots_location_type',     $_POST['form_location_type']);
    if (isset($_POST['form_local_group']))       update_option('ninecarrots_local_group',       $_POST['form_local_group']);
    if (isset($_POST['form_location']))          update_option('ninecarrots_location',          $_POST['form_location']);
    if (isset($_POST['form_display_options']))   update_option('ninecarrots_display_options',   $_POST['form_display_options']);
    update_option('ninecarrots_display_poweredby', isset($_POST['form_display_poweredby']) ? 'on' : '');
    if (isset($_POST['form_zoom']))              update_option('ninecarrots_zoom',              $_POST['form_zoom']);
  }
  
  //get the local group list from 9carrots.org
  $localgroup_list    = '';
  $current_localgroup = get_option('ninecarrots_local_group');
  $doc = new DOMDocument('1.0', 'utf-8');
  $doc->load('http://9carrots.org/api/envgroup/index.xml');
  $xpath = new DOMXpath($doc);
  $list = $xpath->query('//localgroup');
  for ($i = 0; $i < $list->length; $i++) {
    $locagroup        = $list->item($i);
    $name             = $xpath->query('name',    $locagroup)->item(0)->textContent;
    $subsite          = $xpath->query('subsite', $locagroup)->item(0)->textContent;
    $selected         = $subsite == $current_localgroup ? ' selected="1"' : '';
    $localgroup_list .= '<option'.$selected.' value="'.htmlspecialchars($subsite).'">'.htmlspecialchars($name).'</option>';
  }
  
  $map_path = get_option('ninecarrots_map_path', '/map');
  require_once dirname( __FILE__ ) . '/ninecarrots-location-config.php';
}

function ninecarrots_stats() {
	$path = plugin_basename(__FILE__);
	echo '<h3>' . _x( 'NineCarrots', 'activity' ) . '</h3>';
	global $submenu;
	if ( isset( $submenu['edit-comments.php'] ) )
		$link = 'edit-comments.php';
	else
		$link = 'edit.php';
  $count = 1;
}
//add_action('activity_box_end', 'ninecarrots_stats');

function ninecarrots_admin_warnings() {
	if ( !get_option('wordpress_api_key') && !isset($_POST['submit']) ) {
    if (!isset($_GET['page']) || $_GET['page'] != 'ninecarrots-location-config') {
      if (!get_option('ninecarrots_map_path')) {
		    function ninecarrots_warning() {
			    echo "
			    <div id='ninecarrots-warning' class='updated fade'><p><strong>".__('NineCarrots mapping is almost ready.')."</strong> ".sprintf(__('You must <a href="%1$s">enter your location or 9carrots group name</a> for it to work.'), "plugins.php?page=ninecarrots-location-config")."</p></div>
			    ";
		    }
		    add_action('admin_notices', 'ninecarrots_warning');
      }
    }
		return;
	}
}
?>