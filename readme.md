# WP-Hooks

WP-Hooks is a base class that minimizes the overhead of creating WordPress plugins and functions. Get straight to writing code that matters: your plugin's behaviors! WP-Hooks lets you quickly and easily create WordPress plugins and extend WordPress via actions, filters, shortcodes, and registration events. Simply create a class that extends the WP_Hooks class and start defining functions for the given action, filter, shortcode or registration event. Using this OOP technique for object based 'event like' programming saves you lines of code and increases clarity by focusing on just your custom functionality and behaviors.

Features:

* Create actions and filters by implementing the given method - `function wp_head() {...`
* Specify priorities via postfixing an underscore and numeric - `function wp_head_10() {...`
* Create shortcodes by just prefixing your function - `function shortcode_hello() {...`
* Implement behaviors for plugin de/activation, and uninstall - `function activation() {...`
* Support non-PHP friendly action hooks that contain dash or slashes (bbPress)

## Usage

Include the wp-hooks.php and string.php files in your plugin or WordPress theme. wp-hooks.php references string.php. Simply `require_once('wp-hooks.php');` inside your functions.php or plugin file. To prevent naming collisions and increase efficiency, make use of `private function` declarations in your class to avoid inadvertently hooking an existing action/filter hook.

## License & Copyright

WP-Hooks is Copyright Stephen Carroll 2012, and is offered under the terms of the GNU General Public License, version 2. The String object definition, including parsing functions delLeftMost, getLeftMost, delRightMost, getRightMost, etc. are also offered under terms of the GNU General Public License, version 2 and is available in PHP, Java, JavaScript, ActionScript, Lingo, Visual Basic, RealStudio, Perl, VBScript, AppleScript and even MySQL! Please contact me for non-GPL, commercial licensing.
