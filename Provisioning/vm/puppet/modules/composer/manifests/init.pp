# Install composer

class composer::install {

  package { "curl":
    ensure => installed,
  }

  exec { "composer-home":
    command  => 'env COMPOSER_HOME="/home/vagrant"; env HOME="/home/vagrant"',
    path => '/usr/bin',
  }

  /*file { "/etc/profile.d/home_export.sh":
    content => 'export COMPOSER_HOME="/home/vagrant"'
  }*/

  exec { 'install composer':
    command => 'curl -sS https://getcomposer.org/installer | php && sudo mv composer.phar /usr/local/bin/composer',
    require => [Package['curl'] , Exec['composer-home']],
  }

}