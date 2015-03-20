Install XDebug on localhost

Call phpinfo(); and look for:
"This program makes use of the Zend Scripting Language Engine:

Zend Engine v2.4.0, Copyright (c) 1998-2013 Zend Technologies

with Xdebug v2.2.3, Copyright (c) 2002-2013, by Derick Rethans"
and also xdebug table: xdebug.remote_enable = On, xdebug.profiler_enable = On, xdebug.profiler_enable_trigger = On, xdebug.profiler_output_name = cachegrind.out.%t.%p, profiler_output_dir = "C:/www/log"
If you have different values, in your php.ini change those values to:
; XDEBUG Extension

zend_extension = "c:/wamp/bin/php/php5.4.16/zend_ext/php_xdebug-2.2.3-5.4-vc9.dll"
[xdebug]
xdebug.remote_enable = On
xdebug.profiler_enable = On
xdebug.profiler_enable_trigger = On
xdebug.profiler_output_name = cachegrind.out.%t.%p
xdebug.profiler_output_dir = "C:/www/log"

Restart your localhost to make effect of those changes.


In .htaccess:
php_value error_log /path/to/log/php_error.log
php_value xdebug.remote_host "localhost" or php_value xdebug.remote_host "fullyQuilifiedComputerName"

In Eclipse:
- Switch from ZendDebugger to XDebug in Preferences > PHP > Debug > PHP Debugger -> XDebug  and uncheck "Break at First Line"

Debug configuration (at PHP Web Application):
- Regarding your xdebug.remote_port setting in phpinfo() set the port.
- Add your Web page path which you want to debug and files that generating this page (mostly index.php)
