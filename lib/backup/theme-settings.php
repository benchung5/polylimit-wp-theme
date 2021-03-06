<?php
/* ------------------------------------------------------------------------ *
 * Define Constants 
 * ------------------------------------------------------------------------ */ 
 
define('ONEPIX_SHORTNAME', 'onepix'); // used to prefix the individual setting field id see onepix_options_page_fields()  
define('ONEPIX_PAGE_BASENAME', 'onepix-settings'); // the settings page slug


/* ------------------------------------------------------------------------ *
 * Helper function for defining variables for the current page 
 * ------------------------------------------------------------------------ */ 

function onepix_get_settings() {
      
    $output = array();  
      
    // put together the output array   
    $output['onepix_option_name']       = 'onepix_options'; // the option name as used in the get_option() call.   
    $output['onepix_page_title']        = __( '1 Pixel Settings','onepix_textdomain'); // the settings page title  
    $output['onepix_page_sections']     = onepix_options_page_sections(); // the setting section  
    $output['onepix_page_fields']       = onepix_options_page_fields();  
    $output['onepix_contextual_help']   = onepix_options_page_contextual_help();
      
return $output;
}

/* ------------------------------------------------------------------------ *
 * Helper function for registering our form field settings 
 * ------------------------------------------------------------------------ */ 

/** 
* src: http://alisothegeek.com/2011/01/wordpress-settings-api-tutorial-1/ 
* @param (array) $args The array of arguments to be used in creating the field 
* @return function call 
*/  
function onepix_create_settings_field( $args = array() ) {  
    // default array to overwrite when calling the function  
    $defaults = array(  
        'id'      => 'default_field',                    // the ID of the setting in our options array, and the ID of the HTML form element  
        'title'   => 'Default Field',                    // the label for the HTML form element  
        'desc'    => 'This is a default description.',  // the description displayed under the HTML form element  
        'std'     => '',                                 // the default value for this setting  
        'type'    => 'text',                             // the HTML form element to use  
        'section' => 'main_section',                     // the section this setting belongs to � must match the array key of a section in onepix_options_page_sections()  
        'choices' => array(),                            // (optional): the values in radio buttons or a drop-down menu  
        'class'   => '',                                 // the HTML form element class. Also used for validation purposes!
        'page'    => 'general_page'
    );  

    // "extract" to be able to use the array keys as variables in our function output below  
    extract( wp_parse_args( $args, $defaults ) );  

    // additional arguments for use in form field output in the function onepix_form_field_fn!  
    $field_args = array(  
        'type'      => $type,  
        'id'        => $id,  
        'desc'      => $desc,  
        'std'       => $std,  
        'choices'   => $choices,  
        'label_for' => $id,  
        'class'     => $class  
    );  
    //this is a wordpress funtions
    add_settings_field(
            $id,                      // ID used to identify the field throughout the theme
            $title,                   // The label to the left of the option interface element
            'onepix_form_field_fn',   // The name of the function responsible for rendering the option interface
            $page,                    // The page on which this option will be displayed
            $section,                 // The name of the section to which this field belongs
            $field_args               // The array of arguments to pass to the callback. In this case, just a description.
            ); 
    
//    add_settings_field(
//    'show_header',                      // ID used to identify the field throughout the theme
//    'Header',                           // The label to the left of the option interface element
//    'sandbox_toggle_header_callback',   // The name of the function responsible for rendering the option interface
//    'general',                          // The page on which this option will be displayed
//    'general_settings_section',         // The name of the section to which this field belongs
//    array(                              // The array of arguments to pass to the callback. In this case, just a description.
//        'Activate this setting to display the header.'
//    )
//);

}



/* ------------------------------------------------------------------------ *
 * Admin Settings Page HTML 
 * ------------------------------------------------------------------------ */ 

