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

## Notes

Instead of using pure MVC, it uses the Service to keep the business logic centralized, atomic and scalable.

This demonstration has the following design patterns:
* Dependency Injection;
* Repository Pattern;

Included postman collection.

* * *

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>
