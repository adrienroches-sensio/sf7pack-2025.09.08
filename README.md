# Requirements

```bash
$ symfony php ./requirements.php
```

# Install

Get an API key from https://www.devevents-api.fr/ and add a `CONFERENCES_API_KEY` to your `.env.local` file. 

```bash
$ symfony composer install
$ symfony console doctrine:database:create
$ symfony console doctrine:migration:migrate -n
$ symfony console doctrine:fixture:load -n
$ symfony serve
```
