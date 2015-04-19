Extract the latest version of CKeditor into the libraries folder so that you get the following structure: /sites/all/libraries/ckeditor/config.js

Change the header of sites/all/libraries/ckeditor/ckeditor.js to:

/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or <a href="http://ckeditor.com/license">http://ckeditor.com/license</a>
  version:'CKEditor 4.3.1 SVN',revision:'70d9474ad0'
*/

// !!! this is for CKEditor 4.3.1 and jQuery 1.7


// After this you can enable CKeditor within the WYSIWYG settings - admin/config/content/wysiwyg

To remove the bottom help link, use the following code within your theme:
```php
function THEMENAME_filter_tips_more_info() {
  return '';
}
```

