# server socket setup failed, retry 1: spamd: could not create IO::Socket::INET6 socket on [::1]:784: Cannot assign requested address

sudo nano /etc/default/spamassassin
#OPTIONS="--create-prefs --max-children 5 --helper-home-dir"
OPTIONS="--ipv4-only -d 127.0.0.1 -p 784 --create-prefs -x --max-children 5 --helper-home-dir"