function onepix_settings_page_fn() {  
// get the settings sections array  
    $settings_output = onepix_get_settings();  
?>  
    <div class="wrap">  
        <div class="icon32" id="icon-options-general"></div>  
        <h2><?php echo $settings_output['onepix_page_title']; ?></h2>  
          
        <?php
            //get the active tab from the wordpress provided get variable
            $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general_settings';
        ?>

<!--    tabs - (wordpress privides css for "nav-tab-wrapper" and "nav-tab")-->
        <h2 class="nav-tab-wrapper">
            <a href="?page=onepix-settings&tab=general_settings" class="nav-tab <?php echo $active_tab == 'general_settings' ? 'nav-tab-active' : ''; ?>">General</a>
            <a href="?page=onepix-settings&tab=typography_settings" class="nav-tab <?php echo $active_tab == 'typography_settings' ? 'nav-tab-active' : ''; ?>">Typography</a>
            <a href="?page=onepix-settings&tab=color_settings" class="nav-tab <?php echo $active_tab == 'color_settings' ? 'nav-tab-active' : ''; ?>">Color</a>
            <a href="?page=onepix-settings&tab=header_settings" class="nav-tab <?php echo $active_tab == 'header_settings' ? 'nav-tab-active' : ''; ?>">Header</a>
            <a href="?page=onepix-settings&tab=home_settings" class="nav-tab <?php echo $active_tab == 'home_settings' ? 'nav-tab-active' : ''; ?>">Home Page</a>
            <a href="?page=onepix-settings&tab=layout_settings" class="nav-tab <?php echo $active_tab == 'layout_settings' ? 'nav-tab-active' : ''; ?>">Layout</a>
            <a href="?page=onepix-settings&tab=socials_settings" class="nav-tab <?php echo $active_tab == 'socials_settings' ? 'nav-tab-active' : ''; ?>">Socials</a>
            <a href="?page=onepix-settings&tab=contact_settings" class="nav-tab <?php echo $active_tab == 'contact_settings' ? 'nav-tab-active' : ''; ?>">Contact</a>
        </h2>
        
        <form action="options.php" method="post">  
            <?php   
 
                if ($active_tab == 'general_settings') {
                    // http://codex.wordpress.org/Function_Reference/settings_fields  
                    settings_fields('onepix_general_options'); 
                    // http://codex.wordpress.org/Function_Reference/do_settings_sections  
                    do_settings_sections('general_page');
                } else if ($active_tab == 'typography_settings') {
//                    settings_fields($settings_output['onepix_option_name']);
                    settings_fields('onepix_typography_options'); 
                    do_settings_sections('typography_page');

                } else if ($active_tab == 'color_settings') {
                    settings_fields('onepix_color_options'); 
                    do_settings_sections('color_page');

                } else if ($active_tab == 'header_settings') {
                    settings_fields('onepix_header_options'); 
                    do_settings_sections('header_page');

                } else if ($active_tab == 'home_settings') {
                    settings_fields('onepix_home_options'); 
                    do_settings_sections('home_page');

                } else if ($active_tab == 'layout_settings') {
                    settings_fields('onepix_layout_options'); 
                    do_settings_sections('layout_page');

                } else if ($active_tab == 'socials_settings') {
                    settings_fields('onepix_socials_options'); 
                    do_settings_sections('socials_page');

                } else if ($active_tab == 'contact_settings') {
                    settings_fields('onepix_contact_options'); 
                    do_settings_sections('contact_page');

                }
            ?>  
            <p class="submit">  
                <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes','onepix_textdomain'); ?>" />  
            </p>  

        </form>  
    </div><!-- wrap -->  
<?php }


/* ------------------------------------------------------------------------ *
 * Register our setting 
 * ------------------------------------------------------------------------ */ 

