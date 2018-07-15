# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# 0.1.5

1. Resources > translations > add new
2. Resources > translations > group by destination in each translation domain
3. Tests > verify default configuration parameters > add "defaults" environment

# 0.1.4

1. Resources > translations > add new

# 0.1.3

1. Resources > translations > common translations

# 0.1.2

1. Twig extension related to the `ApplicationService` service

# 0.1.1

1. Add descriptor of application
2. Replenish documentation:
	- Descriptor of bundle
	- Descriptors of bundles
	- Descriptor of application
	- Services: ApplicationService

# 0.1.0

1. Bump version

# 0.0.2

1. Add `README.md`
2. Implement Docker
3. Docker: use project-related binaries globally
4. Reorganize documentation & update [Readme](README.md)
5. Composer: add phpunit/phpunit package
6. StyleCI > disable & remove
7. Documentation > Development > update
8. Composer > add packages > meritoo/common-library & symfony/framework-bundle. Require PHP 7.2+.
9. PHP Coding Standards Fixer > configuration > update
10. Descriptor of bundles & collection of descriptors
11. Composer > add friendsofphp/php-cs-fixer package
12. .gitignore > add PHPUnit section
13. Value Object > Version of software
14. Tests > use BaseTestCase class instead of BaseTestCaseTrait
15. Tests > remove the Dummy Test
16. Composer > require ext-pcre
17. Documentation > Development > update
18. Docker > rename `php-cli` service to `php`
19. Remove `Version` class (Value Object > Version of software). Use `Version` class from `meritoo/common-library` package.
20. Base Dependency Injection (DI) extension, the `BaseExtension` class
21. Add main class of this bundle, the `MeritooCommonBundle` class
22. Add Dependency Injection (DI) Extension (and configuration) for this bundle
23. Tests > add kernel
24. Composer > require `symfony/phpunit-bridge` and `symfony/yaml` packages
25. Groundwork of Symfony's service, the `BaseService` class
26. Service > add service that serves application, the `ApplicationService` class
27. Move version of this package to `VERSION` file (from `composer.json` file)
28. Travis CI > do not run using PHP < 7.2 (because bundle requires PHP >= 7.2 in `composer.json`)

# 0.0.1

1. Add this changelog
2. Add composer.json
3. Add .gitignore
4. Add .php_cs.dist, .styleci.yml, .travis.yml
