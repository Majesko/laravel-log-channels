# Library for organization pseudo logging channels in laravel 5.1+ applications
## Installation steps
1. Add to composer requre section "majesko/logger": "~1.0.0"
2. Publish config file with command php artisan vendor:publish --tag="logger"
3. Uncomment or needed channels in logger.php


## Useful parameters
"app_tag" is used to tag source of logs, for example in elasticsearch

"global" uses to mark application-wide log channels 

##Handler variants:

"StreamWrapper" is for single file logs

"RotatingFileWrapper" is for per-day logs, so you need to configure rotation options
## Formatters
Logger use plain monolog [formatters](https://github.com/Seldaek/monolog/blob/master/doc/02-handlers-formatters-processors.md#formatters)

