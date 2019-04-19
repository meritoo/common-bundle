# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# Translations

### Stored at

Located here: `Resources/translations` in `yaml` files, e.g. `Resources/translations/actions.en.yaml`.

### Translation domains

Prefixed by `meritoo_common`. Grouped by translation domain:

- actions, e.g. `actions.en.yaml`
- questions, e.g. `questions.en.yaml`
- titles, e.g. `titles.en.yaml`
- validators, e.g. `validators.en.yaml`
- words, e.g. `words.en.yaml`

### Examples

```twig
{{ 'meritoo_common.version' | trans({}, 'words') }}
```

```twig
{{ 'meritoo_common.remember_me' | trans({}, 'actions') }}
```

# More

1. [Configuration](Configuration.md)
2. [Dependency Injection Extension](Dependency-Injection-Extension.md)
3. [Descriptor of application](Descriptor-of-application.md)
4. [Descriptor of bundle](Descriptor-of-bundle.md)
5. [Descriptors of bundles](Descriptors-of-bundles.md)
6. Services:
    - [ApplicationService](Services/ApplicationService.md)
    - [DateService](Services/DateService.md)
    - [FormService](Services/FormService.md)
    - [ResponseService](Services/ResponseService.md)
7. [Tests](Tests.md)
8. [**Translations**](Translations.md)
9. Twig extensions:
    - [ApplicationExtension](Twig-Extensions/ApplicationExtension.md)
    - [CommonExtension](Twig-Extensions/CommonExtension.md)
    - [FormExtension](Twig-Extensions/FormExtension.md)

[&lsaquo; Back to `Readme`](../README.md)
