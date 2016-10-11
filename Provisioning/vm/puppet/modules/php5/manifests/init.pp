# Install PHP

class php5::install {
  package { [
    'php5',
    'php5-fpm',
    'php5-cli',
    'php-apc',
    'php5-common',
    #'libapache2-mod-php5',
    'php5-curl',
    'php5-dev',
    'php5-gd',
    'php5-imagick',
    'php5-mcrypt',
    'php5-memcached',
    'php5-mysql',
    'php5-xdebug'
  ]:
    ensure => present,
    before => File['/etc/php5/mods-available/xdebug.ini']
  }

  file { '/etc/php5/mods-available/xdebug.ini' :
    force => true,
    source  => '/vagrant/puppet/modules/php5/files/xdebug.ini',
    require => Package['php5'],
    notify => File['/etc/php5/fpm/conf.d/20-xdebug.ini']
  }

  file { '/etc/php5/fpm/conf.d/20-xdebug.ini':
    ensure => 'link',
    target => '/etc/php5/mods-available/xdebug.ini',
    force => true,
    require => Package['php5'],
    subscribe => File['/etc/php5/mods-available/xdebug.ini'],
  }
}