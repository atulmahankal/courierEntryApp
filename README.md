# Create Laravel Project

Before creating your first Laravel project, you should ensure that your local machine has PHP and [Composer](https://getcomposer.org/) installed. If you are developing on macOS, PHP and Composer can be installed via [Homebrew](https://brew.sh/). In addition, we recommend [installing Node and NPM](https://nodejs.org/).

After you have installed PHP and Composer, you may create a new Laravel project via the Composer create-project command:

```bash
composer create-project laravel/laravel laravel-adminlte-app
```

Or, you may create new Laravel projects by globally installing the Laravel installer via Composer:

```bash
composer global require laravel/installer

laravel new laravel-adminlte-app
```

Now move to Project directory

```bash
cd laravel-adminlte-app
```

# Change Application Settings

```bash
sed -i "s/'timezone' => 'UTC',/'timezone' => env('App_Timezone', 'UTC'),/g" config/app.php
```

# Envirnment Settings

```bash
sed -i "6 i App_Timezone='Asia/Kolkata'" .env
sed -i 's/DB_DATABASE=.*/DB_DATABASE=Laravel/g' .env
sed -i 's/DB_PASSWORD=/DB_PASSWORD=password/g' .env
sed -i 's/APP_URL=http:\/\/localhost/APP_URL=http:\/\/localhost:8000/g' .env
sed -i 's/LOG_CHANNEL=.*/LOG_CHANNEL=daily/g' .env
```

# MySQL settings

```bash
sed -i '6 i use Illuminate\\Support\\Facades\\Schema;' app/Providers/AppServiceProvider.php
sed -i '7 i use Illuminate\\Pagination\\Paginator;' app/Providers/AppServiceProvider.php
sed -i '29 i \\t\tSchema::defaultstringLength(191);' app/Providers/AppServiceProvider.php
sed -i '30 i \\t\tPaginator::useBootstrap();' app/Providers/AppServiceProvider.php

sed -i "s/'charset' => 'utf8mb4',/'charset' => 'utf8',/g" config/database.php
sed -i "s/'collation' => 'utf8mb4_unicode_ci',/'collation' => 'utf8_unicode_ci',/g" config/database.php
sed -i "s/'engine' => .*,/'engine' => 'InnoDB',/g" config/database.php
```

# Disable cache

```bash
sed -i "s/];/    'cache' => false,\n];/g" config/view.php
```

# Install laravolt/avatar for Text avatar

```bash
composer require laravolt/avatar
php artisan vendor:publish --provider="Laravolt\Avatar\ServiceProvider"
```

### Install laravel/ui repository

```bash
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run build
```

### Install almasaeed2010/adminlte repository

```bash
composer require "almasaeed2010/adminlte=~3.2"
```

copy assets to public folder

```bash
mkdir -p public/vendor/adminlte
cp -r vendor/almasaeed2010/adminlte/dist/* public/vendor/adminlte
cp -r vendor/almasaeed2010/adminlte/plugins/* public/vendor
```

<!--
# Install jetstream with livewire

```bash
composer require laravel/jetstream
php artisan jetstream:install livewire
```

# Configure jetstream and fortify

```bash
sed -i 's/\/\/ Features::profilePhotos(),/Features::profilePhotos(),/g' config/jetstream.php
sed -i 's/Features::accountDeletion(),/\/\/ Features::accountDeletion(),/g' config/jetstream.php
```

# Changes in views

```bash
sed -i "s/<title>.*<\\/title>/<title>@yield('title',ucfirst(explode('.', trim(Route::currentRouteName()))[0])) : {{ ucfirst(config('app.name', 'Laravel')) }}<\\/title>/g" resources/views/welcome.blade.php
sed -i "s/<title>.*<\\/title>/<title>@yield('title',ucfirst(explode('.', trim(Route::currentRouteName()))[0])) : {{ ucfirst(config('app.name', 'Laravel')) }}<\\/title>/g" resources/views/layouts/guest.blade.php
sed -i "s/<title>.*<\\/title>/<title>@yield('title',ucfirst(explode('.', trim(Route::currentRouteName()))[0])) : {{ ucfirst(config('app.name', 'Laravel')) }}<\\/title>/g" resources/views/layouts/app.blade.php
```

# Skip table if already exists

```bash
sed -i '16 i \\t\tif(Schema::hasTable("users")) return;' database/migrations/2014_10_12_000000_create_users_table.php
sed -i '16 i \\t\tif(Schema::hasTable("password_resets")) return;' database/migrations/2014_10_12_100000_create_password_resets_table.php
sed -i '16 i \\t\tif(Schema::hasTable("failed_jobs")) return;' database/migrations/2019_08_19_000000_create_failed_jobs_table.php
sed -i '16 i \\t\tif(Schema::hasTable("personal_access_tokens")) return;' database/migrations/2019_12_14_000001_create_personal_access_tokens_table.php
sed -i '16 i \\t\tif(Schema::hasTable("sessions")) return;' $(find database/migrations -path '*_create_sessions_table.php' -type f)
```
-->

<!--
# Add AdminLTE templates from node

```bash
npm install --save-dev admin-lte

sed -i "3 i const copy = require('fs-extra').copy;" vite.config.js

sed -i 's/plugins: \[/plugins: \[\
        copy("node_modules\/admin-lte\/dist","public\/dist"),\
        copy("node_modules\/admin-lte\/plugins","public\/plugins"),\
        copy("node_modules\/\@fortawesome","public\/plugins\/fontawesome-free"),/g' vite.config.js
mkdir -r 'public/plugins'
npm run build
```
-->

<!--
### Install jeroennoten/laravel-adminlte repository
required laravel/ui

[Read Documentation](https://github.com/jeroennoten/Laravel-AdminLTE/wiki)

```bash
composer require jeroennoten/laravel-adminlte
php artisan adminlte:install --type=basic --with=main_views --with=basic_views --with=basic_routes
```

### Install AdminLTE plugins

```bash
php artisan adminlte:plugins install --force
```

### Configuring AdminLTE

```bash
sed -i "s/'usermenu*header' => .*,/'usermenu*header' => true,/g" config/adminlte.php
sed -i "s/'usermenu_image' => .*,/'usermenu*image' => true,/g" config/adminlte.php
sed -i "s/'layout_fixed_sidebar' => .*,/'layout*fixed_sidebar' => true,/g" config/adminlte.php
sed -i "s/'layout_fixed_navbar' => .*,/'layout*fixed_navbar' => true,/g" config/adminlte.php
sed -i "s/'right_sidebar_theme' => .*,/'right*sidebar_theme' => 'light',/g" config/adminlte.php
sed -i "s/'dashboard_url' => 'home',/'dashboard_url' => '\/',/g" config/adminlte.php
sed -i "s/'profile_url' => .*,/'profile_url' => 'user\/profile',/g" config/adminlte.php
sed -i "s/'text' => 'pages',/'text' => 'Dashboard',/g" config/adminlte.php
sed -i "s/'url' => 'admin\/pages',/'url' => 'dashboard',/g" config/adminlte.php
sed -i "s/'url' => 'admin\/settings'/'url' => 'user\/profile'/g" config/adminlte.php
sed -i "s/'livewire' => false,/'livewire' => true,/g" config/adminlte.php
sed -i "s/password\/reset/forgot-password/g" config/adminlte.php

```

### Role base menu

[Read Help](https://github.com/jeroennoten/Laravel-AdminLTE/issues/438)

### View changes for AdminLTE

```bash
sed -i 's/class User extends Authenticatable/use Laravolt\\Avatar\\Avatar;\
use Illuminate\\Support\\Facades\\Auth;\
\
class User extends Authenticatable/g' app/Models/User.php

sed -i '$i \
\
    public function adminlte_image(){\
        return $this->profile_photo_url;\
\
        $avatar = new Avatar();\
        return $avatar->create(Auth::user()->name)->toBase64();\
    }\
' app/Models/User.php


sed -i '34 i \
        \<style\> \
            .nav-sidebar>.nav-item .nav-icon * {\
                margin-left: 0.05rem;\
                font-size: 1.2rem;\
                margin-right: 0.2rem;\
                text-align: center;\
                width: 1.6rem;\
            }\
\
            .nav-sidebar .menu-open > .nav-link svg.right,\
            .nav-sidebar .menu-open > .nav-link i.right,\
            .nav-sidebar .menu-is-opening > .nav-link svg.right,\
            .nav-sidebar .menu-is-opening > .nav-link i.right {\
                -webkit-transform: rotate(-180deg);\
                transform: rotate(-180deg);\
            }\
\
            .navbar-nav>.user-menu .user-image,\
            .user-header>img {\
                display:unset !important;\
            }\
        \<\/style\>' resources/views/vendor/adminlte/master.blade.php

sed -i "s/fa-angle-left/fa-angle-down/g" resources/views/vendor/adminlte/partials/sidebar/menu-item-treeview-menu.blade.php
sed -i 's/alt="{{ Auth::user()->name }}"/alt="Profile Photo"/g' resources/views/vendor/adminlte/partials/navbar/menu-item-dropdown-user-menu.blade.php

echo "@extends('adminlte::auth.login')" > resources/views/auth/login.blade.php
echo "@extends('adminlte::auth.register')" > resources/views/auth/register.blade.php
echo "@extends('adminlte::auth.verify')" > resources/views/auth/verify-email.blade.php
echo "@extends('adminlte::auth.passwords.confirm')" > resources/views/auth/confirm-password.blade.php
echo "@extends('adminlte::auth.passwords.email')" > resources/views/auth/forgot-password.blade.php
echo "@extends('adminlte::auth.passwords.reset')" > resources/views/auth/reset-password.blade.php
``` -->

# Migrate database

```bash
php artisan migrate
```

# Start app

```bash
php artisan serve
```
# Install livewire
```bash
composer require livewire/livewire
php artisan livewire:publish --config
php artisan livewire:publish --assets
```



<!--
# Add laravel-activitylog

[Read Documentation](https://spatie.be/docs/laravel-activitylog/v4/introduction)

# Add Laravel-permission

[Read Documentation](https://spatie.be/docs/laravel-permission/v5/introduction)

# Add Ideal Timeout

# Add laravel-excel

[Read Documentstion](https://docs.laravel-excel.com/3.1/imports/)

# Add Notifier

# Add Datatable

# Add Parsley.js
-->


<!--
# Change Application Settings

> config/app.php

```text
'timezone' => env('App_Timezone', 'UTC'),
```

> .env

```text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

# Alteration MySQL settings

> app/Providers/AppServiceProvider.php

```text
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
	    public function boot()
    {
        //
		Schema::defaultstringLength(191);
		Paginator::useBootstrap();
    }
}
```

> config/database.php

```text
'charset' => 'utf8',
'collation' => 'utf8_unicode_ci',
'engine' => 'InnoDB',
```

# Disable cache

> config/view.php

```text
'cache' => false,
```
-->