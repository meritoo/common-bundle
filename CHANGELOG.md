# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# 0.1.26

1. Resources > translations > add new

# 0.1.25

1. PHPUnit > enable Symfony listener
2. Phing > tests > add task for Psalm (https://psalm.dev)
3. Readme > review and fix "unknown" badges
4. Docker > use images (instead of Dockerfiles)
5. composer > squizlabs/php_codesniffer package > use ^3.4 (instead of ^2.9)
6. Do not require ext-intl, because is required by meritoo/common-library package
7. Update Kernel used by tests
8. BaseExtension > verify extension of services' configuration file by separate method & in the loadServices() method
(not in loadConfigurationFile() method)
9. BaseExtension > prepare flat configuration by separate method
10. BaseExtension > prepare loader of configuration file by separate class

# 0.1.24

1. Composer > meritoo/common-library package > bump version to 1.0.0 (related to PHP 7.2+)
2. Composer > dev packages > bump versions (e.g. PHPUnit 8.0) Tests > make compatible with PHPUnit 8.0+
3. Phing > remove old and unused tools
4. Phing > remove old and unused tools
5. PHPUnit > execute tests in random order

# 0.1.23

1. Travis CI > run many tasks using Phing (instead of PHPUnit only)
2. Fix integration with [Coveralls](https://www.coveralls.io) (available as the badge in [README.md](README.md))
3. Implement [PHPStan](https://github.com/phpstan/phpstan)
4. PHP Coding Standards Fixer > configuration > update & fix coding standard
5. Implement [Psalm] (https://github.com/vimeo/psalm)
6. Psalm > fix code

# 0.1.22

1. HTML5 Boilerplate based on [Twitter Bootstrap](https://getbootstrap.com) by [Initializr](http://www.initializr.com)

# 0.1.21

1. Resources > translations > add new

# 0.1.20

1. Fix coding standard
2. Controller > BaseController > base controller with common and useful methods

# 0.1.19

1. Resources > translations > add new
2. Validator > date > date that should be: earlier than today, earlier than or equal today, later than today, later 
than or equal today

# 0.1.18

1. Tests > DateService > fix testing methods related to timezone

# 0.1.17

1. Phing > update configuration
2. Docker > docker-compose.yml > add "phpunit" service > used to run PHPUnit's tests
3. Service > DateService > service that serves dates

# 0.1.16

1. Phing > tests > missing path of directory with code coverage report
2. Phing > tests > PHPUnit > do not use dox format (for output results)
3. Docker > Dockerfile > remove not working the Handy Apt Terminal Progress Bar
4. Implement Mutation Testing Framework (infection/infection package)
5. Phing > update configuration & fix coding standard
6. Resources > translations > add new

# 0.1.15

1. Resources > translations > add new
2. Service > ResponseService > service that serves responses

# 0.1.14

1. Travis CI > update configuration (You are using the deprecated option "dev". Dev packages are installed by default
now.)
2. Resources > translations > add new

# 0.1.13

1. BaseExtension > allow to define patterns of keys or paths from configuration that should match to stop loading 
parameters (by make getKeysToStopLoadingParametersOn() method protected)

# 0.1.12

1. Configuration > form.novalidate parameter > information if HTML5 inline validation is disabled > make compatible with environment variables and Symfony 3.4
2. Phing > implement missing configuration
3. BaseTwigExtensionTestCase > base test case for Twig extension

# 0.1.11

1. Resources > translations > add new
2. CommonExtension > Twig extension that provides functions and filters for common operations

# 0.1.10

1. Resources > translations > add new

# 0.1.9

1. Docker > improve performance
2. Resources > translations > add new

# 0.1.8

1. Service > FormService > add addFormOptions() method > adds options to the existing options that may be used while creating a form

# 0.1.7

1. Composer > update type > required to fix validation error of recipe (Type must be "symfony-bundle" as the manifest registers a bundle, "library" detected)
2. Update documentation > Configuration

# 0.1.6

1. Update [Readme](README.md)

# 0.1.5

1. Resources > translations > add new
2. Resources > translations > group by destination in each translation domain
3. Tests > verify default configuration parameters > add "defaults" environment
4. Service > FormService > service that serves forms. Configuration > form.novalidate parameter > information if HTML5 
inline validation is disabled.

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
