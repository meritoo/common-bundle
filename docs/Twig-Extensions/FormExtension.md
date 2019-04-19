# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# FormExtension

Located here: `Meritoo\CommonBundle\Twig\FormExtension`. It's Twig extension related to the [FormService service](../Services/FormService.md). Allows to use functionality provided by the `FormService` service in Twig templates.

### Functions

##### meritoo_common_form_is_html5_validation_enabled()

Returns information if HTML5 inline validation is enabled. Exactly as `Meritoo\CommonBundle\Service\FormService::isHtml5ValidationEnabled()` method.

The HTML5 validation may be enabled or disabled in `config/packages/meritoo_common.yaml` configuration file. By default is enabled.

Example below:

```yaml
meritoo_common:
    form:
        novalidate: true
```

```twig
<form{% if not meritoo_common_form_is_html5_validation_enabled() %} novalidate{% endif %}>
    {# ... #}
</form>
```

Result:

```twig
<form novalidate>
    {# ... #}
</form>
```

# More

1. [Configuration](../Configuration.md)
2. [Descriptor of application](../Descriptor-of-application.md)
3. [Descriptor of bundle](../Descriptor-of-bundle.md)
4. [Descriptors of bundles](../Descriptors-of-bundles.md)
5. Services:
    - [ApplicationService](../Services/ApplicationService.md)
    - [DateService](../Services/DateService.md)
    - [FormService](../Services/FormService.md)
    - [ResponseService](../Services/ResponseService.md)
6. [Tests](../Tests.md)
7. [Translations](../Translations.md)
8. Twig extensions:
    - [ApplicationExtension](ApplicationExtension.md)
    - [CommonExtension](CommonExtension.md)
    - [**FormExtension**](FormExtension.md)

[&lsaquo; Back to `Readme`](../../README.md)
