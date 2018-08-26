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
2. [Descriptor of application](../Descriptor-of-application.md)
3. [Descriptor of bundle](../Descriptor-of-bundle.md)
4. [Descriptors of bundles](../Descriptors-of-bundles.md)
5. Services:
	- [ApplicationService](../Services/ApplicationService.md)
	- [FormService](../Services/FormService.md)
6. [Translations](../Translations.md)
7. Twig extensions:
	- [ApplicationExtension](ApplicationExtension.md)
	- [**CommonExtension**](CommonExtension.md)
	- [FormExtension](FormExtension.md)

[&lsaquo; Back to `Readme`](../../README.md)
