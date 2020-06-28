## Install

### Composer

```bash
composer require arguv/crud-api-bundle:dev-master
```

### AppKernel

Include the bundle in your AppKernel

```php
public function registerBundles()
{
    $bundles = [
        ...
        new Arguv\CrudApiBundle\CrudApiBundle(),
```

### Routing

```yaml
arguv_crud_api:
    resource: '@CrudApiBundle/Controller/'
    type:     annotation
```

### Doctrine

```yaml
php bin/console doctrine:schema:update --force
```

### CRUD

```yaml
GET   /arguv/list
GET   /arguv/list/{id}
POST  /arguv/create
POST  /arguv/update/{id}
POST  /arguv/delete/{id}
```

### JSON

```yaml
[
   {
      "name": "Smith",
      "description": "Willard Carroll Smith Jr. is an American actor and rapper."
   }
]
```