function onepix_register_settings(){
      
    // get the settings sections array  
    $settings_output = onepix_get_settings();  
    $onepix_option_name = $settings_output['onepix_option_name'];  
      
    //setting  
    // register_setting( $option_group, $option_name, $sanitize_callback );  
//    register_setting($onepix_option_name, $onepix_option_name);
    
//    register_setting('onepix_general_options', 'onepix_general_options', 'onepix_validate_options' );
//    register_setting('onepix_typography_options', 'onepix_typography_options', 'onepix_validate_options' ); 
//    register_setting('onepix_color_options', 'onepix_color_options', 'onepix_validate_options' ); 
//    register_setting('onepix_header_options', 'onepix_header_options', 'onepix_validate_options' ); 
//    register_setting('onepix_home_options', 'onepix_home_options', 'onepix_validate_options' ); 
//    register_setting('onepix_layout_options', 'onepix_layout_options', 'onepix_validate_options' );
//    register_setting('onepix_socials_options', 'onepix_socials_options', 'onepix_validate_options' );
//    register_setting('onepix_contact_options', 'onepix_contact_options', 'onepix_validate_options' ); 
    register_setting('onepix_general_options', 'onepix_general_options', 'onepix_validate_options_general' );
    register_setting('onepix_typography_options', 'onepix_typography_options' ); 
    register_setting('onepix_color_options', 'onepix_color_options' ); 
    register_setting('onepix_header_options', 'onepix_header_options'); 
    register_setting('onepix_home_options', 'onepix_home_options'); 
    register_setting('onepix_layout_options', 'onepix_layout_options' );
    register_setting('onepix_socials_options', 'onepix_socials_options' );
    register_setting('onepix_contact_options', 'onepix_contact_options' ); 
      
    //sections  
    // add_settings_section( $id, $title, $callback, $page );  
    if(!empty($settings_output['onepix_page_sections'])){  
        // call the "add_settings_section" for each!  
        foreach ( $settings_output['onepix_page_sections'] as $id => $info ) {  
            add_settings_section( $id, $info[0], 'onepix_section_fn', $info[1]);  
        }  
    }
    
    //fields  
    if(!empty($settings_output['onepix_page_fields'])){  
        // call the "add_settings_field" for each!  
        foreach ($settings_output['onepix_page_fields'] as $option) {  
            onepix_create_settings_field($option);  
        }  
    }  
} 

/* ------------------------------------------------------------------------ *
 * Validate input 
 * ------------------------------------------------------------------------ */ 

function onepix_validate_options_general($input) {
        //only validate options for the page at hand (must do it this way since the $sanitize_callback accepts no parameters)   
        $valid_input = onepix_validate_options($input, 'general_page');
        return $valid_input; // return validated input
}

