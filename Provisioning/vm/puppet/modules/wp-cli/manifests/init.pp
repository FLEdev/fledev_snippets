class wp-cli::install {
  file { '/usr/local/bin/wp':
    source  => '/vagrant/puppet/modules/wp-cli/files/wp-cli.phar',
    mode => 0755
  }
}