FoodMeUp Test-Symfony
=====================

# Installation

```
composer install

php bin/console doctrine:schema:update --force
```

# Récupération de la base

Deux choix :
```
Installation via la CLI : 
php bin/console import:csv ./database/Table_Ciqual_2016.csv

ou via fichier sql (plus rapide) : ./database/dump_foodmeup.sql
```

# Tests

```
phpunit
```