<?php
// Disable title in the blocks or leave it empty. Use that for
// instance to hide - disable block title. You still need to enter the Block description.
// <none>

// Link to the front:
// <front>

//  /login_page?destination=/node/241

// Define Panels layout location in your theme.info file:
// (The structure should look like: THEME/templates/layouts/YOUR_Panel_template)
# plugins[panels][layouts] = templates/layouts;

// Get certain setting from your current theme (if you extend your setting form, you
// can use the field key as identifier):
theme_get_setting('logo');

// get or set Drupal global variables:
variable_get('value_name', 'default_value-if_value_was_not_set');
variable_set('Value_name', 'value');

// Hide via css class element while building Theme - page.tpl.php (class can be used also elsewhere)
if ($hide_site_name) {
    print ' class="element-invisible"';
}

// create image attributes array
$img_arr = array('path' => $node->field_tsr_img[LANGUAGE_NONE][0]['uri'], 'attributes' => array('class' => array('nice_class', 'another_class'), 'alt' => 'Some ALT Text'));

// define the link properties
$tmp_link_arr = array('html' => TRUE, 'attributes' => array('target' => '_blank', 'title' => $link_title));
// building a html link based on the previous image html
l(theme_image($img_arr), '<front>', $tmp_link_arr, array('query' => array('val' => 'some_value')));

// create absolute external path
file_create_url($node->field_tsr_img[LANGUAGE_NONE][0]['uri']);

// create full internal path regarding internal server path
// like: "/var/www/html/sites/default/files/flv/video-eng.flv"
drupal_realpath($node->field_tsr_img[LANGUAGE_NONE][0]['uri']);

// create uri based on the folder and file name:
file_build_uri('img_folder/img_file.jpg');

// check if actual user is logged in
user_is_logged_in();

// include files
drupal_add_css(drupal_get_path('theme', 'THEMENAME') . '/some_file.css');
drupal_add_js(drupal_get_path('module', 'MODULENAME') . '/some_file.js');

/*
$GLOBALS['base_url'] => <a href="http://example.com/drupal">http://example.com/drupal</a>
base_path() => /drupal/
request_uri() => /drupal/documentation?page=1
request_path() => documentation
current_path() => node/26419
*/

// get system settings like from the theme .info file
global $theme;
dpm(system_get_info('theme', $theme));
// parsing a custom .info file:
drupal_parse_info_file($filename);


// Drupal Token select list key switch
function ModuleName_tokens_alter(array &$replacements, array $context){
    $tmpKeys = array_keys($replacements);
    if( $tmpKeys[0] == 'select_list_field_name' && $context['type'] == 'node'){
        $replacements = array('field_art_hline_color' => $context['data']['node']->select_list_field_name[LANGUAGE_NONE][0]['value']);
    }
}
