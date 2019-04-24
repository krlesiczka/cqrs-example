## PHP CQRS demo ##

Before:
```bash
composer install
```

Usage:
```bash
php bin/cli.php bootstrap
```

Check company list
```bash
php bin/cli.php print_companies_list
```

Register new employee:
```bash
php bin/cli.php register_employee 1d1b947f-c89b-49c7-8358-f3ffc457de59 employee@test.com Employee 48904343245
```

##TODO

- write some behat tests
