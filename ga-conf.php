<?php
/*
Plugin Name: Pixel de Google Analytics
Plugin URI: https://www.labschool.es
Description: Agrega f&aacute;cilmente el c&oacute;digo de Google Analytics a tu web y personaliza la atribuci&oacute;n de enlaces mejorada y los informes de datos demogr&aacute;ficos.
Version: 1.0.2
Tested up to: 5.4
Author: Lab School
Author URI: https://www.labschool.es
License: GPLv2
*/

if(!defined('ABSPATH')) exit;
require_once('ga-admin.php');

/* ACTIVAR PLUGIN */
register_activation_hook( __FILE__, 'pga_universal_install' );

function pga_universal_install() {
	$pga_universal_options = array(
        'id' 					=> '',
		'include_snippet_ga' 	=> '0',
        'anonymizeip' 			=> '0',
		'linkid' 				=> '0',
		'display' 				=> '0'        
    );
	if(!get_option('pga_universal_options')) {
        update_option('pga_universal_options', $pga_universal_options);
	}
}

/* INICIAR PLUGIN */
add_action('plugins_loaded', 'pga_universal_setup');
function pga_universal_setup() {
	add_action('wp_head', 'pga_universal_header', 100);
}

function pga_universal_header() {
	$options 		= get_option('pga_universal_options');
    $id 			= esc_html($options['id']);
	$display 		= isset($options['display']) && $options['display'] ? "true" : "false";
	$anonymizeip 	= isset($options['anonymizeip']) && $options['anonymizeip'] ? "true" : "false";
	$linkid		 	= isset($options['linkid']) && $options['linkid'] ? "true" : "false";
	
    if (!isset($options['include_snippet_ga']) != '1' || $options['include_snippet_ga'] ) { 
?> 
<!-- Google Analytics (gtag.js) by Lab School -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $id;?>"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
<?php echo "gtag('config', '$id', {'allow_display_features':$display, 'anonymize_ip':$anonymizeip, 'link_attribution':$linkid});";?> 
</script>
<!-- Google Analytics (gtag.js) by Lab School -->
<?php 
	}
}
?>