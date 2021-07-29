# lara-plate

lara-plate is a laravel boilerplate based on l5-repository which using repositories pattern as an abstraction to the database layer, for further information you might check http://andersao.github.io/l5-repository.

If you want to know a little more about the Repository pattern you might [read this great article](http://bit.ly/1IdmRNS).

There's also a postman collection you might want to take a look at [here](https://documenter.getpostman.com/view/2216502/TzscqnCs).


## Table of Contents

- <a href="#laravel">Laravel</a>
- <a href="#installation">Installation</a>
- <a href="#authentication">Authentication</a>
- <a href="#helpers">Helpers</a>
- <a href="#authorization">Authorization</a>
- <a href="#others">Others</a>
- <a href="#license">Lincese</a>


## Laravel

This repository built on laravel 6.x version. For further information you might read the laravel 6.x documentation https://laravel.com/docs/6.x.


## Installation

You might download the repository as a zip or clone the repository using git clone command via https.

```
git clone https://github.com/latuconsinafr/lara-plate.git
```

Then move to the directory,

```
cd lara-plate
```

Install all the dependencies,

```
composer install
```

Copy the .env,

```
cp .env.example .env
```
Then set the configuration all of the .env variables as you want to.

Generate the jwt secret key

```
php artisan jwt:secret
```
Eventually, all set, you're ready to go.


## Authentication

This repository currently applied json web token authentication for laravel & lumen by tymon, you can find the repository [here](https://github.com/tymondesigns/jwt-auth) or the complete docs [here](https://jwt-auth.readthedocs.io/en/develop/).

The basic authentication is already registered in `routes/api.php` which correspond to AuthenticationController with 3 main endpoints:
- `/login` to handle user log-in
- `/logout` to handle user log-out and invalidate the active token
- `/register` to handle user registration with auto_login option available via query params `auto_login`
    
The authentication guard itself currently applied to `/users` endpoint using `auth.jwt` middleware inside `routes/api.php` as it shown below.

```
/* With Auth */
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::resource('users', UsersController::class);
});
```

## Helpers

This repository currently applied helper with the help of helpers package by brown, you can find the repository [here](https://github.com/browner12/helpers).

The application is already provided with a helper called GlobalVariableHelper in `app/Helpers`. This helper would help you to call a specified variable across the application. For example, to simply get a list of roles used in the application, you can call the `getApplicationRoles()` function anywhere.

```
/* Define roles */
$roles = getApplicationRoles();
```

## Authorization

Authorization which is related to roles and permissions is currently provided built-in with the help of a spatie package called laravel-permission, you can find the repository [here](https://github.com/spatie/laravel-permission). All settings and configurations are default, following the docs [here](https://spatie.be/docs/laravel-permission/v4/introduction).

By default the authorization is currently applied in UsersController using middleware as it shown below.

```
/* Permission middleware */
$this->middleware('permission:' . getApplicationPermission('super-admin')) // By default super-admin can do literally anything
    ->only([
        'index',
        'store',
        'show',
        'edit',
        'update',
        'destroy'
    ]);
```

## Others

- Currently the locale set to Indonesia with the timezone set Asia/Jakarta.
- The hash mechanism currently use the argon2id mechanism as [the Password Hashing Competition recommended the argon2 for hashing password](https://password-hashing.net/)
- The cors mechanism use the [fruitcake/laravel-cors](https://github.com/fruitcake/laravel-cors) package as the laravel-cors package allows you to send Cross-Origin Resource Sharing headers with Laravel middleware configuration.
- All other methods you might want to read available in [here](http://andersao.github.io/l5-repository) since all the methods used are based on l5-repository.

## License

The lara-plate boilerplate is open-sourced boilerplate licensed based on Laravel software, under the [MIT license](https://opensource.org/licenses/MIT).
