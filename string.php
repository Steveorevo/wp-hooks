<?php

/*
 * String Class
 * 
 * Allows Strings to be handled as objects and features cross language
 * parsing functions del/get left/right, available in javascript, perl,
 * asp, php, realstudio, vb, lingo, etc. GPL or contact for commercial
 * lic. in a language near you ;-)
 * 
 * Added Michael's common string manipulation functions.
 * 
 * @author  Stephen Carroll, Michael Scribellito
 * @date    2-24-2012
 * @link    http://steveorevo.com, http://mscribellito.com
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

if (! class_exists('String') ) {
    final class String {

        // holds the value of the String object
        private $value;

        /*
        * Constructor
        * 
        * The constructor sets the value of the String.
        * 
        * @access  public
        * @param   string
        * @return  void
        */

        public function __construct($value = '') {

            $this->value = (string) $value;

        }

        /*
        * Returns the character at the specified index.
        * 
        * @access  public
        * @param   int
        * @return  char
        */

        public function charAt($index) {

            if (abs($index) >= $this->length()) {
                throw new Exception('Index out of bounds');
            }

            return substr($this->value, $index, 1);

        }

        /*
        * Returns the ASCII value of the character at the specified index.
        * 
        * @access  public
        * @param   int
        * @return  int
        */

        public function charCodeAt($index) {

            if (abs($index) >= $this->length()) {
                throw new Exception('Index out of bounds');
            }

            return ord($this->charAt($index));

        }

        /*
        * Compares two Strings.
        * 
        * @access  public
        * @param   string
        * @return  int
        */

        public function compareTo($that) {

            if (!($that instanceof String)) {
                $that = new String($that);
            }
            return strcmp($this->value, $that->value);

        }

        /*
        * Compares two Strings, ignoring case differences.
        * 
        * @access  public
        * @param   string
        * @return  int
        */

        public function compareToIgnoreCase($that) {

            if (!($that instanceof String)) {
                $that = new String($that);
            }
            return strcmp($this->toLowerCase()->value, $that->toLowerCase()->value);

        }

        /*
        * Concatenates the given string(s) to the end of this String.
        * 
        * @access  public
        * @param   string
        * @return  String
        */

        public function concat() {

            $strs = func_get_args();
            $temp = array();
            foreach ($strs as $str) {
                if (!($str instanceof String)) {
                    $str = new String($str);
                }
                $temp[] = $str->value;
            }
            return new String($this->value . implode('', $temp));

        }

        /*
        * Returns TRUE if, and only if, this String contains the given sequence.
        * 
        * @access  public
        * @param   string
        * @return  boolean
        */

        public function contains($sequence) {

            return $this->indexOf($sequence) >= 0 ? TRUE : FALSE;

        }

        /*
        * Tests if this String ends with the specified suffix.
        * 
        * @access  public
        * @param   string
        * @return  boolean
        */

        public function endsWith($suffix) {

            return preg_match('/' . preg_quote($suffix) . '$/', $this->value);

        }

        /*
        * Compares this String to another String.
        * 
        * @access  public
        * @param   string
        * @return  boolean
        */

        public function equals($that, $ignoreCase = FALSE) {

            if (!($that instanceof String)) {
                $that = new String($that);
            }

            $a = $this;
            $b = $that;

            if ($ignoreCase === TRUE) {
                $a = $a->toLowerCase();
                $b = $b->toLowerCase();
            }

            return $a->value === $b->value;

        }

        /*
        * Compares this String to another String, ignoring case differences.
        * 
        * @access  public
        * @param   string
        * @return  boolean
        */

        public function equalsIgnoreCase($that) {

            return $this->equals($that, TRUE);

        }

        /*
        * Returns a formatted String.
        * 
        * @access  public
        * @return  String
        */

        public static function format($str) {

            $args = func_get_args();
            $argc = count($args);

            for ($i = 1; $i < $argc; $i++) {
                $str = preg_replace('/\%s/', $args[$i], $str, 1);
            }

            return new String($str);

        }

        /*
        * Generates a String from given ASCII values.
        * 
        * @access  public
        * @return
        */

        public static function fromCharCode() {

            $args = func_get_args();
            $str = new String();
            foreach ($args as $arg) {
                $str = $str->concat(chr($arg));
            }
            return new String($str->value);

        }

        /*
        * Returns a hash code for this String.
        * 
        * @access  public
        * @return  int
        */

        public function hashCode() {

            $h = 0;
            for ($i = 0, $l = $this->length(); $i < $l; $i++) {
                $h = 31 * $h + ord($this->charAt($i));
            }
            return $h;

        }

        /*
        * Returns the index within this String of the first occurrence of the 
        * specified substring, or -1 if the substring does not occur.
        * 
        * @access  public
        * @param   string
        * @param   int
        * @return  int
        */

        public function indexOf($substring, $fromIndex = 0) {

            if ($fromIndex >= $this->length() || $fromIndex < 0) {
                throw new Exception('Index out of bounds');
            }

            $index = strpos($this->value, $substring, $fromIndex);
            return (is_int($index)) ? $index : -1;

        }

        /*
        * Returns TRUE if, and only if, length is 0.
        * 
        * @access  public
        * @return  boolean
        */

        public function isEmpty() {

            return $this->length() === 0 ? TRUE : FALSE;

        }

        /*
        * Returns the index within this String of the last occurrence of the
        * specified substring, or -1 if the substring does not occur.
        * 
        * @access  public
        * @param   string
        * @param   int
        * @return  int
        */

        public function lastIndexOf($substring, $fromIndex = 0) {

            if ($fromIndex >= $this->length() || $fromIndex < 0) {
                throw new Exception('Index out of bounds');
            }

            $index = strrpos($this->value, $substring, $fromIndex);
            return is_int($index) ? $index : -1;

        }

        /*
        * Returns the length of this String.
        * 
        * @access  public
        * @return  int
        */

        public function length() {

            return strlen($this->value);

        }

        /*
        * Tells whether or not this String matches the given pattern.
        * 
        * @access  public
        * @param   string
        * @return  boolean
        */

        public function matches($pattern) {

            return preg_match($pattern, $this->value);

        }

        /*
        * Encloses this String in double quotes
        * 
        * @access  public
        * @return  String
        */

        public function quote($single = FALSE) {

            $quote = $single === FALSE ? '"' : "'";

            return new String($quote . $this->value . $quote);

        }

        /*
        * Test if two String regions are equal.
        * 
        * @access  public
        * @param   int
        * @param   String
        * @param   int
        * @param   int
        * @param   boolean
        * @return  boolean
        */

        public function regionMatches($offsetA, $that, $offsetB, $length, $ignoreCase = FALSE) {

            if (!($that instanceof String)) {
                $that = new String($that);
            }

            $a = $this->substring($offsetA, $length);
            $b = $that->substring($offsetB, $length);

            if ($ignoreCase === TRUE) {
                $a = $a->toLowerCase();
                $b = $b->toLowerCase();
            }

            return $a->value === $b->value;

        }

        /*
        * Test if two String regions are equal, ignoring case.
        * 
        * @access  public
        * @param   int
        * @param   String
        * @param   int
        * @param   int
        * @return  boolean
        */

        public function regionMatchesIgnoreCase($offsetA, $that, $offsetB, $length) {

            return $this->regionMatches($offsetA, $that, $offsetB, $length, TRUE);

        }

        /*
        * Returns a new String resulting from replacing all occurrences of old in
        * this string with new.
        * 
        * @access  public
        * @param   mixed
        * @param   mixed
        * @param   int
        * @return  String
        */

        public function replace($old, $new, $count = NULL) {

            if ($count !== NULL) {
                $temp = str_replace($old, $new, $this->value, $count);
            } else {
                $temp = str_replace($old, $new, $this->value);
            }
            return new String($temp);

        }

        /*
        * Replaces each substring of this String that matches the given pattern
        * with the given replacement.
        * 
        * @access  public
        * @param   string
        * @param   string
        * @return  String
        */

        public function replaceAll($pattern, $replacement) {

            $temp = preg_replace($pattern, $replacement, $this->value);
            return new String($temp);

        }

        /*
        * Replaces the first substring of this String that matches the given
        * pattern with the given replacement.
        * 
        * @access  public
        * @param   string
        * @param   string
        * @return  String
        */

        public function replaceFirst($pattern, $replacement) {

            $temp = preg_replace($pattern, $replacement, $this->value, 1);
            return new String($temp);

        }

        /*
        * Splits this string around matches of the given pattern.
        * 
        * @access  public
        * @param   string
        * @param   int
        * @return  array
        */

        public function split($pattern, $limit = NULL) {

            return preg_split($pattern, $this->value, $limit);

        }

        /*
        * Tests if this String starts with the specified prefix.
        * 
        * @access  public
        * @param   string
        * @return  boolean
        */

        public function startsWith($prefix) {

            return preg_match('/^' . preg_quote($prefix) . '/', $this->value);

        }

        /*
        * Returns a new String that is a substring of this string.
        * 
        * @access  public
        * @param   int
        * @param   int
        * @return  String
        */

        public function substring($start, $length = NULL) {

            if ($length !== NULL) {
                $temp = substr($this->value, $start, $length);
            } else {
                $temp = substr($this->value, $start);
            }
            return new String($temp);

        }

        /*
        * Converts this String to an array of characters.
        * 
        * @access  public
        * @return  array
        */

        public function toCharArray() {

            $chars = array();
            for ($i = 0, $l = $this->length(); $i < $l; $i++) {
                $chars[] = $this->charAt($i);
            }
            return $chars;

        }

        /*
        * Converts all of the characters in this String to lower case.
        * 
        * @access  public
        * @return  String
        */

        public function toLowerCase() {

            return new String(strtolower($this->value));

        }

        /*
        * Converts all of the characters in this String to upper case.
        * 
        * @access  public
        * @return  String
        */

        public function toUpperCase() {

            return new String(strtoupper($this->value));

        }

        /*
        * Removes leading and trailing whitespace.
        * 
        * @access  public
        * @return  String
        */

        public function trim() {

            $temp = preg_replace('/^\s+/', '', preg_replace('/\s+$/', '', $this->value));
            return new String($temp);

        }

        /*
        * Removes leading whitespace.
        * 
        * @access  public
        * @return  String
        */

        public function ltrim() {

            $temp = preg_replace('/^\s+/', '', $this->value);
            return new String($temp);

        }

        /*
        * Removes trailing whitespace.
        * 
        * @access  public
        * @return  String
        */

        public function rtrim() {

            $temp = preg_replace('/\s+$/', '', $this->value);
            return new String($temp);

        }

        /*
        * Returns the value of this String
        * 
        * @access  public
        * @return  string
        */

        public function __toString() {

            return $this->value;

        }

        /*
        * Deletes the right most string from the found search string 
        * starting from right to left, including the search string itself.
        * 
        * @access public
        * @return string
        */

        public function delRightMost($sSearch) {
            $sSource = $this->value;
            for ($i = strlen($sSource); $i >= 0; $i = $i - 1) {
                $f = strpos($sSource, $sSearch, $i);
                if ($f !== FALSE) {
                return new String(substr($sSource,0, $f));
                break;
                }
            }
            return new String($sSource);
        }

        /*
        * Deletes the left most string from the found search string 
        * starting from left to right, including the search string itself.
        * 
        * @access public
        * @return string
        */

        public function delLeftMost($sSearch) {
            $sSource = $this->value;
            for ($i = 0; $i < strlen($sSource); $i = $i + 1) {
                $f = strpos($sSource, $sSearch, $i);
                if ($f !== FALSE) {
                return new String(substr($sSource,$f + strlen($sSearch), strlen($sSource)));
                break;
                }
            }
            return new String($sSource);
        }

        /*
        * Returns the right most string from the found search string 
        * starting from right to left, excluding the search string itself.
        * 
        * @access public
        * @return string
        */

        public function getRightMost($sSearch) {
            $sSource = $this->value;
            for ($i = strlen($sSource); $i >= 0; $i = $i - 1) {
                $f = strpos($sSource, $sSearch, $i);
                if ($f !== FALSE) {
                return new String(substr($sSource,$f + strlen($sSearch), strlen($sSource)));
                }
            }
            return new String($sSource);
        }

        /*
        * Returns the left most string from the found search string 
        * starting from left to right, excluding the search string itself.
        * 
        * @access public
        * @return string
        */

        public function getLeftMost($sSearch) {
            $sSource = $this->value;
            for ($i = 0; $i < strlen($sSource); $i = $i + 1) {
                $f = strpos($sSource, $sSearch, $i);
                if ($f !== FALSE) {
                return new String(substr($sSource,0, $f));
                break;
                }
            }
            return new String($sSource);
        }

        /*
        * Returns left most string by the given number of characters.
        * 
        * @access public
        * @return string
        */

        public function left($chars){
            return new String(substr($this->value, 0, $chars));
        }

        /*
        * Returns right most string by the given number of characters.
        * 
        * @access public
        * @return string
        */

        public function right($chars){
            return new String(substr($this->value, ($chars*-1)));   
        }
    }
}
?>
