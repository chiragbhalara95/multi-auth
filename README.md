composer create-project --prefer-dist laravel/laravel:^7.0 multi-auth

For install Auth:::
composer require laravel/ui:^2.4
php artisan ui vue --auth
npm install
npm run watch


php artisan make:model Permission -m
php artisan make:model Role -m

Change migration files

# create pivot tables
php artisan make:migration create_users_permissions_table --create=users_permissions

# create pivot tables
php artisan make:migration create_users_roles_table --create=users_roles

# create pivot tables
php artisan make:migration create_roles_permissions_table --create=roles_permissions

php artisan migrate

Create this file
App/Permissions/HasPermissionsTrait.php

And Use traint User Model
use HasPermissionsTrait; //Import The Trait


Make provider 
php artisan make:provider PermissionsServiceProvider
Added provider into Config/App.php

'providers' => [

        App\Providers\PermissionsServiceProvider::class,
    
 ],


 #SetUp Middleware

 php artisan make:middleware RoleMiddleware
Now we have to register this RoleMiddleware. So add this following code to register it.
App\Http\Kernel.php

protected $routeMiddleware = [
    .
    .
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];


create route


$user = $request->user();
dd($user->hasRole('developer')); //will return true, if user has role
dd($user->givePermissionsTo('create-tasks'));// will return permission, if not null
dd($user->can('create-tasks')); // will return true, if user has permission





If you Remov e register then
Auth::routes(['register' => false]);




https://www.laravelcode.com/post/laravel-7-user-roles-and-permissions-tutorial-without-packages