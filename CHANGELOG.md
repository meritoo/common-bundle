# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# 0.5.4

1. Add the "File" translation

# 0.5.3

1. Add the "Settings" translation

# 0.5.2

1. Add translations
    - Category
    - Photography
    - Configuration
    - Created at
    - Updated at

# 0.5.1

1. The "Back to" translation

# 0.5.0

1. Support Symfony `7.2.*`

# 0.4.0

1. Support Symfony `5.4`
2. Pluralization in
   translations [using the ICU MessageFormat](https://symfony.com/doc/current/reference/formats/message_format.html#pluralization)
3. Update the `meritoo/common-library` package to `^1.3`
4. Fix PHPStan errors
5. Bump minimum PHP version: `8.0` -> `8.2`
    1. All the `*Type` classes, that extend `Meritoo\Common\Type\Base\BaseType` class, have been replaced by
       enumerations

       | Before                                                                | After                                                   |
                                                                                                               |-----------------------------------------------------------------------|---------------------------------------------------------|
       | `Meritoo\CommonBundle\Type\DependencyInjection\ConfigurationFileType` | `Meritoo\CommonBundle\Enums\Date\ConfigurationFileType` |
       | `Meritoo\CommonBundle\Type\Date\DateLength`                           | `Meritoo\CommonBundle\Enums\Date\DateLength`            |
       | `Meritoo\Common\Type\OopVisibilityType`                               | `Meritoo\Common\Enums\OopVisibility`                    |

    2. Other than that:
        - The following classes have been removed as not needed anymore:
            - `Meritoo\CommonBundle\Exception\Type\Date\UnknownDateLengthException`
            - `Meritoo\CommonBundle\Exception\Type\DependencyInjection\UnknownConfigurationFileTypeException`
            - `Meritoo\Test\CommonBundle\DependencyInjection\Base\BaseExtension\UnknownServicesFileType\Extension`

# 0.3.1

1. Create `Meritoo\CommonBundle\Traits\Test\Entity\EntityTestCaseTrait::dropDatabase()` method for removing whole
   database in PHPUnit tests

# 0.3.0

1. Support PHP 8.0+

# 0.2.15

1. Create a service for a carousel, the `CarouselService`

# 0.2.14

1. Support `symfony/form` package with `4.4.*` version too

# 0.2.13

1. Create a service for a form, the `FormService`

# 0.2.12

1. Create a service for a menu, the `MenuService`

# 0.2.11

1. Documentation for the `PaginationService` service
2. Make the `PaginationService` service configurable via Container's parameters

# 0.2.9

1. Create `RequestService::isCurrentRoute()` method that returns information if given route is the current route
2. [Pagination] If there is no data, 1st page is allowed/valid only

# 0.2.8

1. Rename method `FormService::addFormOptions()` -> `FormService::addHtml5ValidationOptions()`
2. Fix failed tests of the `Descriptors` class (collection of `Descriptor`)
3. Add new translations

# 0.2.7

1. Mark PHPUnit test as risky when it does not have a `@covers` annotation
2. Return an empty string and empty array respectively while fetching route and route parameters by the
   `RequestService` service (if there is no value in current request)

# 0.2.6

1. Make the `RequestService` service available for controllers inheriting from `BaseController`

# 0.2.5

1. Use `RequestServiceInterface` for type hinting of the `RequestService` service

# 0.2.4

1. Implement 3 new methods in the `RequestService` service:
    - `getCurrentRoute(): string`
    - `getCurrentRouteParameters(): array`
    - `getParameter(string $parameter)`
2. Set version of `PHP` to `7.2+` in `composer.json`
3. Change mode of `Xdebug` to `coverage` in Docker's configuration to make it possible to generate code coverage by
   `PHPUnit`

# 0.2.3

1. Use `meritoo/php` Docker image (instead of deprecated `meritoo/php7`)
2. Use PHP `7.4` while running build in Travis CI
3. Ability to pass custom `<meta>` tags in the `html5_boilerplate.html.twig` template

# 0.2.2

1. Allow installing of [twig/twig](https://packagist.org/packages/twig/twig) package with `2.1` version too
   (`^2.1|^3.2` vs `^3.2` only)
2. Use PHP `7.4` while running build in Travis CI

# 0.2.1

1. Do not install `hirak/prestissimo` package while running Travis CI (incompatible with your PHP version, PHP
   extensions and Composer version)

# 0.2.0

1. Upgrade Symfony to `5.0` (from `4.1`)

# 0.1.34

1. Add new translations

# 0.1.33

1. Add new translations

# 0.1.32

1. Add new translations

# 0.1.31

1. Upgrade HTML5 Boilerplate by using Starter Template prepared by latest Bootstrap (version 4.4)
2. Rename blocks in HTML5 Boilerplate: stylesheet -> stylesheets, javascript_head -> javascripts_head
3. Add new translations
4. The Pagination. Represents core parameters used to serve pagination.

# 0.1.30

1. Add new translations
2. Implement [phpspec](http://www.phpspec.net)
3. Add new translations

# 0.1.29

1. Resources > translations > add new

# 0.1.28

1. Add new translations (Picture, Photo)
2. Add test of bundle's Descriptors when each Descriptor has the same root namespace (only the last one will be
   available)
3. Allow to drop database schema by the trait for entity test case (the EntityTestCaseTrait)
4. Test case for the trait for entity test case (the EntityTestCaseTrait)

# 0.1.27

1. PHP CS Fixer > configuration > make more readable & remove unnecessary code
2. Update .gitignore, docker-compose.yml, phpunit.xml.dist
3. Trait for test case related to entity (the EntityTestCaseTrait)

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
2. Validator > date > date that should be: earlier than today, earlier than or equal today, later than today, later than
   or equal today

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

1. Configuration > form.novalidate parameter > information if HTML5 inline validation is disabled > make compatible with
   environment variables and Symfony 3.4
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

1. Service > FormService > add addFormOptions() method > adds options to the existing options that may be used while
   creating a form

# 0.1.7

1. Composer > update type > required to fix validation error of recipe (Type must be "symfony-bundle" as the manifest
   registers a bundle, "library" detected)
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
19. Remove `Version` class (Value Object > Version of software). Use `Version` class from `meritoo/common-library`
    package.
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
