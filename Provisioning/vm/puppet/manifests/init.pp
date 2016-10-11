exec { 'apt-get update':
  command => '/usr/bin/apt-get update --fix-missing',
  path => '/usr/bin',
}


/*
exec { 'set HOME':
  command => 'env HOME=/home/vagrant',
  path => '/usr/bin'
}*/

/*
user { 'vagrant':
  ensure     => 'present',
  managehome => true,
  home        => '~'
}*/

Exec { path => [ "/bin/", "/sbin/" , "/usr/bin/", "/usr/sbin/", "/usr/local/bin", "/usr/local/sbin", "/usr/local/bin/composer", "~/.composer/vendor/bin/" ] }

include locales
class { 'git::install': }
#class { 'apache2::install': }
class { 'nginx::install': }
class { 'php5::install': }
class { 'composer::install': }
class { 'memcached::install': }
class { 'mysql::install': }
#class { 'wp-cli::install': }


























