# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# CommonExtension

Located here: `Meritoo\CommonBundle\Twig\CommonExtension`. It's Twig extension that provides functions and filters for common operations.

### Filters

##### meritoo_common_empty_value

Verifies/Filters given value if is empty. Returns replacement of empty value if given value is empty. Otherwise - given value.

Example below.

```twig
<p>First name: {{ first_name | meritoo_common_empty_value }}</p>
```

Result:

```twig
<p>First name: -</p>
```

# More

1. [Configuration](../Configuration.md)
2. [Dependency Injection Extension](../Dependency-Injection-Extension.md)
3. [Descriptor of application](../Descriptor-of-application.md)
4. [Descriptor of bundle](../Descriptor-of-bundle.md)
5. [Descriptors of bundles](../Descriptors-of-bundles.md)
6. Services:
    - [ApplicationService](../Services/ApplicationService.md)
    - [DateService](../Services/DateService.md)
    - [FormService](../Services/FormService.md)
    - [ResponseService](../Services/ResponseService.md)
7. [Tests](../Tests.md)
8. [Translations](../Translations.md)
9. Twig extensions:
    - [ApplicationExtension](ApplicationExtension.md)
    - [**CommonExtension**](CommonExtension.md)
    - [FormExtension](FormExtension.md)

[&lsaquo; Back to `Readme`](../../README.md)
