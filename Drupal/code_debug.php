<?php
// To show the array structure
echo '<pre>';
print_r($yourArray);

// or show array with the value types
var_dump($showValueAndItsType_Lenght);
echo '</pre>';


//

function debug_arr($arr, $add_info = '') {
    ob_start();
    print_r($arr);
    $arr_to_str = ob_get_contents();
    ob_end_clean();
    watchdog('module_debug', '%add_info: <pre> %arr_to_string </pre>', array('%arr_to_string' => $arr_to_str, '%add_info' => $add_info), WATCHDOG_DEBUG);
    return (TRUE);
}


// Output a message like drupal_set_message();

dvm($arr_variable);
// Output the content on top of the page

dpr($arr_variable);

// drupal debug - export output into text file within /tmp folder
dd();