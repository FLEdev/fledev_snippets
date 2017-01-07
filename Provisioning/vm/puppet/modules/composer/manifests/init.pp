class composer::install {

  package { "curl":
    ensure => installed,
    notify => Exec['composer'],
  }

  exec { 'composer':
    cwd         => '/home/vagrant',
    environment => ['COMPOSER_HOME=/home/vagrant'],
    command     => 'curl -sS https://getcomposer.org/installer | php && sudo mv composer.phar /usr/local/bin/composer',
    require     => [Package['curl']],
    logoutput   => 'on_failure',
    user        => 'vagrant'
  }
}