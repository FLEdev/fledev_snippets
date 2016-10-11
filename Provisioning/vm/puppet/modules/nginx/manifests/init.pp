# Install NGINX

class nginx::install {

  /*
  service {'apache2':
    ensure => "stopped",
    enable => "false",
    before =>  Service["nginx"],
  }
  */

  exec { "stop-apache2":
    command     => "service apache2 stop",
    onlyif      => "service apache2 status",
    user        => 'root',
    before      => [Package["nginx"],Service["nginx"]]
  }

  exec { "restart-nginx":
    command     => "service nginx restart",
    onlyif      => "service nginx status",
    user        => 'root',
    require     => File["/etc/nginx/sites-enabled/default.conf"],
  }

  File {
    ensure  => file,
    owner   => 'root',
    group   => 'root',
    mode    => '0644',
  }
  package { 'nginx':
    ensure => present,
  }->

  service {'nginx':
    ensure => "running",
    enable => "true",
    require => Exec['stop-apache2'],
    notify => File['/etc/nginx/sites-available/default']
  }


  file { '/etc/nginx/sites-available/default':
    source  => '/vagrant/puppet/modules/nginx/files/etc/nginx/sites-available/default',
    notify => File['/etc/nginx/sites-enabled/default'],
    require => Package['nginx']
  }

  file { '/etc/nginx/sites-enabled/default':
    ensure  => absent,
    force   => true,
    recurse => true,
    require => Package['nginx'],
  }
  file { '/etc/nginx/sites-enabled/default.conf':
    ensure  => link,
    target  => '/etc/nginx/sites-available/default',
    require => Package['nginx'],
  }

}
