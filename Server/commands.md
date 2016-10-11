netstat -lptn
locate fileName

# list all groups
cut -d: -f1 /etc/group 

# list users in group
groups groupName

# ad user Tony to group Developers
useradd -g developers tony

# Add existing user Tony to group ftp
usermod -a -G ftp tony

# Add user tony to primary group www
usermod -g www tony



