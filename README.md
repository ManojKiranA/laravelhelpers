# Useful Laravel Helper Classes and Methods

[![Packagist License](https://poser.pugx.org/manojkiran/aktiv/license)](http://choosealicense.com/licenses/mit/)
[![Latest Stable Version](https://poser.pugx.org/manojkiran/aktiv/v/stable)](https://packagist.org/packages/manojkiran/laravelhelpers)
[![Total Downloads](https://poser.pugx.org/manojkiran/aktiv/downloads)](https://packagist.org/packages/manojkiran/laravelhelpers)
[![Laravel5.8](https://img.shields.io/badge/Laravel-Framework-red.svg?style=flat)](https://www.laravel.com/)


This package contains the useful helper classes for laravel.

## Installation

You can install the package via composer:

```bash
composer require manojkiran/laravelhelpers
```
### HelperClasses Namespaces

LaravelHelper currently has the folowing classes . Instructions on how to use them in your own application are linked below.

| Class Name | Namespace |
| ------ | ------ |
| StringHelper | Manojkiran\LaravelHelpers\Helpers\StringHelper |
| ArrayHelper | Manojkiran\LaravelHelpers\Helpers\ArrayHelper |

## Usage

``` php

Route::get('between',function()
{    
    $res = StringHelper:: between('laravel','a','e');

    dd($res);
    //result will be  
    //rav
});
```

### Testing

``` bash
The package has not been tested yet
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email manojkiran10031998@gmail.com instead of using the issue tracker.

## Credits

- [Manojkiran.A](https://github.com/manojkiran)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).# laravelhelpers


### Todos

 - Add Array helpers class
 - Add Model helpers class
 - Add Model Scopes trait
 - Add Controllers trait

