# Install Apache

class apache2::install {

  File {
    ensure  => file,
    owner   => 'root',
    group   => 'root',
    mode    => '0644',
    require => Package['apache2'],
    notify  => Service['apache2'],
  }
  package { 'apache2':
    ensure => present,
  }->

  service {'apache2':
    ensure => "running",
    enable => "true",
    require => Package["apache2"],
  }
  #file { '/etc/apache2/conf-enabled/user.conf':
  #  ensure => link,
  #  target => '/etc/apache2/conf-available/user.conf',
  #}

  #file { '/etc/apache2/mods-enabled/userdir.load':
  #  ensure => 'link',
  #  target => '/etc/apache2/mods-available/userdir.load',
  #  notify => Service["apache2"],
  #  require => Package["apache2"],
  #}

  #file { '/etc/apache2/mods-enabled/userdir.conf':
  #  ensure => 'link',
  #  target => '/etc/apache2/mods-available/userdir.conf',
  #  notify => Service["apache2"],
  #  require => Package["apache2"],
  #}

  file {'/etc/apache2/mods-available/php5.conf':
    source  => '/vagrant/puppet/modules/apache2/files/etc/apache2/mods-available/php5.conf',
    require => Package["apache2"],
  }

  file { '/etc/apache2/sites-available/default.conf':
    source  => '/vagrant/puppet/modules/apache2/files/etc/apache2/sites-available/default.conf',
    notify => File['/etc/apache2/sites-enabled/000-default'],
    require => Package['apache2']
  }
  file { '/etc/apache2/sites-enabled/000-default':
    ensure  => absent,
    force   => true,
    recurse => true,
    require => Package['apache2'],
    notify => File['/etc/apache2/sites-enabled/default.conf']
  }

  file { '/etc/apache2/sites-enabled/default':
    ensure  => absent,
    force   => true,
    recurse => true,
    require => Package['apache2'],
  }
  file { '/etc/apache2/sites-available/default':
    ensure  => absent,
    force   => true,
    recurse => true,
    require => Package['apache2'],
  }
  file { '/etc/apache2/sites-enabled/default.conf':
    ensure  => link,
    target  => '/etc/apache2/sites-available/default.conf',
    require => Package['apache2'],
    notify  => File['/etc/apache2/mods-available/rewrite.load']
  }

  file { '/etc/apache2/mods-available/rewrite.load':
    source  => '/vagrant/puppet/modules/apache2/files/etc/apache2/mods-available/rewrite.load',
    require => Package['apache2'],
    notify  => File['/etc/apache2/mods-enabled/rewrite.load']
  }
  file { '/etc/apache2/mods-enabled/rewrite.load':
    ensure  => link,
    target  => '/etc/apache2/mods-available/rewrite.load',
    require => Package['apache2'],
    notify => Service["apache2"],
  }


}
