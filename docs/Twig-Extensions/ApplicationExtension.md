# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# ApplicationExtension

Located here: `Meritoo\CommonBundle\Twig\ApplicationExtension`. It's Twig extension related to the [ApplicationService service](../Services/ApplicationService.md). Allows to use functionality provided by the `ApplicationService` service in Twig templates.

### Functions

##### meritoo_common_application_descriptor()

Returns descriptor of application. Exactly as `Meritoo\CommonBundle\Service\ApplicationService::getDescriptor()` method.

Example below.

Name of application may be defined in `config/packages/meritoo_common.yaml` configuration file:

```yaml
meritoo_common:
    application:
        name: My App
```

Let's display name of application:

```twig
<title>{{ meritoo_common_application_descriptor().name }}</title>
```

Result:

```twig
<title>My App</title>
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
	- [**ApplicationExtension**](ApplicationExtension.md)
	- [FormExtension](FormExtension.md)

[&lsaquo; Back to `Readme`](../../README.md)
