include profile::base
include profile::webserver
include profile::database

application::zf2 { "local.republicofgoodhope.org":
}

mysql::grant { 'rgh':
  mysql_user => 'rgh',
  mysql_password => 'rgh',
}
