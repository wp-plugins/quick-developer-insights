<?php
/*
Plugin Name: Quick Developer Insights
Description: Quickly view usefull WordPress, PHP, MySQL & server information.
Version: 1.0
Author: Joseph Reilly
Author URI: http://www.jupiterhost.com
Plugin URI: http://www.jupiterhost.com/quick-dev-insights
Text Domain: WordPress
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

// Stop direct access
if ( ! defined( 'WPINC' ) ) {
die;
} 

add_action('admin_menu', 'quick_dev_insights_setup_menu');
 
function quick_dev_insights_setup_menu(){
        add_menu_page( 'Quick Developer Insights', 'Quick Developer Insights', 'manage_options', 'quick-dev-insights', 'quick_dev_insights_intro');
	add_submenu_page( 'quick-dev-insights', 'PHPINFO', 'PHPINFO', 'manage_options', 'php-info', 'quick_dev_insights_php' );
	add_submenu_page( 'quick-dev-insights', 'WP OPTION VALUES', 'SET WP OPTIONS', 'manage_options', 'wp-option-values', 'quick_dev_insights_wp' );
	add_submenu_page( 'quick-dev-insights', 'SHORTCODES', 'SHORTCODES', 'manage_options', 'quick-dev-shortcodes', 'quick_dev_insights_shortcodes' );
}
//Put all functions together and run it.
function quick_dev_insights_intro() {
$part = admin_url();
	echo '<div class="wrap">';
	echo "<h1>Quick Developer Insights</h1>";
	echo "<p>This plugin makes use of several functions to give developers and admins quick access to the information they need.</p>";
	echo "<p></p>";
	echo "<h1><p><a href='".$part.'admin.php?page=quick-dev-shortcodes'."'>FUNCTION SHORTCODES</a></p>";
	echo "<p><a href='".$part.'admin.php?page=wp-option-values'."'>WP OPTION VALUES</a></p>";
	echo "<p><a href='".$part.'admin.php?page=php-info'."'>PHPINFO</a></p>";
	echo "</div>";
}

function quick_dev_insights_wp() {
$part = admin_url();
	echo '<div class="wrap">';
	echo "<h1>WordPress Option Values</h1><p><a href='".$part.'options.php'."'>WP All Settings Page</a></p>";
	echo quick_dev_insights_wp_options();
	echo "</div>";

}

function quick_dev_insights_php() {
	echo '<div class="wrap">';
	echo "<h1>PHPINFO()</h1>";
	echo quick_dev_insights_phpinfo();
	echo "</div>";

}
function quick_dev_insights_shortcodes() {
	echo '<div class="wrap">';
	echo "<h1>SHORTCODES</h1>";
	echo "<h1>[qdi_cpu] = getrusage()</h1>";
	echo "<h1>[qdi_funct] = get_defined_functions()</h1>";
	echo "<h1>[qdi_class] = get_declared_classes()</h1>";
	echo "<h1>[qdi_mem] = memory_get_usage()</h1>";
	echo "</div>";


}

//parse phpinfo() array strip characters and create html view
function quick_dev_insights_phpinfo() {
ob_start();
phpinfo(-1);
$phpinfo = array('phpinfo' => array());

	if(preg_match_all('#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s', ob_get_clean(), $matches, PREG_SET_ORDER)){
	    foreach($matches as $match){
		if(strlen($match[1])){
		    $phpinfo[$match[1]] = array();
		}elseif(isset($match[3])){
		$keys1 = array_keys($phpinfo);
		$phpinfo[end($keys1)][$match[2]] = isset($match[4]) ? array($match[3], $match[4]) : $match[3];
		}else{
		    $keys1 = array_keys($phpinfo);
		    $phpinfo[end($keys1)][] = $match[2];	  
			
		}
		
	    }
	}

	if(! empty($phpinfo)){
		foreach($phpinfo as $name => $section) {
			echo "<h3>$name</h3>\n<table class='wp-list-table widefat fixed pages'>\n";
			foreach($section as $key => $val){
				    if(is_array($val)){
					echo "<tr><td>$key</td><td>$val[0]</td><td>$val[1]</td></tr>\n";
				    }elseif(is_string($key)){
					echo "<tr><td>$key</td><td>$val</td></tr>\n";
				    }else{
					echo "<tr><td>$val</td></tr>\n";
				}
			}
		}
			echo "</table>\n";
		}else{
	echo "<h3>Sorry, the phpinfo() function is not accessable. Perhaps, it is disabled<a href='http://php.net/manual/en/function.phpinfo.php'>See the documentation.</a></h3>";
	}
}
function quick_dev_insights_wp_options() {
$wp_options = wp_load_alloptions();
	if(! empty($wp_options)){
		echo "<h3>WordPress Options</h3>\n<table class='wp-list-table widefat fixed pages'>\n";
		foreach($wp_options as $key => $val) {
			    if(is_array($val))
				echo "<tr><td>$key</td><td>$val[0]</td><td>$val[1]</td></tr>\n";
			    elseif(is_string($key))
				echo "<tr><td>$key</td><td>$val</td></tr>\n";
			    else
				echo "<tr><td>$val</td></tr>\n";
			}
		echo "</table>\n";

	}else{
		echo "<h3>Sorry, the wp_load_alloptions function is not accessable. Perhaps, the WordPress core has changed? <a href='http://codex.wordpress.org/Function_Reference/wp_load_alloptions'>See the documentation.</a></h3>";
	}
}

function quick_dev_insights_memory() {
echo "Initial: ".memory_get_usage()." bytes -- ";
echo "Final: ".memory_get_usage()." bytes -- ";
echo "Peak: ".memory_get_peak_usage()." bytes ";

}

function quick_dev_insights_cpu() {
$usage = getrusage();
	if(! empty($usage)){
		echo "<h3>Usage:</h3>\n<table class='wp-list-table widefat fixed pages'>\n";
		foreach($usage as $key => $val) {
			    if(is_array($val))
				echo "<tr><td>$key</td><td>$val[0]</td><td>$val[1]</td></tr>\n";
			    elseif(is_string($key))
				echo "<tr><td>$key</td><td>$val</td></tr>\n";
			    else
				echo "<tr><td>$val</td></tr>\n";
			}
		echo "</table>\n";

	}else{
		echo "<h3>Sorry, There was an unexpected error.</a></h3>";
	}
}

function quick_dev_insights_functions() {
$arr = get_defined_functions();
	if(! empty($arr)){
		echo "<h3>Functions:</h3>\n<table class='wp-list-table widefat fixed pages'>\n";
		foreach($arr as $key => $val) {
			    if(is_array($val))
				echo "<tr><td>$key</td><td>$val[0]</td><td>$val[1]</td></tr>\n";
			    elseif(is_string($key))
				echo "<tr><td>$key</td><td>$val</td></tr>\n";
			    else
				echo "<tr><td>$val</td></tr>\n";
			}
		echo "</table>\n";

	}else{
		echo "<h3>Sorry, There was an unexpected error.</a></h3>";
	}
}

function quick_dev_insights_classes() {
$class = get_declared_classes();
	if(! empty($class)){
		echo "<h3>Classes:</h3>\n<table class='wp-list-table widefat fixed pages'>\n";
		foreach($class as $key => $val) {
			    if(is_array($val))
				echo "<tr><td>$key</td><td>$val[0]</td><td>$val[1]</td></tr>\n";
			    elseif(is_string($key))
				echo "<tr><td>$key</td><td>$val</td></tr>\n";
			    else
				echo "<tr><td>$val</td></tr>\n";
			}
		echo "</table>\n";

	}else{
		echo "<h3>Sorry, There was an unexpected error.</a></h3>";
	}

}
add_shortcode( 'qdi_cpu', 'quick_dev_insights_cpu');

add_shortcode( 'qdi_mem', 'quick_dev_insights_memory');

add_shortcode( 'qdi_funct', 'quick_dev_insights_functions');

add_shortcode( 'qdi_class', 'quick_dev_insights_classes');
?>
