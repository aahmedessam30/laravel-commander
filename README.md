# Laravel Commander

![Laravel Commander](https://banners.beyondco.de/Laravel%20Commander.png?theme=light&packageManager=composer+require&packageName=ahmedessam%2Flaravel-commander&pattern=architect&style=style_1&description=Set+of+artisan+commands+to+help+you+manage+your+Laravel+projects+more+efficiently&md=1&showWatermark=1&fontSize=100px&images=code)

Laravel Commander is a Laravel package that provides a set of artisan commands to help you manage your Laravel projects more efficiently. It includes commands to help you manage your project's generate trait, enum, and more.

## Installation

You can install the package via Composer:

```bash
composer require ahmedessam/laravel-commander
```

The package will automatically register itself.

## Publishing the assets

After installing the package, you must publish the assets using the following command:

```bash
php artisan vendor:publish --tag=laravel-commander-traits
```

This command will publish the `Traits` directory to the `app` directory.

## Usage

To generate a new trait, run the following command:

```bash
php artisan make:trait
```

This command will create a new trait in the `app/Traits` directory.

To generate a new enum, run the following command:

```bash
php artisan make:enum
```

This command will create a new enum in the `app/Enums` directory.

To generate a new interface, run the following command:

```bash
php artisan make:contract
```

This command will create a new interface in the `app/Contracts` directory.

To generate a new service, run the following command:

```bash
php artisan make:service
```

if you want to generate a service for a specific model, you can pass the model name as an argument:

```bash
php artisan make:service <name> --model=<model>
```

This command will create a new service in the `app/Services` directory.

To generate a new repository, run the following command:

```bash
php artisan make:repository
```

This command will create a new repository in the `app/Repositories` directory.

To generate a new model scope, run the following command:

```bash
php artisan make:model-scope
```

This command will create a new model scope in the `app/Scopes` directory.

To generate a new facade, run the following command:

```bash
php artisan make:facade
```

This command will create a new facade in the `app/Facades` directory.

To generate a new data transfer object (DTO), run the following command:

```bash
php artisan make:dto
```

This command will create a new DTO in the `app/DataTransferObjects` directory.

To generate a new api crud, run the following command:

```bash
php artisan make:api-crud
```

This command will create a new api crud.

To generate a new notification channel, run the following command:

```bash
php artisan make:notification-channel
```

This command will create a new notification channel in the `app/Notifications/Channels` directory.

To generate a new notification channel message, run the following command:

```bash
php artisan make:channel-message
```

This command will create a new notification channel message in the `app/Notifications/Messages` directory.

To generate a new action class, run the following command:

```bash
php artisan make:action
```

This command will create a new action class in the `app/Actions` directory.

## Features

- Generate a new trait
- Generate a new enum
- Generate a new interface
- Generate a new service
- Generate a new repository
- Generate a new model scope
- Generate a new facade
- Generate a new data transfer object (DTO)
- Generate a new api crud
- Generate a new notification channel
- Generate a new notification channel message
- Generate a new action class

## Requirements

- PHP >= 7.4 or higher
- Laravel >= 7.0 or higher
- Composer

## License

The Laravel Commander is open-sourced software licensed under the [MIT license](https://opensource.org/license/MIT).

## Author

- **Ahmed Essam**
    - [GitHub Profile](https://github.com/aahmedessam30)
    - [Packagist](https://packagist.org/packages/ahmedessam/api-versionizer)
    - [LinkedIn](https://www.linkedin.com/in/aahmedessam30)
    - [Email](mailto:aahmedessam30@gmail.com)


## Contributing
Contributions are welcome! Please feel free to submit a Pull Request.

## Issues
If you find any issues with the package or have any questions, please feel free to open an issue on the GitHub repository.

Enjoy using Laravel Commander! 🚀
