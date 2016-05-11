<?php
/**
 * The WP_Hooks class allows you to quickly and easily extend WordPress via
 * actions & filter hooks, shortcodes, and registration events. Simply create a class
 * that extends the WP_Hooks class and define functions of the given action, filter
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
<<<<<<< d05f4539649f233e542a10aab02bb2aec6d3ed87
 * @package DesktopServer
 * @uses GString class
 * @since 4.0.0
=======
>>>>>>> Refactored for PHP7
 */
namespace Steveorevo;

if ( class_exists( 'WP_Hooks' ) ) return;
class WP_Hooks {
    public function __construct() {
        $self = new \ReflectionClass( $this );
        $public_methods = $self->getMethods( \ReflectionMethod::IS_PUBLIC );

        if ( empty ( $public_methods ) ) {
            return;
        }
        foreach ( $public_methods as $method ) {
            if ( $method->name != '__construct' ){

                // Parse string
                $signature = new GString( $method->name );

                // Convert CamelCase to forward slash syntax and double underscore to a dash in
                // for bbPress. Also support and accomodate incompatible action names i.e. load-index.php
                // post-new.php in CPT, ACF, etc.
                $signature = $signature->replaceAll('([A-Z])', '/$0')
                    ->replace( '__','-')
                    ->replace( 'load_index_php', 'load-index.php' )
                    ->replace( '_php', '.php' );

                // Optimized for speed, handle acf only if present
                if ( strpos( $method->name, 'acf_' ) !== false ) {
                    $signature = $signature->replace( 'acf_helpers_', 'acf/helpers/' )
                        ->replace( 'acf_location_rule_types', 'acf/location/rule_types' )
                        ->replace( 'acf_location_rule_values_', 'acf/location/rule_values/' )
                        ->replace( 'acf_options_page_', 'acf/options_page/' )
                        ->replace( 'acf_input_', 'acf/input/' )
                        ->replace( 'acf_', 'acf/' );
                }
                $name = (string) $signature->toLowerCase();
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
                    $signature = new GString($name);
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
                        $signature = new GString($name);
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
