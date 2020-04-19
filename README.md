# LaravelEmailTemplate
This is a laravel package that allows to configure email templates and update them through the admin panel

requirements:
    laravel 5.5 and above

## Instructions
#### Step 1: Installation
Install the package using composer
```bash
composer require alliance/laravel-email-template
```

#### Step 2: Configuration
Go to your laravel resources folder and create a folder that will contain your email
```bash
cd resources/views
mkdir -p email-template/template1 email-template/template2
```

Publish package files. Run the following command
```bash
php artisan vendor:publish
```

Open the config file and add your configurations
```bash
vim app/config/laravelemailtemplate.php
```

Schedule your laravel app to run the extract command every minute
```bash
vim app/Console/Kernel.php
```

Inside the `schedule()` function. Add the following line.

`$schedule->command('laravelemailtemplate:extract')->everyMinute()`

For more details on scheduling. Check [laravel documentation](https://laravel.com/docs/5.5/scheduling)

## Usage
Every email you want to allow the admin to update, you have to add it to the config file.

The config example:
```php
return [
    // ... some configs
    templates => [
        [
            "name" => "template1", // template name
            "variables" => ["variable1", "variable2"], // available placeholders to be considered for the template
            "folder" => "email-template/template1", // path inside resources/views, NB: Each Template must have its own folder
            "entry_file" => "template.php" 
        ]
    ],
    // ... more configs
];

```