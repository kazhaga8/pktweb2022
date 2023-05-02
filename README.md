# Release Version

## File to change

`.env`
```php
/** line 5 */

APP_BASE_PATH=/pkt-2022

to

APP_BASE_PATH=/
```



`/public/plugins/responsivefilemanager/filemanager/config/config.php`

```php
/** line 72 */

'base_url' => ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http"). "://". @$_SERVER['HTTP_HOST']. "/pkt-2022",

to

'base_url' => ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http"). "://". @$_SERVER['HTTP_HOST']. "/",
```

## File permission

`CHMOD -R 777 storage/`
