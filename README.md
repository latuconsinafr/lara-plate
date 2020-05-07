# lara-plate

lara-plate is a laravel boilerplate based on l5-repository which using repositories pattern as an abstraction to the database layer, for further information you might check http://andersao.github.io/l5-repository.

If you want to know a little more about the Repository pattern you might [read this great article](http://bit.ly/1IdmRNS).

There's also a postman collection you might want to take a look at [here](https://www.getpostman.com/collections/76458b2cb7d318b240b1).

## Table of Contents

- <a href="#laravel">Laravel</a>
- <a href="#installation">Installation</a>
- <a href="#authentication">Authentication</a>
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

## Others

- Currently the locale set to Indonesia with the timezone set Asia/Jakarta.
- The hash mechanism currently use the argon2id mechanism as [the Password Hashing Competition recommended the argon2 for hashing password](https://password-hashing.net/)
- The cors mechanism use the [fruitcake/laravel-cors](https://github.com/fruitcake/laravel-cors) package as the laravel-cors package allows you to send Cross-Origin Resource Sharing headers with Laravel middleware configuration.
- All other methods you might want to read available in [here](http://andersao.github.io/l5-repository) since all the methods used are based on l5-repository.

## License

The Laravel boilerplate is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
