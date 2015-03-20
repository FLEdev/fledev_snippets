# sudo apt-get install drush
# cd DrupalRootFolder
# chmod 755 dinit
#./dinit


# Initialization of Drupal Folders, Folder access rights and additional modules


# Init folders

FILESDIRDEF="sites/default/files"

echo "Type Y to set the default user folder as /assets:"
read MESSAGEFD
if [ "$MESSAGEFD" == "Y" ] || [ "$MESSAGEFD" == "y" ]; then
	FILESDIR="assets"
else
	FILESDIR="sites/default/files"
fi

echo "Files folder set to: /$FILESDIR."

if [ ! -d "$FILESDIR" ]; then
  mkdir $FILESDIR
fi

# Drupal installation requires the default files directory
if [ $FILESDIR != $FILESDIRDEF ]; then
	mkdir $FILESDIRDEF;
fi


CONTRIBDIR="sites/all/modules/contrib"
if [ ! -d "$CONTRIBDIR" ]; then
  mkdir $CONTRIBDIR
fi


CUSTOMDIR="sites/all/modules/custom"
if [ ! -d "$CUSTOMDIR" ]; then
  mkdir $CUSTOMDIR
fi


LIBRDIR="sites/all/libraries"
if [ ! -d "$LIBRDIR" ]; then
  mkdir $LIBRDIR
fi

# / Init folders


# most used - must have modules:

# custom forms in drupal
drush dl webform
# placeholder - Token API (requested from several modules)
drush dl token
# Clean, speaking URL's
drush dl pathauto
# changing of literation characters (umlaute)
drush dl transliteration
# Chaos Tools (requested from several modules)
drush dl ctools
# Actualization of jQuery
drush dl jquery_update
# Sending HMTL formatted emails
drush dl htmlmail
# SMTP mail sending protocol
drush dl smtp
# Custom mail system for formatting and sending emails
drush dl mailsystem
# IMCE - File upload in textareas
drush dl imce
# IMCE + WYSIWYG integration
drush dl imce_wysiwyg
# Add CKEditor into the /library folder
drush dl wysiwyg
# Add internal links via autocomplete search
drush dl ckeditor_link
# Overlay - modal display of content
drush dl lightbox2
# development module
drush dl devel
# Views module
drush dl views
# Panels module
drush dl panels
# Rules module
drush dl rules
# Libraries API
drush dl libraries
# Backup and Migrate of Database
drush dl backup_migrate
# Administration menu
drush dl admin_menu
# Group and filter module via autocompletition
drush dl module_filter
# Field functionality extension
drush dl field_collection
drush dl field_group
# Entity API (requested from several modules)
drush dl entity
# Creating of menus from taxonomy structure
drush dl taxonomy_menu
# redirecting to source content and creating custom redirections
drush dl redirect
# Flag content to be internal and not be viewed otherwise
drush dl internal_nodes

# set access rights to the folders
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod 777 $FILESDIR

# at first installation drupal requires the default files folder (sites/default/files)
chmod 777 $FILESDIRDEF

SETTFILEDEF="sites/default/default.settings.php";
SETTFILE="sites/default/settings.php";
if [ ! -f "$SETTFILE" ]; then
  cp $SETTFILEDEF $SETTFILE;
  chmod 777 $SETTFILE;
fi

chmod 777 $SETTFILE;

echo "!!! If changed from $FILESDIRDEF, set this in: /admin/config/media/file-system. !!!";
echo "!!! In the end, set the .gitignore file to so it be syncronised with master branch !!!";