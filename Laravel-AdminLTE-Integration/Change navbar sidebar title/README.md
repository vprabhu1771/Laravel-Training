To change the "AdminLTE 3" name in the sidebar of your Laravel application using the
`jeroennoten/laravel-adminlte` package, you need to modify the configuration file `config/adminlte.php`.

```php
'logo' => '<b>Admin</b>LTE',
```

# To

```php
'logo' => env('APP_NAME', 'School ERP'),
```