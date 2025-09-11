# Requirements

```bash
$ symfony php ./requirements.php
```

# Install

```bash
$ symfony composer install
$ symfony console doctrine:database:create
$ symfony console doctrine:migration:migrate -n
$ symfony console doctrine:fixture:load -n
$ symfony serve
```