function onepix_validate_options($input, $page) {

	// for enhanced security, create a new empty array
	$valid_input = array();
	
	// collect only the values we expect and fill the new $valid_input array i.e. whitelist our option IDs
	
            // get the settings sections array
            $settings_output = onepix_get_settings();

            $options = $settings_output['onepix_page_fields'];
            
            
                
		// run a foreach and switch on option type
		foreach ($options as $option) {
                    
                    if ($option['page'] == $page){
                    
			switch ( $option['type'] ) {
                            
                               // custom input for image so they can upload from the media library 
                               case 'img':
                                        //switch validation based on the class!
                                        
                                   switch ($option['class']) {
                                        //for url
                                        case 'url':
                                            //accept the input only when the url has been sanitized for database usage with esc_url_raw()
                                            $input[$option['id']] = trim($input[$option['id']]); // trim whitespace
                                            $valid_input[$option['id']] = esc_url_raw($input[$option['id']]);
                                            break;
                                    }
                                        
                                // custom input for color picker
                                case 'color':
                                    //switch validation based on the class!
                                    switch ($option['class']) {

                                        case 'hex-color':
                                            //convert hex to rgb
                                            $valid_input[$option['id']] = $input[$option['id']];
                                            break;
                                        
                                        case 'rgba-color':
                                            //convert hex to rgb
                                            $valid_input[$option['id']] = hex2rgb($input[$option['id']]);
                                            break;
                                    }
                            
				case 'text':
					//switch validation based on the class!
					switch ( $option['class'] ) {
						//for numeric 
						case 'numeric':
							//accept the input only when numeric!
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							$valid_input[$option['id']] = (is_numeric($input[$option['id']])) ? $input[$option['id']] : 'Expecting a Numeric value!';
							
							// register error
							if(is_numeric($input[$option['id']]) == FALSE) {
								add_settings_error(
									$option['id'], // setting title
									ONEPIX_SHORTNAME . '_txt_numeric_error', // error ID
									__('Expecting a Numeric value! Please fix.','onepix_textdomain'), // error message
									'error' // type of message
								);
							}
						break;
						
						//for multi-numeric values (separated by a comma)
						case 'multinumeric':
							//accept the input only when the numeric values are comma separated
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							
							if($input[$option['id']] !=''){
								// /^-?\d+(?:,\s?-?\d+)*$/ matches: -1 | 1 | -12,-23 | 12,23 | -123, -234 | 123, 234  | etc.
								$valid_input[$option['id']] = (preg_match('/^-?\d+(?:,\s?-?\d+)*$/', $input[$option['id']]) == 1) ? $input[$option['id']] : __('Expecting comma separated numeric values','onepix_textdomain');
							}else{
								$valid_input[$option['id']] = $input[$option['id']];
							}
							
							// register error
							if($input[$option['id']] !='' && preg_match('/^-?\d+(?:,\s?-?\d+)*$/', $input[$option['id']]) != 1) {
								add_settings_error(
									$option['id'], // setting title
									ONEPIX_SHORTNAME . '_txt_multinumeric_error', // error ID
									__('Expecting comma separated numeric values! Please fix.','onepix_textdomain'), // error message
									'error' // type of message
								);
							}
						break;
						
						//for no html
						case 'nohtml':
							//accept the input only after stripping out all html, extra white space etc!
							$input[$option['id']] 		= sanitize_text_field($input[$option['id']]); // need to add slashes still before sending to the database
							$valid_input[$option['id']] = addslashes($input[$option['id']]);
						break;
						//all html
                                                case 'allhtml':
                                                    //accept all html, so no code needed to alter the values.
                                                    $valid_input[$option['id']] = $input[$option['id']];
                                                break;
						//for url
						case 'url':
							//accept the input only when the url has been sanited for database usage with esc_url_raw()
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							$valid_input[$option['id']] = esc_url_raw($input[$option['id']]);
						break;
						
						//for email
						case 'email':
							//accept the input only after the email has been validated
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							if($input[$option['id']] != ''){
								$valid_input[$option['id']] = (is_email($input[$option['id']])!== FALSE) ? $input[$option['id']] : __('Invalid email! Please re-enter!','onepix_textdomain');
							}elseif($input[$option['id']] == ''){
								$valid_input[$option['id']] = __('This setting field cannot be empty! Please enter a valid email address.','onepix_textdomain');
							}
							
							// register error
							if(is_email($input[$option['id']])== FALSE || $input[$option['id']] == '') {
								add_settings_error(
									$option['id'], // setting title
									ONEPIX_SHORTNAME . '_txt_email_error', // error ID
									__('Please enter a valid email address.','onepix_textdomain'), // error message
									'error' // type of message
								);
							}
						break;
						
						// a "cover-all" fall-back when the class argument is not set
						default:
							// accept only a few inline html elements
							$allowed_html = array(
								'a' => array('href' => array (),'title' => array ()),
								'b' => array(),
								'em' => array (), 
								'i' => array (),
								'strong' => array()
							);
							
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							$input[$option['id']] 		= force_balance_tags($input[$option['id']]); // find incorrectly nested or missing closing tags and fix markup
							$input[$option['id']] 		= wp_kses( $input[$option['id']], $allowed_html); // need to add slashes still before sending to the database
							$valid_input[$option['id']] = addslashes($input[$option['id']]); 
						break;
					}
				break;

				case "multi-text":
					// this will hold the text values as an array of 'key' => 'value'
					unset($textarray);
					
					$text_values = array();
					foreach ($option['choices'] as $k => $v ) {
						// explode the connective
						$pieces = explode("|", $v);
						
						$text_values[] = $pieces[1];
					}
					
					foreach ($text_values as $v ) {		
						
						// Check that the option isn't empty
						if (!empty($input[$option['id'] . '|' . $v])) {
							// If it's not null, make sure it's sanitized, add it to an array
							switch ($option['class']) {
								// different sanitation actions based on the class create you own cases as you need them
								
								//for numeric input
								case 'numeric':
									//accept the input only if is numberic!
									$input[$option['id'] . '|' . $v]= trim($input[$option['id'] . '|' . $v]); // trim whitespace
									$input[$option['id'] . '|' . $v]= (is_numeric($input[$option['id'] . '|' . $v])) ? $input[$option['id'] . '|' . $v] : '';
								break;
								
								// a "cover-all" fall-back when the class argument is not set
								default:
									// strip all html tags and white-space.
									$input[$option['id'] . '|' . $v]= sanitize_text_field($input[$option['id'] . '|' . $v]); // need to add slashes still before sending to the database
									$input[$option['id'] . '|' . $v]= addslashes($input[$option['id'] . '|' . $v]);
								break;
							}
							// pass the sanitized user input to our $textarray array
							$textarray[$v] = $input[$option['id'] . '|' . $v];
						
						} else {
							$textarray[$v] = '';
						}
					}
					// pass the non-empty $textarray to our $valid_input array
					if (!empty($textarray)) {
						$valid_input[$option['id']] = $textarray;
					}
				break;
				
				case 'textarea':
					//switch validation based on the class!
					switch ( $option['class'] ) {
						//for only inline html
						case 'inlinehtml':
							// accept only inline html
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							$input[$option['id']] 		= force_balance_tags($input[$option['id']]); // find incorrectly nested or missing closing tags and fix markup
							$input[$option['id']] 		= addslashes($input[$option['id']]); //wp_filter_kses expects content to be escaped!
							$valid_input[$option['id']] = wp_filter_kses($input[$option['id']]); //calls stripslashes then addslashes
						break;
						
						//for no html
						case 'nohtml':
							//accept the input only after stripping out all html, extra white space etc!
							$input[$option['id']] 		= sanitize_text_field($input[$option['id']]); // need to add slashes still before sending to the database
							$valid_input[$option['id']] = addslashes($input[$option['id']]);
						break;
						
						//for allowlinebreaks
						case 'allowlinebreaks':
							//accept the input only after stripping out all html, extra white space etc!
							$input[$option['id']] 		= wp_strip_all_tags($input[$option['id']]); // need to add slashes still before sending to the database
							$valid_input[$option['id']] = addslashes($input[$option['id']]);
						break;
                                            
                                            	//all html
						case 'allhtml':
							//accept all html, so no code needed to alter the values.
							$valid_input[$option['id']] = $input[$option['id']];
						break;
						
						// a "cover-all" fall-back when the class argument is not set
						default:
							// accept only limited html
							//my allowed html
							$allowed_html = array(
								'a' 			=> array('href' => array (),'title' => array ()),
								'b' 			=> array(),
								'blockquote' 	=> array('cite' => array ()),
								'br' 			=> array(),
								'dd' 			=> array(),
								'dl' 			=> array(),
								'dt' 			=> array(),
								'em' 			=> array (), 
								'i' 			=> array (),
								'li' 			=> array(),
								'ol' 			=> array(),
								'p' 			=> array(),
								'q' 			=> array('cite' => array ()),
								'strong' 		=> array(),
								'ul' 			=> array(),
								'h1' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
								'h2' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
								'h3' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
								'h4' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
								'h5' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
								'h6' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ())
							);
							
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							$input[$option['id']] 		= force_balance_tags($input[$option['id']]); // find incorrectly nested or missing closing tags and fix markup
							$input[$option['id']] 		= wp_kses( $input[$option['id']], $allowed_html); // need to add slashes still before sending to the database
//							$valid_input[$option['id']] = addslashes($input[$option['id']]); ben commented this out because it was adding extra slashes
                                                        $valid_input[$option['id']] = $input[$option['id']];
						break;
					}
				break;
				
				case 'select':
					// check to see if the selected value is in our approved array of values!
					$valid_input[$option['id']] = (in_array( $input[$option['id']], $option['choices']) ? $input[$option['id']] : '' );
				break;
				
				case 'select2':
					// process $select_values
						$select_values = array();
						foreach ($option['choices'] as $k => $v) {
							// explode the connective
							$pieces = explode("|", $v);
							
							$select_values[] = $pieces[1];
						}
					// check to see if selected value is in our approved array of values!
					$valid_input[$option['id']] = (in_array( $input[$option['id']], $select_values) ? $input[$option['id']] : '' );
				break;
				
				case 'checkbox':
					// if it's not set, default to null!
					if (!isset($input[$option['id']])) {
						$input[$option['id']] = null;
					}
					// Our checkbox value is either 0 or 1
					$valid_input[$option['id']] = ( $input[$option['id']] == 1 ? 1 : 0 );
				break;
				
				case 'multi-checkbox':
					unset($checkboxarray);
					$check_values = array();
					foreach ($option['choices'] as $k => $v ) {
						// explode the connective
						$pieces = explode("|", $v);
						
						$check_values[] = $pieces[1];
					}
					
					foreach ($check_values as $v ) {		
						
						// Check that the option isn't null
						if (!empty($input[$option['id'] . '|' . $v])) {
							// If it's not null, make sure it's true, add it to an array
							$checkboxarray[$v] = 'true';
						}
						else {
							$checkboxarray[$v] = 'false';
						}
					}
					// Take all the items that were checked, and set them as the main option
					if (!empty($checkboxarray)) {
						$valid_input[$option['id']] = $checkboxarray;
					}
				break;
				
                            }
                        }
                }

                return $valid_input; // return validated input
}

