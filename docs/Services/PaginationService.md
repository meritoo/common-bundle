# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# PaginationService

Located here: `Meritoo\CommonBundle\Service\PaginationService`. Serves pagination.

### Parameters from configuration

Uses parameters:

- `meritoo_common.pagination.template_path` (default value: `''`)
- `meritoo_common.pagination.per_page` (default value: `null`)
- `meritoo_common.pagination.nearby_current_page_count` (default value: `null`)

### Depends on services

- `twig`: `Twig\Environment`
- `router`: `Symfony\Component\Routing\RouterInterface`

### Methods

##### renderPagination()

Renders pagination using template passed to constructor or via `setTemplatePath()` method

##### isValidPage()

Returns information if given number of page is valid/correct, in other words if page with given number exists

##### Getters and setters()

Used to modify properties of the service

# More

1. [Configuration](../Configuration.md)
2. [Dependency Injection Extension](../Dependency-Injection-Extension.md)
3. [Descriptor of application](../Descriptor-of-application.md)
4. [Descriptor of bundle](../Descriptor-of-bundle.md)
5. [Descriptors of bundles](../Descriptors-of-bundles.md)
6. Services:
    - [ApplicationService](ApplicationService.md)
    - [DateService](DateService.md)
    - [FormService](FormService.md)
    - [**PaginationService**](PaginationService.md)
    - [ResponseService](ResponseService.md)
7. [Tests](../Tests.md)
8. [Translations](../Translations.md)
9. Twig extensions:
    - [ApplicationExtension](../Twig-Extensions/ApplicationExtension.md)
    - [CommonExtension](../Twig-Extensions/CommonExtension.md)
    - [FormExtension](../Twig-Extensions/FormExtension.md)

[&lsaquo; Back to `Readme`](../../README.md)
