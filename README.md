<div align="center">

# ☁️ Yandex Cloud Client PHP

### 🚀 Modern PHP SDK for Yandex Cloud API

![Yandex Cloud Client PHP](https://github.com/user-attachments/assets/2f1677ca-dbed-4311-8c1d-cc269077de93)

[![Latest Version](https://img.shields.io/packagist/v/tigusigalpa/yandex-cloud-client-php.svg?style=flat&logo=packagist)](https://packagist.org/packages/tigusigalpa/yandex-cloud-client-php)
[![Total Downloads](https://img.shields.io/packagist/dt/tigusigalpa/yandex-cloud-client-php.svg?style=flat&logo=packagist)](https://packagist.org/packages/tigusigalpa/yandex-cloud-client-php)
[![PHP Version](https://img.shields.io/packagist/php-v/tigusigalpa/yandex-cloud-client-php.svg?style=flat&logo=php)](https://packagist.org/packages/tigusigalpa/yandex-cloud-client-php)
[![License](https://img.shields.io/packagist/l/tigusigalpa/yandex-cloud-client-php.svg?style=flat)](LICENSE)

[🇷🇺 Русская версия](README-ru.md) • [📦 Packagist](https://packagist.org/packages/tigusigalpa/yandex-cloud-client-php) • [🐙 GitHub](https://github.com/tigusigalpa/yandex-cloud-client-php)

**Powerful, elegant, and developer-friendly PHP SDK for Yandex Cloud API with seamless Laravel integration.**

Manage organizations, clouds, folders, and IAM authentication with clean, modern PHP 8.0+ code.

</div>

---

## ✨ Features

<table>
<tr>
<td width="50%">

### 🔐 Authentication & Security

- **OAuth 2.0** token support
- **Automatic IAM** token generation
- **Smart caching** with auto-refresh
- **Token expiry** management (12h)

### 🏢 Resource Management

- **Organizations** - Full CRUD & access control
- **Clouds** - Complete lifecycle management
- **Folders** - Operations & permissions
- **Service Accounts** - Full lifecycle & access
- **User Accounts** - Get user info by ID or login
- **API Keys** - Create & manage API keys
- **Refresh Tokens** - Token lifecycle

</td>
<td width="50%">

### 🎯 Laravel Integration

- **Service Provider** with auto-discovery
- **Facade** for elegant syntax
- **Config** with .env support
- **Dependency Injection** ready

### 💎 Code Quality

- **PHP 8.0+** with strict types
- **Full type hints** everywhere
- **PSR-12** compliant
- **Well tested** with PHPUnit

</td>
</tr>
</table>

## 📋 Requirements

| Requirement | Version         |
|-------------|-----------------|
| PHP         | 8.0+            |
| Guzzle HTTP | 7.0+            |
| Laravel     | 8.0+ (optional) |

## 🚀 Quick Start

### Installation

```bash
composer require tigusigalpa/yandex-cloud-client-php
```

### Get Your OAuth Token

<details>
<summary>📝 Click to see how to get OAuth token</summary>

1. Visit [Yandex OAuth](https://oauth.yandex.ru/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb)
2. Authorize the application
3. Copy the token
4. Use it in your code

💡 **Tip**: Store tokens securely in environment variables!

For more details, see [Yandex Cloud Documentation](https://yandex.cloud/ru/docs/iam/concepts/authorization/oauth-token).

</details>

### Laravel Setup

```bash
# Publish configuration
php artisan vendor:publish --tag=yandex-cloud-config
```

Add to your `.env`:

```env
YANDEX_CLOUD_OAUTH_TOKEN=your_oauth_token_here
YANDEX_CLOUD_ORGANIZATION_ID=your_organization_id
YANDEX_CLOUD_CLOUD_ID=your_cloud_id
YANDEX_CLOUD_FOLDER_ID=your_folder_id
```

## 💻 Usage Examples

### Standalone PHP

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

// Initialize client
$client = new YandexCloudClient('your_oauth_token');

// List all organizations
$organizations = $client->organizations()->list();

// List clouds in organization
$clouds = $client->clouds()->list(organizationId: 'org_id');

// Create a new folder
$folder = $client->folders()->create(
    cloudId: 'cloud_id',
    name: 'My Folder',
    description: 'Created via API'
);
```

### Laravel - Using Facade

```php
use Tigusigalpa\YandexCloudClient\Laravel\Facades\YandexCloud;

// Clean and elegant syntax
$organizations = YandexCloud::organizations()->list();
$org = YandexCloud::organizations()->get('organization_id');

// Create cloud with named parameters
$cloud = YandexCloud::clouds()->create(
    organizationId: 'org_id',
    name: 'Production Cloud',
    description: 'Main production environment',
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

## 📚 Complete API Reference

### 🏢 Organizations API

```php
// List organizations
$organizations = $client->organizations()->list(
    pageSize: 100,
    pageToken: null
);

// Get organization
$org = $client->organizations()->get('organization_id');

// Update organization
$org = $client->organizations()->update('organization_id', [
    'name' => 'New Name',
    'description' => 'New Description',
]);

// Add role to organization
$result = $client->organizations()->addRole(
    organizationId: 'org_id',
    subjectId: 'user_id',
    roleId: 'editor',
    subjectType: 'userAccount'
);

// Remove role from organization
$result = $client->organizations()->removeRole(
    organizationId: 'org_id',
    subjectId: 'user_id',
    roleId: 'editor'
);

// List access bindings
$bindings = $client->organizations()->listAccessBindings('organization_id');
```

### ☁️ Clouds API

```php
// List clouds
$clouds = $client->clouds()->list(
    organizationId: 'org_id',
    pageSize: 100
);

// Get cloud
$cloud = $client->clouds()->get('cloud_id');

// Create cloud
$cloud = $client->clouds()->create(
    organizationId: 'org_id',
    name: 'My Cloud',
    description: 'Production cloud',
    labels: ['env' => 'production']
);

// Update cloud
$cloud = $client->clouds()->update('cloud_id', [
    'name' => 'Updated Name',
    'description' => 'Updated Description',
]);

// Delete cloud
$result = $client->clouds()->delete('cloud_id');

// Add role to cloud
$result = $client->clouds()->addRole(
    cloudId: 'cloud_id',
    subjectId: 'user_id',
    roleId: 'editor'
);

// List access bindings
$bindings = $client->clouds()->listAccessBindings('cloud_id');
```

### 📁 Folders API

```php
// List folders
$folders = $client->folders()->list(
    cloudId: 'cloud_id',
    pageSize: 100
);

// Get folder
$folder = $client->folders()->get('folder_id');

// Create folder
$folder = $client->folders()->create(
    cloudId: 'cloud_id',
    name: 'My Folder',
    description: 'Development folder',
    labels: ['team' => 'backend']
);

// Update folder
$folder = $client->folders()->update('folder_id', [
    'name' => 'Updated Name',
]);

// Delete folder
$result = $client->folders()->delete('folder_id');

// List operations
$operations = $client->folders()->listOperations('folder_id');

// Add role to folder
$result = $client->folders()->addRole(
    folderId: 'folder_id',
    subjectId: 'user_id',
    roleId: 'ai.languageModels.user'
);

// List access bindings
$bindings = $client->folders()->listAccessBindings('folder_id');
```

### 🔄 Refresh Tokens API

```php
// List refresh tokens
$tokens = $client->refreshTokens()->list();

// Revoke refresh token
$result = $client->refreshTokens()->revoke('token_id');
```

### 👤 Service Accounts API

```php
// List service accounts in folder
$serviceAccounts = $client->serviceAccounts()->list(
    folderId: 'folder_id',
    pageSize: 100
);

// Get service account
$sa = $client->serviceAccounts()->get('service_account_id');

// Create service account
$sa = $client->serviceAccounts()->create(
    folderId: 'folder_id',
    name: 'my-service-account',
    description: 'Service account for API access'
);

// Update service account
$sa = $client->serviceAccounts()->update('service_account_id', [
    'name' => 'Updated name',
    'description' => 'Updated description',
]);

// Delete service account
$result = $client->serviceAccounts()->delete('service_account_id');

// Add role to service account
$result = $client->serviceAccounts()->addRole(
    serviceAccountId: 'service_account_id',
    subjectId: 'user_id',
    roleId: 'editor'
);

// List access bindings
$bindings = $client->serviceAccounts()->listAccessBindings('service_account_id');
```

### 👥 User Accounts API

```php
// Get user account by ID
$user = $client->userAccounts()->get('user_account_id');

// Get user by Yandex Passport login (to get user ID for access control)
$user = $client->yandexPassportUserAccounts()->getByLogin('username');
// Returns: ['id' => 'user_id', 'login' => 'username', ...]

// Use the ID to assign roles
$userId = $user['id'];
$client->folders()->addRole(
    folderId: 'folder_id',
    subjectId: $userId,
    roleId: 'editor',
    subjectType: 'userAccount'
);
```

### 🔑 API Keys

```php
// List API keys for service account
$keys = $client->apiKeys()->list(
    serviceAccountId: 'service_account_id',
    pageSize: 100
);

// Get API key
$key = $client->apiKeys()->get('api_key_id');

// Create API key (secret is shown only once!)
$key = $client->apiKeys()->create(
    serviceAccountId: 'service_account_id',
    description: 'API key for production'
);
// Save $key['secret'] immediately - it won't be shown again!

// Update API key
$key = $client->apiKeys()->update('api_key_id', [
    'description' => 'Updated description',
]);

// Delete API key
$result = $client->apiKeys()->delete('api_key_id');
```

---

## 🔐 Advanced Access Control

### Adding Multiple Roles at Once

```php
// Add multiple roles to a folder
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

### Replacing All Access Bindings

```php
// Replace all access bindings
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

### Assigning Roles by User Login

```php
// Get user ID by Yandex Passport login
$user = $client->yandexPassportUserAccounts()->getByLogin('username@yandex.ru');
$userId = $user['id'];

// Assign role to folder using the user ID
$client->folders()->addRole(
    folderId: 'folder_id',
    subjectId: $userId,
    roleId: 'ai.languageModels.user',
    subjectType: 'userAccount'
);

// Or assign to cloud
$client->clouds()->addRole(
    cloudId: 'cloud_id',
    subjectId: $userId,
    roleId: 'editor',
    subjectType: 'userAccount'
);
```

---

## ⚠️ Error Handling

```php
use Tigusigalpa\YandexCloudClient\Exceptions\AuthenticationException;
use Tigusigalpa\YandexCloudClient\Exceptions\ApiException;
use Tigusigalpa\YandexCloudClient\Exceptions\ValidationException;

try {
    $clouds = $client->clouds()->list();
} catch (AuthenticationException $e) {
    // Handle authentication errors
    echo "Authentication failed: " . $e->getMessage();
} catch (ValidationException $e) {
    // Handle validation errors
    echo "Validation error: " . $e->getMessage();
} catch (ApiException $e) {
    // Handle API errors
    echo "API error: " . $e->getMessage();
}
```

---

## 🧪 Testing

```bash
# Run tests
composer test

# Run static analysis
composer phpstan

# Check code style
composer cs-check

# Fix code style
composer cs-fix
```

---

## 🤝 Contributing

We welcome contributions! Here's how you can help:

### Development Setup

```bash
# Clone repository
git clone https://github.com/tigusigalpa/yandex-cloud-client-php.git
cd yandex-cloud-client-php

# Install dependencies
composer install

# Copy environment file
cp .env.example .env
```

### Contribution Guidelines

- ✅ **Follow PSR-12** coding standards
- ✅ **Use strict types** and full type hints
- ✅ **Write tests** for new features
- ✅ **Update documentation** as needed
- ✅ **One feature per PR** - keep it focused

### Pull Request Process

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Run tests and ensure they pass
5. Commit changes (`git commit -m 'Add amazing feature'`)
6. Push to branch (`git push origin feature/amazing-feature`)
7. Open a Pull Request

---

## 🔒 Security

If you discover any security vulnerabilities, please email **sovletig@gmail.com** instead of using the issue tracker.

We take security seriously and will respond promptly.

---

## 📦 Deployment & Publishing

<details>
<summary>📋 Click to see deployment checklist</summary>

### Pre-Deployment

```bash
# Install dependencies
composer install

# Run tests
composer test

# Verify package structure
ls -la
```

### GitHub Deployment

```bash
# Initialize repository
git init
git add .
git commit -m "Initial commit: v1.0.0"

# Push to GitHub
git remote add origin https://github.com/tigusigalpa/yandex-cloud-client-php.git
git branch -M main
git push -u origin main

# Create release
git tag v1.0.0
git push origin v1.0.0
```

### Packagist Deployment

1. Go to [packagist.org/packages/submit](https://packagist.org/packages/submit)
2. Enter repository URL
3. Click "Check" and "Submit"
4. Configure auto-update webhook in GitHub settings

### Version Numbering (Semantic Versioning)

- **MAJOR** (1.x.x) - Breaking changes
- **MINOR** (x.1.x) - New features, backwards-compatible
- **PATCH** (x.x.1) - Bug fixes, backwards-compatible

</details>


---

## 👨‍💻 Author & Contributors

**Created with ❤️ by [Igor Sazonov](https://github.com/tigusigalpa)**

- 📧 Email: sovletig@gmail.com
- 🐙 GitHub: [@tigusigalpa](https://github.com/tigusigalpa)

### Contributors

Thanks to [all contributors](../../contributors) who help improve this package!

---

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

Free to use in personal and commercial projects. ✨

---

## 🔗 Related Packages

Explore our other Yandex Cloud packages:

| Package                  | Description           | Links                                                                                                                                              |
|--------------------------|-----------------------|----------------------------------------------------------------------------------------------------------------------------------------------------|
| **YandexGPT PHP**        | SDK for YandexGPT API | [GitHub](https://github.com/tigusigalpa/yandexgpt-php) • [Packagist](https://packagist.org/packages/tigusigalpa/yandexgpt-php)                     |
| **Yandex Cloud Billing** | Billing API SDK       | [GitHub](https://github.com/tigusigalpa/yandexcloud-billing-php) • [Packagist](https://packagist.org/packages/tigusigalpa/yandexcloud-billing-php) |
| **Yandex Lockbox**       | Lockbox API SDK       | [GitHub](https://github.com/tigusigalpa/yandex-lockbox-php) • [Packagist](https://packagist.org/packages/tigusigalpa/yandex-lockbox-php)           |

---

## 🔗 Useful Links

### Official Documentation

- 📖 [Yandex Cloud Documentation](https://yandex.cloud/docs)
- 🏢 [Organization API Reference](https://yandex.cloud/ru/docs/organization/api-ref/)
- ☁️ [Resource Manager API Reference](https://yandex.cloud/ru/docs/resource-manager/api-ref/)
- 🔐 [IAM API Reference](https://yandex.cloud/ru/docs/iam/api-ref/)

### Package Resources

- 📦 [Packagist Package](https://packagist.org/packages/tigusigalpa/yandex-cloud-client-php)
- 🐙 [GitHub Repository](https://github.com/tigusigalpa/yandex-cloud-client-php)
- 🐛 [Issue Tracker](https://github.com/tigusigalpa/yandex-cloud-client-php/issues)
- 💬 [Discussions](https://github.com/tigusigalpa/yandex-cloud-client-php/discussions)

---

<div align="center">

### ⭐ Star us on GitHub!

If this package helped you, please consider giving it a star ⭐

**Made with ❤️ for the PHP community**

[Report Bug](https://github.com/tigusigalpa/yandex-cloud-client-php/issues) • [Request Feature](https://github.com/tigusigalpa/yandex-cloud-client-php/issues) • [Contribute](https://github.com/tigusigalpa/yandex-cloud-client-php/pulls)

</div>
