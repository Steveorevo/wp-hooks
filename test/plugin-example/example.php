<?php
/**
 * @package Example_Plugin
 * @version 1.0
 */
/*
Plugin Name: Example Plugin
Plugin URI: http://steveorevo.com/
Description: This simple plugin illustrates the OOP use of wp-hooks.
Author: Stephen J. Carnam
Version: 1.0
Author URI: http://steveorevo.com/
*/

require('vendor/autoload.php');
use Steveorevo\WP_Hooks;

class MyExample extends WP_Hooks {
	function wp_footer(){
		// This will appear in the footer
		echo "I'm a footer action!";
	}
	function shortcode_hello(){
		// This will appear when using the shortcode [hello]
		echo "I'm a shortcode called hello!";
	}
	function wp_head_10(){
		// Action for popup alert with priority 10 (default anyways)
		echo "<script>alert('I\'m a wp_head action!');</script>";
	}
}

// Create our example object
global $me;
$me = new MyExample();
