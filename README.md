# CRUD API Bundle

Reusable Symfony 3.4 bundle providing a JSON CRUD API for the `Product` entity.

## Requirements

- PHP 5.6 or newer
- Symfony 3.4
- Doctrine ORM 2.5 or newer

## Installation

Install the bundle with Composer:

```bash
composer require arguv/crud-api-bundle:dev-master
```

Register it in `AppKernel.php`:

```php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Arguv\CrudApiBundle\CrudApiBundle(),
    );

    return $bundles;
}
```

Enable the bundle routes:

```yaml
arguv_crud_api:
    resource: '@CrudApiBundle/Controller/'
    type: annotation
```

Create the Doctrine table in the host application:

```bash
php bin/console doctrine:schema:update --force
```

## API endpoints

| Method | Endpoint | Description |
| --- | --- | --- |
| `GET` | `/arguv/list` | Return all products |
| `GET` | `/arguv/list/{id}` | Return one product |
| `POST` | `/arguv/create` | Create a product |
| `POST` | `/arguv/update/{id}` | Update a product |
| `POST` | `/arguv/delete/{id}` | Delete a product |

The `{id}` parameter must be numeric. Missing products return a JSON response
with HTTP status `404`.

## Request body

Create and update requests require `name` and `description` string values.
The product name cannot exceed 100 characters. The API accepts either a single
JSON object or the documented one-item array:

```json
{
  "name": "Smith",
  "description": "Willard Carroll Smith Jr. is an American actor and rapper."
}
```

```json
[
  {
    "name": "Smith",
    "description": "Willard Carroll Smith Jr. is an American actor and rapper."
  }
]
```

Successful responses use this structure:

```json
{
  "result": "success",
  "description": "Record created successfully",
  "code": 200,
  "data": "Record created successfully"
}
```

Missing records use this structure:

```json
{
  "result": "error",
  "description": "No product found in the database with the given id - 10",
  "code": 404,
  "data": []
}
```

## Development

Install development dependencies and run the test suite with:

```bash
composer install
vendor/bin/phpunit
```

Tests are located in `Arguv/CrudApiBundle/tests`.
