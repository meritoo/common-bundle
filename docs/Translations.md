# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# Translations

### Stored at

Located here: `Resources/translations` in `yaml` files, e.g. `Resources/translations/actions.en.yaml`.

### Translation domains

Prefixed by `meritoo_common`. Grouped by translation domain:

- actions, e.g. `actions.en.yaml`
- titles, e.g. `titles.en.yaml`
- words, e.g. `words.en.yaml`

### Examples

```twig
{{ 'meritoo_common.version' | trans({}, 'words') }}
```

```twig
{{ 'meritoo_common.remember_me' | trans({}, 'actions') }}
```

# More

1. [Descriptor of application](Descriptor-of-application.md)
2. [Descriptor of bundle](Descriptor-of-bundle.md)
3. [Descriptors of bundles](Descriptors-of-bundles.md)
4. Services:
	- [ApplicationService](Services/ApplicationService.md)
	- [FormService](Services/FormService.md)
5. [**Translations**](Translations.md)
6. Twig extensions:
	- [ApplicationExtension](Twig-Extensions/ApplicationExtension.md)
	- [FormExtension](Twig-Extensions/FormExtension.md)

[&lsaquo; Back to `Readme`](../README.md)
