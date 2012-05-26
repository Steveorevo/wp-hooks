<?php
require_once ('string.php');

/**
 * The WP Hooks class allows you to quickly and easily create WordPress plugins or extend 
 * WordPress via actions & filter hooks, shortcodes, and registration events. Simply create
 * a class that extends the WP_Hooks class and define functions of the given action, filter
 * shortcode, or registration event you wish to implement behaviors for. You can specify 
 * priorities by extending the function name with an underscore and priority numeric i.e.
 * 
 * function wp_head_10() { ...
 *
 * Implement hooks that use the dash and slash symbol using double underscore and double
 * underscore + Camel case. i.e.
 *
 * function shortcode_edit__post__link() {...
 *    // Creates a shortcode [edit-post-link]   
 *
 * or
 *
 * function get_template_part_bbpress_Content() { ...
 *    // Hooks "get_template_part_bbpress/content"
 *
 * @package NexusHybrid
 * @subpackage Classes
 * @author Stephen Carroll <steve@serverpress.org>
 * @copyright Copyright (c) 2012, Stephen Carroll
 * @link http://serverpress.org/nexus-core
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Search WP_Hooks Class
 *
 * @since 0.6.0
 */
if (! class_exists('WP_Hooks') ) {
    
    class WP_Hooks {
        public function __construct() {
            $self = new ReflectionClass( $this );
            $public_methods = $self->getMethods( ReflectionMethod::IS_PUBLIC );

            if ( empty ( $public_methods ) ) {
                return;
            }
            foreach ( $public_methods as $method ) {                
                if ( $method->name != '__construct' ){

                    // Parse string 
                    $signature = new String( $method->name );
                    
                    // Convert _CamelCase to dash syntax & __ with / for bbPress support
                    $name = (string) $signature->replaceAll('([A-Z])', '/$0')
                            ->replace('_/','/')
                            ->replace('__','-')
                            ->toLowerCase();
                    $params = $method->getNumberOfParameters();
                    
                    // Check for activation, deactivation, uninstall hooks
                    if ($name == 'activation') {
                        register_activation_hook(__FILE__, array( $this, $method->name ));
                        
                    }elseif ($name == 'deactivation') {
                        register_deactivation_hook(__FILE__, array( $this, $method->name ));

                    }elseif ($name == 'uninstall') {
                        register_uninstall_hook(__FILE__, array( $this, $method->name ));

                    // Look for shortcode definition
                    }elseif ( $signature->getLeftMost('_')->equals('shortcode') ){
                        $signature = new String($name);
                        add_shortcode(
                            (string) $signature->delLeftMost('_'),
                            array ( $this, $method->name )
                        );

                    // Assume for action/filter hook definition
                    }else{

                        // Check for priority option
                        $priority = (string) $signature->getRightMost('_');
                        if ( is_numeric( $priority ) ){
                            $priority = (int) $priority;
                            $name = (string) $signature->delRightMost('_');
                        }else{
                            $priority = 10;
                        }
                        add_filter(
                            $name,
                            array( $this, $method->name ),
                            $priority,
                            $params
                        );
                    }
                }
            }
        }
    }
    
}
?>
