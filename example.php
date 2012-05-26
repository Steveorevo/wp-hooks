<?php
/*
 * This is an example. If this was included in your functions.php in your theme,
 * it would do stuff...
 *
 */
 
require_once ('wp-hooks.php');

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
?>