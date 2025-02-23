## Wallex interview task

### Getting start

step 1: clone the project
```bash
git clone https://github.com/khodemobin/wallex-interview-task
```


step 2: copy .env.example => .env
```bash
cp .env.example .env
```

step 3: generate app key

```bash
php artisan key:generate
```

step 4: setup sqlite database and seed data

```bash
php artisan migrate --seed
```

step 5: serve project

```bash
php artisan serve
```
or alternatively can run docker
```bash
docker compose up -d
```


now project serve on port 8000 also can see swagger docs in

<a>http://localhost:8000/docs/index.html</a>

if this URL not work run this command to generate swagger docs

```bash
php artisan scribe:generate
```

step 6: running tests

```bash
php artisan test
```

