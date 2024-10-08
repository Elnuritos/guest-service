# Guest API Service

## Описание
Этот проект представляет собой API для управления гостями. Он включает CRUD операции, а также интеграцию с OpenAPI (Swagger) для документирования API и тесты.

## Технологии
- PHP 8.x
- Laravel 9.x
- Docker
- MySQL
- Swagger (OpenAPI)

## Установка и настройка

### 1. Клонирование репозитория

```bash
git clone <ссылка на репозиторий>
cd guest-service
```

### 2. Копирование `.env` файла

Создайте `.env` файл на основе `.env.example`:

```bash
cp .env.example .env
```

### 3. Запуск Docker контейнеров

Запустите Docker контейнеры с использованием `docker-compose`:

```bash
docker-compose up -d
```

Это создаст контейнеры для приложения, базы данных и других необходимых сервисов.

### 4. Установка зависимостей

Выполните следующую команду для установки зависимостей PHP внутри контейнера:

```bash
docker-compose exec app composer install
```

### 5. Генерация ключа приложения

Сгенерируйте ключ приложения Laravel:

```bash
docker-compose exec app php artisan key:generate
```

### 6. Запуск миграций и сидов

Запустите миграции для создания таблиц базы данных:

```bash
docker-compose exec app php artisan migrate
```

Если вам нужны начальные данные, вы можете использовать сиды:

```bash
docker-compose exec app php artisan db:seed --class=GuestSeeder
```

### 7. Генерация Swagger документации

Чтобы сгенерировать документацию для API, выполните следующую команду:

```bash
docker-compose exec app php artisan l5-swagger:generate
```

### 8. Доступ к API документации

После генерации документации Swagger, она будет доступна по адресу:

```
http://localhost:8000/docs
http://localhost:8000/api/documentation
```

### 9. Запуск тестов

Чтобы убедиться, что всё работает правильно, запустите тесты:

```bash
docker-compose exec app php artisan test
```

### 10. Использование API

- **Список гостей**: `GET /api/v1/guests`
- **Создание гостя**: `POST /api/v1/guests`
- **Получение информации о госте**: `GET /api/v1/guests/{id}`
- **Обновление данных гостя**: `PUT /api/v1/guests/{id}`
- **Удаление гостя**: `DELETE /api/v1/guests/{id}`
- **Во всех запросах есть  x-debug-memory и x-debug-time**



### 12. Остановка контейнеров

Для остановки и удаления всех контейнеров используйте:

```bash
docker-compose down
```

## Примечания
- Убедитесь, что у вас установлен Docker и Docker Compose.
- При необходимости, настройте переменные в `.env` файле, такие как доступ к базе данных и другие конфигурации.
- Если у вас возникают ошибки с подключением к базе данных, убедитесь, что контейнеры с базой данных запущены.


