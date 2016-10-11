class mysql::install {

  $user = 'root'
  $password = 'root'

  package { [
    'mysql-client',
    'mysql-server',
  ]:
    ensure => installed,
  }

  exec { 'Set MySQL server\'s root password':
    subscribe   => [
      Package['mysql-server'],
      Package['mysql-client'],
    ],
    refreshonly => true,
    onlyif      => "mysqladmin -uroot -p${password} status",
    command     => "mysqladmin -uroot password ${password}",
    notify => Exec['create-root-external-access'],
  }

  exec { "create-root-external-access":
    path => ['/usr/bin','/usr/sbin','/bin','/sbin'],
    onlyif => "mysql -u$user -p$user vagrant",
    command => "mysql -u${user} -p${password} -e \"CREATE USER '${user}'@'%' IDENTIFIED BY '${password}'; GRANT ALL PRIVILEGES ON *.* TO '${user}'@'%' IDENTIFIED BY '${password}'; FLUSH PRIVILEGES;\"",
    user => $user,
    logoutput => "on_failure",
    require => Package['mysql-server'],
    notify => Exec['create-db'],
  }

  exec { "create-db":
    path => ['/usr/bin','/usr/sbin','/bin','/sbin'],
    onlyif => "mysql -u$user -p$user vagrant",
    command => "mysql -u${user} -p${password} -e \'CREATE DATABASE vagrant CHARACTER SET utf8 COLLATE utf8_general_ci; grant all on vagrant.* to $user@localhost identified by $user;\'",
    user => $user,
    logoutput => "on_failure",
    require => Package['mysql-server']
  }

  file {'/etc/mysql/my.cnf':
    force   => true,
    source  => '/vagrant/puppet/modules/mysql/files/etc/mysql/my.cnf',
    require => Package["mysql-server"],
  }

}