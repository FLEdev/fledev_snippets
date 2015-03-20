<?php

// local server for multiple developers
if(strstr('project.loc', $_SERVER['HTTP_HOST'])){
    // use absolute and not relative path
    $local_setting = array(
        'user1' => '/Users/admin/www/private/setting_local_project.php',
        'user2' => 'c:/xampp/hosts/private/setting_local_project.php',
    );
    $file_path = '';

    foreach($local_setting as $value){
        if (file_exists($value)) {
            $file_path = $value;
        }
    }
}
// stage server
elseif(strstr('dev.project.loc', $_SERVER ['SERVER_NAME'] )){
    $file_path = '/htdocs/username/private/dev_project.php';
}
// leave as last - default the production setting due it's highest importance
else{
    $file_path = '/usr/var/username/private/prod_project.php';
}
// checke if file exists
if(file_exists($file_path)){
    require_once($file_path);
}
else{
    echo ' The settings file couldn\'t be found for: ' . $_SERVER ['SERVER_NAME'];
}