Install Behat and Mink on Linux

$ mkdir /opt/behat

$ cd /opt/behat/

$ nano composer.json
Paste:
{

    "require": {

        "behat/behat": "2.4.*@stable",

        "behat/mink": "1.5.*@stable",

        "behat/mink-extension": "*",

        "behat/mink-goutte-driver": "*",

        "behat/mink-selenium2-driver": "*"

    },

    "minimum-stability": "dev",

    "config": {

        "bin-dir": "bin/"

    }

}
$ composer install
$ ln -s /opt/behat/bin/behat /usr/local/bin/behat
$ behat --version

Go to your project directory and initiate behat with:
$ behat --init