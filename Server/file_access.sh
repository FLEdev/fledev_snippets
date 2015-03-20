// CHMOD
// change to your Drupal root folder:
$ cd drupal_root_directory

// find everything of type directory and set mode to 755
$ find . -type d -exec chmod 755 {} \;

// find everything of type file and set mode to 644
$ find . -type f -exec chmod 644 {} \;

// switch to files folder
$ cd /sites/default/files

// set directories to be writable
$ find . -type d -exec chmod 777 {} \;



// CHOWN
// this is just an example, set your user and group and run it within the proper folder.
// don't use this command only if you are aware that the wrong files ownership is causing any issues

  $ find . -type f -exec chown user:group {} \;

  $ find . -type d -exec chown user:group {} \;

// or alternativelly outside the root folder recursivelly for files and folders:
  $ chmod -R user:group /drupal_root_folder