/* ------------------------------------------------------------------------ *
 * Helper function for creating admin messages 
 * src: http://www.wprecipes.com/how-to-show-an-urgent-message-in-the-wordpress-admin-area 
 * ------------------------------------------------------------------------ */ 
/* 
 * @param (string) $message The message to echo 
 * @param (string) $msgclass The message class 
 * @return echoes the message 
 */ 

function onepix_show_msg($message, $msgclass = 'info') {  
    echo "<div id='message' class='$msgclass'>$message</div>";  
}

/* ------------------------------------------------------------------------ *
 * Callback function for displaying admin messages (error or success)
 * ------------------------------------------------------------------------ */ 
 /*
 * @return calls onepix_show_msg()
 */
function onepix_admin_msgs() {
	
	// check for our settings page - need this in conditional further down
	$onepix_settings_pg = strpos($_GET['page'], ONEPIX_PAGE_BASENAME);
	// collect setting errors/notices: //http://codex.wordpress.org/Function_Reference/get_settings_errors
	$set_errors = get_settings_errors(); 
	
	//display admin message only for the admin to see, only on our settings page and only when setting errors/notices are returned!	
	if(current_user_can ('manage_options') && $onepix_settings_pg !== FALSE && !empty($set_errors)){

		// have our settings succesfully been updated? 
		if($set_errors[0]['code'] == 'settings_updated' && isset($_GET['settings-updated'])){
			onepix_show_msg("<p>" . $set_errors[0]['message'] . "</p>", 'updated');
		
		// have errors been found?
		}else{
			// there maybe more than one so run a foreach loop.
			foreach($set_errors as $set_error){
				// set the title attribute to match the error "setting title" - need this in js file
				onepix_show_msg("<p class='setting-error-message' title='" . $set_error['setting'] . "'>" . $set_error['message'] . "</p>", 'error');
			}
		}
	}
}

