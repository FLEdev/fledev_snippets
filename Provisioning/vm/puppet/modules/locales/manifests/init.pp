class locales {
  package { "locales":
    ensure => latest,
  }
  file { "/etc/locale.gen":
    source  => '/vagrant/puppet/modules/locales/files/locales.gen',
    owner => "root",
    group => "root",
    mode => 644,
    require => Package[locales],
  }
  exec { "/usr/sbin/locale-gen":
    subscribe => File["/etc/locale.gen"],
    refreshonly => true,
    require => [ Package["locales"], File["/etc/locale.gen"] ],
    notify  => Exec['/usr/sbin/update-locale'],
  }
  exec { "/usr/sbin/update-locale":
    subscribe => File["/etc/locale.gen"],
    refreshonly => true,
    require => [ Package["locales"], File["/etc/locale.gen"] ]
  }
}