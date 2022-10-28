# Delivery App

Simple Symfony App

## Installation

1. Edit .env file. Search and replace the value of DATABASE_URL

2. In CLI run this in gallery directory
```
composer update
php bin/console doctrine:database:create
php bin/console doctrine:database:update --force
```

3. Edit fixture file to see the password, src/DataFixtures/UserFixture.php


4. Load fixtures
```
php bin/console doctrine:fixtures:load
```

5. To create a new category add these values
```
Category Name: Dogs
Category Link: https//www.flickr.com/search/?text=dogs
```