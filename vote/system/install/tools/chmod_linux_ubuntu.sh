#/bin/bash
sudo find ./ -type f -exec chmod 644 {} \;
sudo find ./ -type d -exec chmod 755 {} \;

  echo "напишите путь до директории system пример:[/var/www/vote/system]";
  read logAccess;
  if test -z $logAccess; then 
    logAccess='/var/www/'; 
  fi;
  chmod -R 777 $logAccess/log 
  chmod -R 777 $logAccess/cache
  chmod -R 777 $logAccess/config
