## Requirements
* Docker
* Makefile (optional)

## Installation

Run the commands: `make build-setup`

* * *

## Schemas

### Docker Setup Schema

```
├── .docker
│   ├── app
│   │    ├── docker-xdebug.ini
│   │    └── Dockerfile
│   └── nginx
│       ├── conf.d
│       │   └── app.conf
│       └── Dockerfile
├── .env
├── docker-compose.yml
└── Makefile
```

* * *

### Application schema
```

├── app
│	├── Enums
│	├── Http
│	│	└── Controllers
│	│		└── UserController
│	├── Models
│	│	└── ExternalUserModel
│	├── Providers
│	│	├── RepositoriesServiceProvider
│	│	└── ServicesProvider
│	├── Repositories
│	│	├── ExternalUserRepository
│	│	│	├── ExternalUserRepository
│	│	│	└── ExternalUserRepositoryInterface
│	│	└── Repository
│	└── Services
│		└── UserService
│			├── UserService
│			└── UserServiceInterface
└── config
	├── chunk
	└── csv
```
* * *

## Tests

Run the commands: `make test`

* * *

## Notes

This demonstration has the following design patterns:
* Dependency Injection;
* Repository Pattern;

Regarding the storage that might change. If needed, we can create/change to different driver.

See below the steps:
* In the config/filesystems, add the new driver. (ie: s3, represents a S3 bucket)
* On UserService, in the storeFile method: change the disk name to the new one. 


Included postman collection.

* * *

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>
