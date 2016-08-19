<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
//helper functions----------------------------------------------------------------//
//------------------------------------------------------------------------------------//

//insert this instead of the_content() for a stripped html version
function onepix_strip_html_the_content() {
    ob_start();
    the_content();
    $old_content = ob_get_clean();
    $new_content = strip_tags($old_content);
    echo $new_content;
}

//filter content
function onepix_filter_content($content) {
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}

////shorten string and add suffix "more" link
//function onepix_shorten($string, $length) {
//    // By default, an ellipsis will be appended to the end of the text.
//    $suffix = '&hellip;';
//    // Convert 'smart' punctuation to 'dumb' punctuation, strip the HTML tags,
//    // and convert all tabs and line-break characters to single spaces.
//    $short_desc = trim(str_replace(array("\r","\n", "\t"), ' ', strip_tags($string)));
//    // Cut the string to the requested length, and strip any extraneous spaces 
//    // from the beginning and end.
//    $desc = trim(substr($short_desc, 0, $length));
//    // Find out what the last displayed character is in the shortened string
//    $lastchar = substr($desc, -1, 1);
//    // If the last character is a period, an exclamation point, or a question 
//    // mark, clear out the appended text.
//    // Append the text.
//    $desc .= $suffix;
//    // Send the new description back to the page.
//    return $desc;
//}

//shorten string and add suffix link
function onepix_shorten($string, $length) {
    
    // Convert 'smart' punctuation to 'dumb' punctuation, strip the HTML tags,
    // and convert all tabs and line-break characters to single spaces.
    $short_desc = trim(str_replace(array("\r","\n", "\t"), ' ', strip_tags($string)));

    $stringlen = strlen( $short_desc );
    if($stringlen > $length){
        // By default, an ellipsis will be appended to the end of the text.
        $suffix = '&hellip;';
        // Cut the string to the requested length, and strip any extraneous spaces 
        // from the beginning and end.
        $desc = trim(substr($short_desc, 0, $length));
        // Find out what the last displayed character is in the shortened string
        $lastchar = substr($desc, -1, 1);
        // If the last character is a period, an exclamation point, or a question 
        // mark, clear out the appended text.
        // Append the text.
        $desc .= $suffix;
        // Send the new description back to the page.
        return $desc;
    } else {
        // Send the new description back to the page.
        return $short_desc;
    }

}

//remove http://
function onepix_strip_http ($input) {
 //$input  = 'www.google.co.uk/';
// in case scheme relative URI is passed, e.g., //www.google.com/
$input = trim($input, '/');
// If scheme not included, prepend it
if (!preg_match('#^http(s)?://#', $input)) {
    $input = 'http://' . $input;
}
$urlParts = parse_url($input);
// remove www
$domain = preg_replace('/^www\./', '', $urlParts['host']);
echo $domain;
// output: google.co.uk
}

//return an array from a comma separated list
function onepix_string_to_array ($string) {
    
    if ($string != '') {
    // /^-?\d+(?:,\s?-?\d+)*$/ matches: -1 | 1 | -12,-23 | 12,23 | -123, -234 | 123, 234  | etc.
//            $string = (preg_match('/^-?\d+(?:,\s?-?\d+)*$/', $string) == 1) ? $string : __('Expecting comma separated numeric values', 'contrib_textdomain');
        $string = (preg_match('/^-?\d+(?:,\s?-?\d+)*$/', $string) == 1) ? $string : '';
    } else {
        $string = $string;
    }

    $stringArray = explode(",", $string);
    
    return $stringArray;
}

//convert hex to rgb .Use: $rgb = hex2rgb("#cc0"); 
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}


//for testing purposes----------------------------------------------------------------//
//------------------------------------------------------------------------------------//

// add the action
add_action( 'testhook_output', 'onepix_test_output' );

//create custom testing hook for testing
function onepix_test_output($print_me) {
   print_r($print_me);
}

//you would print this out by colling this in your template file(s)
// do_action('testhook_output');
?>