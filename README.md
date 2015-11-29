# RandomLogger
Project to generate logs randomly and test __ELK__.

__Usage:__

_Option 1:_
```bash
php tasks/generate-log.php
```
This autogenerate logs in one of these three files:
 - /var/log/randomLogger/backoffice.log
 - /var/log/randomLogger/frontend.log
 - /var/log/randomLogger/negocio.log
 
_Option 2:_
```bash
php tasks/generate-log.php {type}
```
Where type can be backoffice, frontend or negocio.
 
_Tip:_
```bash
watch -n 1 "php tasks/generate-log.php"
```
To generate a log every second.

