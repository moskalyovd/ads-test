# ads-test

1. Для того, чтобы поднять контейнеры:

```
docker-compose build
docker-compose up
```

2. Зайти в контейнер `ads-app` и выполнить:
```
composer install
php init_db.php
// Это хак на скорую руку
chmod ugo+w config/
chmod ugo+w config/ads.db
```

3. В API есть 3 эндпоинта

Для создания объявления
```
POST /ads/1234 HTTP/1.1
Host: localhost
Content-Type: application/x-www-form-urlencoded
```

Для получения релевантного объявления
```
GET /ads/relevant HTTP/1.1
Host: localhost
```

Для изменения объявления
```
POST /ads/1234 HTTP/1.1
Host: localhost
Content-Type: application/x-www-form-urlencoded
```
