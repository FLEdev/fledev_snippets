<?php

// strstr - string in string search
$email = '<a href="mailto:name@example.com">name@example.com</a>';
$domain = strstr($email, '@');
echo $domain; // prints @example.com

// string crop - substr
substr("abcdef", -3, 2); // returns "cd"

// in_array - search for a value in array:
$os = array("Mac", "NT", "Irix", "Linux");
if (in_array("Irix", $os)) {
    echo "Irix enthalten";
}

// get all array keys as array with values
array_keys($array);

// get first item of an array:
current($yourArray);

//Parse the path of a file
print_r( pathinfo('/www/htdocs/inc/lib.inc.php') );

// Parse time based on specified pattern - time
date_parse_from_format("D, m/d/Y - H:i", $custom_date);

// Format the filesize:
function formatbytes($file, $type){
    switch($type){
        case "KB":
            $filesize = filesize($file) * .0009765625; // bytes to KB
            break;
        case "MB":
            $filesize = (filesize($file) * .0009765625) * .0009765625; // bytes to MB
            break;
        case "GB":
            $filesize = ((filesize($file) * .0009765625) * .0009765625) * .0009765625; // bytes to GB
            break;
    }
    if($filesize <= 0){
        return $filesize = 'unknown file size';}
    else{return round($filesize, 2).' '.$type;}
}

echo formatbytes("$_SERVER[DOCUMENT_ROOT]/images/large_picture.jpg", "MB");
