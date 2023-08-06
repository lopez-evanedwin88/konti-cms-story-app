# Konti-CMS Project by Docker(Laravel & Nuxt)

Well tested on macOS ventura 13.0

## 🍬 Stack includes

* API
  * Laravel (latest version)
  * Octane / PHP-FPM
  * PostgreSQL (and separate database for testing)
  * Redis
* Client
  * Nuxt 3 (latest version)
* Gateway
  * Nginx (as reverse-proxy)
  * Certbot

## 📜 Introduction

The project is just separate pre-configured Laravel and Nuxt applications


## ⚙ Installation

Clone or download the repository and enter its directory:

```bash
git clone https://github.com/nevadskiy/laravel-nuxt-docker.git app
cd app
```

### API

#### Quick installation

```bash
cd api
./install
```

> Migrate data in database
```
make migrate
```

> Run seeders (optional)
```
make db.seed
```

API's can be access through this url `http://localhost:8000/api`.

> To display all api routes

```
make route.list
```

This will install and run a fresh new Laravel app which will be available on `http://localhost:8000`.

#### Advanced installation

Read more about an [advanced API installation](./api/DOCUMENTATION.md).

### Client

#### Quick installation

```bash
cd client
./install
```

This will install and run a fresh new Nuxt 3 app which will be available on `http://localhost:3000`.

#### Advanced installation

Read more about an [advanced client installation](./client/DOCUMENTATION.md).

## 📑 Documentation

- [API](./api/DOCUMENTATION.md)
- [Client](./client/DOCUMENTATION.md)

## ☕ Contributing

If you see anything that can be improved, feel free to make a pull request.
Contributions are welcome and will be fully credited.