// admin messages hook!
add_action('admin_notices', 'onepix_admin_msgs');


/* ------------------------------------------------------------------------ *
 * Sections callback function
 * ------------------------------------------------------------------------ */ 


function  onepix_section_fn($desc) {
    //echo "<p>" . __('Settings for this section','onepix_textdomain') . "</p>";
    echo "<p>" . __('','onepix_textdomain') . "</p>"; 
}

/* ------------------------------------------------------------------------ *
 * Form Fields HTML display  - All form field types share the same function!! 
 * ------------------------------------------------------------------------ */ 

function onepix_form_field_fn($args = array()) {  
      
    extract( $args );  
      
    // get the settings sections array  
    $settings_output    = onepix_get_settings();  
      
    $onepix_option_name = $settings_output['onepix_option_name'];  
    $options = get_option($onepix_option_name);  
      
    // pass the standard value if the option is not yet set in the database  
    if ( !isset( $options[$id] ) && 'type' != 'checkbox' ) {  
        $options[$id] = $std;  
    }  
      
    // additional field class. output only if the class is defined in the create_setting arguments  
    $field_class = ($class != '') ? ' ' . $class : '';  
      
      
    // switch html display based on the setting type.  
    switch ( $type ) {
        
        case 'general':  
            $options[$id] = stripslashes($options[$id]);  
            $options[$id] = esc_attr( $options[$id]);  
            echo "<input class='regular-text$field_class' type='text' id='$id' name='" . $onepix_option_name . "[$id]' value='$options[$id]' />";  
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
        break;  
        
        case 'text':  
            $options[$id] = stripslashes($options[$id]);  
            $options[$id] = esc_attr( $options[$id]);  
            echo "<input class='regular-text$field_class' type='text' id='$id' name='" . $onepix_option_name . "[$id]' value='$options[$id]' />";  
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
        break;
    
        case 'img':
            $options[$id] = stripslashes($options[$id]);
            $options[$id] = esc_attr($options[$id]);
            echo "<input class='regular-text$field_class media-upload-input custom_media_url' type='text' id='$id' name='" . $onepix_option_name . "[$id]' value='$options[$id]' />";
            echo "<input type='button' data-input-id='$id' id='$id" . "_button' value='Upload Image' class='button upload-media-btn' >";
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
        break;
    
        case 'color':
            $options[$id] = stripslashes($options[$id]);
            $options[$id] = esc_attr($options[$id]);
            //echo '<input type="text" name="cpa_settings_options[background]" value="' . $val . '" class="color-picker" >';
            
            echo "<input class='$field_class color-picker' type='text' id='$id' name='" . $onepix_option_name . "[$id]' value='$options[$id]' />";
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
        break;

        case "multi-text":  
            foreach($choices as $item) {  
                $item = explode("|",$item); // cat_name|cat_slug  
                $item[0] = esc_html__($item[0], 'onepix_textdomain');  
                if (!empty($options[$id])) {  
                    foreach ($options[$id] as $option_key => $option_val){  
                        if ($item[1] == $option_key) {  
                            $value = $option_val;  
                        }  
                    }  
                } else {  
                    $value = '';  
                }  
                echo "<span>$item[0]:</span> <input class='$field_class' type='text' id='$id|$item[1]' name='" . $onepix_option_name . "[$id|$item[1]]' value='$value' /><br/>";  
            }  
            echo ($desc != '') ? "<span class='description'>$desc</span>" : "";  
        break;  
          
        case 'textarea':  
            $options[$id] = stripslashes($options[$id]);  
            $options[$id] = esc_html( $options[$id]);  
            echo "<textarea class='textarea$field_class' type='text' id='$id' name='" . $onepix_option_name . "[$id]' rows='5' cols='50'>$options[$id]</textarea>";  
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";           
        break;  
          
        case 'select':  
            echo "<select id='$id' class='select$field_class' name='" . $onepix_option_name . "[$id]'>";  
                foreach($choices as $item) {  
                    $value  = esc_attr($item, 'onepix_textdomain');  
                    $item   = esc_html($item, 'onepix_textdomain');  
                      
                    $selected = ($options[$id]==$value) ? 'selected="selected"' : '';  
                    echo "<option value='$value' $selected>$item</option>";  
                }  
            echo "</select>";  
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";   
        break;  
          
        case 'select2':  
            echo "<select id='$id' class='select$field_class' name='" . $onepix_option_name . "[$id]'>";  
            foreach($choices as $item) {  
                  
                $item = explode("|",$item);  
                $item[0] = esc_html($item[0], 'onepix_textdomain');  
                  
                $selected = ($options[$id]==$item[1]) ? 'selected="selected"' : '';  
                echo "<option value='$item[1]' $selected>$item[0]</option>";  
            }  
            echo "</select>";  
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
        break;  
          
        case 'checkbox':  
            echo "<input class='checkbox$field_class' type='checkbox' id='$id' name='" . $onepix_option_name . "[$id]' value='1' " . checked( $options[$id], 1, false ) . " />";  
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
        break;  
          
        case "multi-checkbox":  
            foreach($choices as $item) {  
                  
                $item = explode("|",$item);  
                $item[0] = esc_html($item[0], 'onepix_textdomain');  
                  
                $checked = '';  
                  
                if ( isset($options[$id][$item[1]]) ) {  
                    if ( $options[$id][$item[1]] == 'true') {  
                        $checked = 'checked="checked"';  
                    }  
                }  
                  
                echo "<input class='checkbox$field_class' type='checkbox' id='$id|$item[1]' name='" . $onepix_option_name . "[$id|$item[1]]' value='1' $checked /> $item[0] <br/>";  
            }  
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
        break;  
    }  
}

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

?>