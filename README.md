<div align="center">

# ☁️ Yandex Cloud Client PHP

### 🚀 Современный PHP SDK для Yandex Cloud API

![Yandex Cloud Client PHP](https://github.com/user-attachments/assets/2f1677ca-dbed-4311-8c1d-cc269077de93)

[![Latest Version](https://img.shields.io/packagist/v/tigusigalpa/yandex-cloud-client-php.svg?style=flat&logo=packagist)](https://packagist.org/packages/tigusigalpa/yandex-cloud-client-php)
[![Total Downloads](https://img.shields.io/packagist/dt/tigusigalpa/yandex-cloud-client-php.svg?style=flat&logo=packagist)](https://packagist.org/packages/tigusigalpa/yandex-cloud-client-php)
[![PHP Version](https://img.shields.io/packagist/php-v/tigusigalpa/yandex-cloud-client-php.svg?style=flat&logo=php)](https://packagist.org/packages/tigusigalpa/yandex-cloud-client-php)
[![License](https://img.shields.io/packagist/l/tigusigalpa/yandex-cloud-client-php.svg?style=flat)](LICENSE)

[🇬🇧 English version](README-en.md) • [📦 Packagist](https://packagist.org/packages/tigusigalpa/yandex-cloud-client-php) • [🐙 GitHub](https://github.com/tigusigalpa/yandex-cloud-client-php)

**Мощный, элегантный и удобный PHP SDK для Yandex Cloud API с бесшовной интеграцией в Laravel.**

Управляйте организациями, облаками, каталогами и IAM-авторизацией с помощью чистого современного PHP 8.0+ кода.

</div>

---

## ✨ Возможности

<table>
<tr>
<td width="50%">

### 🔐 Авторизация и безопасность

- **OAuth 2.0** поддержка токенов
- **Автоматический IAM** генерация токенов
- **Умное кэширование** с авто-обновлением
- **Управление сроком** действия (12ч)

### 🏢 Управление ресурсами

- **Организации** - Полный CRUD и управление доступом
- **Облака** - Полный жизненный цикл
- **Каталоги** - Операции и права доступа
- **Сервисные аккаунты** - Полный жизненный цикл и доступ
- **Пользователи** - Получение по ID или логину
- **API ключи** - Создание и управление
- **Refresh-токены** - Жизненный цикл токенов

</td>
<td width="50%">

### 🎯 Интеграция с Laravel

- **Service Provider** с авто-обнаружением
- **Facade** для элегантного синтаксиса
- **Конфиг** с поддержкой .env
- **Dependency Injection** готов

### 💎 Качество кода

- **PHP 8.0+** со строгой типизацией
- **Полные type hints** повсюду
- **PSR-12** совместимость
- **Хорошо протестирован** с PHPUnit

</td>
</tr>
</table>

## 📋 Требования

| Требование  | Версия             |
|-------------|--------------------|
| PHP         | 8.0+               |
| Guzzle HTTP | 7.0+               |
| Laravel     | 8.0+ (опционально) |

## 🚀 Быстрый старт

### Установка

```bash
composer require tigusigalpa/yandex-cloud-client-php
```

### Получение OAuth токена

<details>
<summary>📝 Нажмите, чтобы узнать, как получить OAuth токен</summary>

1. Перейдите
   на [Yandex OAuth](https://oauth.yandex.ru/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb)
2. Авторизуйте приложение
3. Скопируйте токен
4. Используйте его в коде

💡 **Совет**: Храните токены безопасно в переменных окружения!

Подробнее см. [Документацию Yandex Cloud](https://yandex.cloud/ru/docs/iam/concepts/authorization/oauth-token).

</details>

### Настройка Laravel

```bash
# Опубликовать конфигурацию
php artisan vendor:publish --tag=yandex-cloud-config
```

Добавьте в `.env`:

```env
YANDEX_CLOUD_OAUTH_TOKEN=ваш_oauth_токен
YANDEX_CLOUD_ORGANIZATION_ID=id_организации
YANDEX_CLOUD_CLOUD_ID=id_облака
YANDEX_CLOUD_FOLDER_ID=id_каталога
```

## 💻 Примеры использования

### Standalone PHP

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

// Инициализация клиента
$client = new YandexCloudClient('ваш_oauth_токен');

// Список всех организаций
$organizations = $client->organizations()->list();

// Список облаков в организации
$clouds = $client->clouds()->list(organizationId: 'org_id');

// Создать новый каталог
$folder = $client->folders()->create(
    cloudId: 'cloud_id',
    name: 'Мой каталог',
    description: 'Создан через API'
);
```

### Laravel - Использование Facade

```php
use Tigusigalpa\YandexCloudClient\Laravel\Facades\YandexCloud;

// Чистый и элегантный синтаксис
$organizations = YandexCloud::organizations()->list();
$org = YandexCloud::organizations()->get('organization_id');

// Создать облако с именованными параметрами
$cloud = YandexCloud::clouds()->create(
    organizationId: 'org_id',
    name: 'Продакшн облако',
    description: 'Основное продакшн окружение',
    labels: ['env' => 'production']
);
```

### Laravel - Dependency Injection

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

class CloudController extends Controller
{
    public function __construct(
        private YandexCloudClient $yandexCloud
    ) {}

    public function index()
    {
        $clouds = $this->yandexCloud->clouds()->list();
        return view('clouds.index', compact('clouds'));
    }
    
    public function store(Request $request)
    {
        $folder = $this->yandexCloud->folders()->create(
            cloudId: $request->cloud_id,
            name: $request->name,
            description: $request->description
        );
        
        return response()->json($folder, 201);
    }
}
```

---

## 📚 Полная справка по API

### 🏢 API организаций

```php
// Список организаций
$organizations = $client->organizations()->list(
    pageSize: 100,
    pageToken: null
);

// Получить организацию
$org = $client->organizations()->get('organization_id');

// Обновить организацию
$org = $client->organizations()->update('organization_id', [
    'name' => 'Новое имя',
    'description' => 'Новое описание',
]);

// Назначить роль на организацию
$result = $client->organizations()->addRole(
    organizationId: 'org_id',
    subjectId: 'user_id',
    roleId: 'editor',
    subjectType: 'userAccount'
);

// Удалить роль с организации
$result = $client->organizations()->removeRole(
    organizationId: 'org_id',
    subjectId: 'user_id',
    roleId: 'editor'
);

// Список назначенных ролей
$bindings = $client->organizations()->listAccessBindings('organization_id');
```

### ☁️ API облаков

```php
// Список облаков
$clouds = $client->clouds()->list(
    organizationId: 'org_id',
    pageSize: 100
);

// Получить облако
$cloud = $client->clouds()->get('cloud_id');

// Создать облако
$cloud = $client->clouds()->create(
    organizationId: 'org_id',
    name: 'Мое облако',
    description: 'Продакшн облако',
    labels: ['env' => 'production']
);

// Обновить облако
$cloud = $client->clouds()->update('cloud_id', [
    'name' => 'Обновленное имя',
    'description' => 'Обновленное описание',
]);

// Удалить облако
$result = $client->clouds()->delete('cloud_id');

// Назначить роль на облако
$result = $client->clouds()->addRole(
    cloudId: 'cloud_id',
    subjectId: 'user_id',
    roleId: 'editor'
);

// Список назначенных ролей
$bindings = $client->clouds()->listAccessBindings('cloud_id');
```

### 📁 API каталогов

```php
// Список каталогов
$folders = $client->folders()->list(
    cloudId: 'cloud_id',
    pageSize: 100
);

// Получить каталог
$folder = $client->folders()->get('folder_id');

// Создать каталог
$folder = $client->folders()->create(
    cloudId: 'cloud_id',
    name: 'Мой каталог',
    description: 'Каталог для разработки',
    labels: ['team' => 'backend']
);

// Обновить каталог
$folder = $client->folders()->update('folder_id', [
    'name' => 'Обновленное имя',
]);

// Удалить каталог
$result = $client->folders()->delete('folder_id');

// Список операций
$operations = $client->folders()->listOperations('folder_id');

// Назначить роль на каталог
$result = $client->folders()->addRole(
    folderId: 'folder_id',
    subjectId: 'user_id',
    roleId: 'ai.languageModels.user'
);

// Список назначенных ролей
$bindings = $client->folders()->listAccessBindings('folder_id');
```

### 🔄 API Refresh-токенов

```php
// Список refresh-токенов
$tokens = $client->refreshTokens()->list();

// Отозвать refresh-токен
$result = $client->refreshTokens()->revoke('token_id');
```

### 👤 API сервисных аккаунтов

```php
// Список сервисных аккаунтов в каталоге
$serviceAccounts = $client->serviceAccounts()->list(
    folderId: 'folder_id',
    pageSize: 100
);

// Получить сервисный аккаунт
$sa = $client->serviceAccounts()->get('service_account_id');

// Создать сервисный аккаунт
$sa = $client->serviceAccounts()->create(
    folderId: 'folder_id',
    name: 'my-service-account',
    description: 'Сервисный аккаунт для API'
);

// Обновить сервисный аккаунт
$sa = $client->serviceAccounts()->update('service_account_id', [
    'name' => 'Обновлённое имя',
    'description' => 'Обновлённое описание',
]);

// Удалить сервисный аккаунт
$result = $client->serviceAccounts()->delete('service_account_id');

// Назначить роль на сервисный аккаунт
$result = $client->serviceAccounts()->addRole(
    serviceAccountId: 'service_account_id',
    subjectId: 'user_id',
    roleId: 'editor'
);

// Список назначенных ролей
$bindings = $client->serviceAccounts()->listAccessBindings('service_account_id');
```

### 👥 API пользователей

```php
// Получить пользователя по ID
$user = $client->userAccounts()->get('user_account_id');

// Получить пользователя по логину Yandex Passport (для получения ID)
$user = $client->yandexPassportUserAccounts()->getByLogin('username');
// Возвращает: ['id' => 'user_id', 'login' => 'username', ...]

// Использовать ID для назначения ролей
$userId = $user['id'];
$client->folders()->addRole(
    folderId: 'folder_id',
    subjectId: $userId,
    roleId: 'editor',
    subjectType: 'userAccount'
);
```

### 🔑 API ключи

```php
// Список API ключей для сервисного аккаунта
$keys = $client->apiKeys()->list(
    serviceAccountId: 'service_account_id',
    pageSize: 100
);

// Получить API ключ
$key = $client->apiKeys()->get('api_key_id');

// Создать API ключ (secret показывается только один раз!)
$key = $client->apiKeys()->create(
    serviceAccountId: 'service_account_id',
    description: 'API ключ для продакшна'
);
// Сохраните $key['secret'] немедленно - он больше не будет показан!

// Обновить API ключ
$key = $client->apiKeys()->update('api_key_id', [
    'description' => 'Обновлённое описание',
]);

// Удалить API ключ
$result = $client->apiKeys()->delete('api_key_id');
```

---

## 🔐 Продвинутое управление доступом

### Назначение нескольких ролей одновременно

```php
// Назначить несколько ролей на каталог
$client->folders()->updateAccessBindings('folder_id', [
    [
        'action' => 'ADD',
        'accessBinding' => [
            'roleId' => 'editor',
            'subject' => [
                'id' => 'user_id_1',
                'type' => 'userAccount',
            ],
        ],
    ],
    [
        'action' => 'ADD',
        'accessBinding' => [
            'roleId' => 'viewer',
            'subject' => [
                'id' => 'user_id_2',
                'type' => 'userAccount',
            ],
        ],
    ],
]);
```

### Замена всех прав доступа

```php
// Заменить все права доступа
$client->clouds()->setAccessBindings('cloud_id', [
    [
        'roleId' => 'admin',
        'subject' => [
            'id' => 'user_id',
            'type' => 'userAccount',
        ],
    ],
]);
```

### Назначение ролей по логину пользователя

```php
// Получить ID пользователя по логину Yandex Passport
$user = $client->yandexPassportUserAccounts()->getByLogin('username@yandex.ru');
$userId = $user['id'];

// Назначить роль на каталог, используя ID пользователя
$client->folders()->addRole(
    folderId: 'folder_id',
    subjectId: $userId,
    roleId: 'ai.languageModels.user',
    subjectType: 'userAccount'
);

// Или назначить на облако
$client->clouds()->addRole(
    cloudId: 'cloud_id',
    subjectId: $userId,
    roleId: 'editor',
    subjectType: 'userAccount'
);
```

---

## ⚠️ Обработка ошибок

```php
use Tigusigalpa\YandexCloudClient\Exceptions\AuthenticationException;
use Tigusigalpa\YandexCloudClient\Exceptions\ApiException;
use Tigusigalpa\YandexCloudClient\Exceptions\ValidationException;

try {
    $clouds = $client->clouds()->list();
} catch (AuthenticationException $e) {
    // Обработка ошибок авторизации
    echo "Ошибка авторизации: " . $e->getMessage();
} catch (ValidationException $e) {
    // Обработка ошибок валидации
    echo "Ошибка валидации: " . $e->getMessage();
} catch (ApiException $e) {
    // Обработка ошибок API
    echo "Ошибка API: " . $e->getMessage();
}
```

---

## 🧪 Тестирование

```bash
# Запустить тесты
composer test

# Запустить статический анализ
composer phpstan

# Проверить стиль кода
composer cs-check

# Исправить стиль кода
composer cs-fix
```

---

## 🤝 Участие в разработке

Мы приветствуем ваш вклад! Вот как вы можете помочь:

### Настройка окружения для разработки

```bash
# Клонировать репозиторий
git clone https://github.com/tigusigalpa/yandex-cloud-client-php.git
cd yandex-cloud-client-php

# Установить зависимости
composer install

# Скопировать файл окружения
cp .env.example .env
```

### Рекомендации по участию

- ✅ **Следуйте PSR-12** стандартам кодирования
- ✅ **Используйте строгую типизацию** и полные type hints
- ✅ **Пишите тесты** для новых функций
- ✅ **Обновляйте документацию** при необходимости
- ✅ **Одна функция на PR** - держите фокус

### Процесс Pull Request

1. Сделайте форк репозитория
2. Создайте ветку функции (`git checkout -b feature/amazing-feature`)
3. Внесите изменения
4. Запустите тесты и убедитесь, что они проходят
5. Закоммитьте изменения (`git commit -m 'Add amazing feature'`)
6. Отправьте в ветку (`git push origin feature/amazing-feature`)
7. Откройте Pull Request

---

## 🔒 Безопасность

Если вы обнаружили уязвимости безопасности, пожалуйста, напишите на **sovletig@gmail.com** вместо использования issue
tracker.

Мы серьёзно относимся к безопасности и оперативно реагируем.

---

## 📦 Развёртывание и публикация

<details>
<summary>📋 Нажмите, чтобы увидеть чеклист развёртывания</summary>

### Перед развёртыванием

```bash
# Установить зависимости
composer install

# Запустить тесты
composer test

# Проверить структуру пакета
ls -la
```

### Развёртывание на GitHub

```bash
# Инициализировать репозиторий
git init
git add .
git commit -m "Initial commit: v1.0.0"

# Отправить на GitHub
git remote add origin https://github.com/tigusigalpa/yandex-cloud-client-php.git
git branch -M main
git push -u origin main

# Создать релиз
git tag v1.0.0
git push origin v1.0.0
```

### Развёртывание на Packagist

1. Перейдите на [packagist.org/packages/submit](https://packagist.org/packages/submit)
2. Введите URL репозитория
3. Нажмите "Check" и "Submit"
4. Настройте webhook для авто-обновления в настройках GitHub

### Нумерация версий (Semantic Versioning)

- **MAJOR** (1.x.x) - Несовместимые изменения
- **MINOR** (x.1.x) - Новые функции, обратно совместимые
- **PATCH** (x.x.1) - Исправления ошибок, обратно совместимые

</details>

---

## 👨‍💻 Автор и участники

**Создано с ❤️ [Игорем Сазоновым](https://github.com/tigusigalpa)**

- 📧 Email: sovletig@gmail.com
- 🐙 GitHub: [@tigusigalpa](https://github.com/tigusigalpa)

### Участники

Спасибо [всем участникам](../../contributors), которые помогают улучшать этот пакет!

---

## 📄 Лицензия

Этот проект лицензирован под **лицензией MIT** - подробности в файле [LICENSE](LICENSE).

Свободно используйте в личных и коммерческих проектах. ✨

---

## 🔗 Связанные пакеты

Изучите наши другие пакеты для Yandex Cloud:

| Пакет                    | Описание              | Ссылки                                                                                                                                             |
|--------------------------|-----------------------|----------------------------------------------------------------------------------------------------------------------------------------------------|
| **YandexGPT PHP**        | SDK для YandexGPT API | [GitHub](https://github.com/tigusigalpa/yandexgpt-php) • [Packagist](https://packagist.org/packages/tigusigalpa/yandexgpt-php)                     |
| **Yandex Cloud Billing** | SDK для Billing API   | [GitHub](https://github.com/tigusigalpa/yandexcloud-billing-php) • [Packagist](https://packagist.org/packages/tigusigalpa/yandexcloud-billing-php) |
| **Yandex Lockbox**       | SDK для Lockbox API   | [GitHub](https://github.com/tigusigalpa/yandex-lockbox-php) • [Packagist](https://packagist.org/packages/tigusigalpa/yandex-lockbox-php)           |

---

## 🔗 Полезные ссылки

### Официальная документация

- 📖 [Документация Yandex Cloud](https://yandex.cloud/docs)
- 🏢 [Справка по Organization API](https://yandex.cloud/ru/docs/organization/api-ref/)
- ☁️ [Справка по Resource Manager API](https://yandex.cloud/ru/docs/resource-manager/api-ref/)
- 🔐 [Справка по IAM API](https://yandex.cloud/ru/docs/iam/api-ref/)

### Ресурсы пакета

- 📦 [Пакет на Packagist](https://packagist.org/packages/tigusigalpa/yandex-cloud-client-php)
- 🐙 [Репозиторий на GitHub](https://github.com/tigusigalpa/yandex-cloud-client-php)
- 🐛 [Трекер проблем](https://github.com/tigusigalpa/yandex-cloud-client-php/issues)
- 💬 [Обсуждения](https://github.com/tigusigalpa/yandex-cloud-client-php/discussions)

---

<div align="center">

### ⭐ Поставьте звезду на GitHub!

Если этот пакет помог вам, пожалуйста, поставьте звезду ⭐

**Сделано с ❤️ для PHP сообщества**

[Сообщить об ошибке](https://github.com/tigusigalpa/yandex-cloud-client-php/issues) • [Запросить функцию](https://github.com/tigusigalpa/yandex-cloud-client-php/issues) • [Внести вклад](https://github.com/tigusigalpa/yandex-cloud-client-php/pulls)

</div>
