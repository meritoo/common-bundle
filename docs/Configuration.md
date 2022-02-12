# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# Configuration

### All parameters of this bundle with default values

```yaml
meritoo_common:
    application:
        version
            file_path: '%kernel.project_dir%/VERSION'
        name: ''
        description: ''
        empty_value_replacement: '-'
    form:
        novalidate: false
    date:
        format:
            date: d.m.Y
            datetime: d.m.Y H:i
            time: H:i
```

### Available parameters

* meritoo_common.application.version.file_path

  > Path of a file who contains version of the application.

  Default value: `%kernel.project_dir%/VERSION`.

* meritoo_common.application.name

  > Name of application. May be displayed near logo.

  Default value: `""`

* meritoo_common.application.description

  > Description of application. May be displayed near logo.

  Default value: `""`

* meritoo_common.application.empty_value_replacement

  > Replacement of empty value. May be used to filter values in templates/views.

  Default value: `"-"`

* meritoo_common.form.novalidate

  > Information if HTML5 inline validation is disabled

  Default value: `false`

* meritoo_common.date.format.date

  > Format of date without time

  Default value: `d.m.Y`

* meritoo_common.date.format.datetime

  > Format of date with time

  Default value: `d.m.Y H:i`

* meritoo_common.date.format.time

  > Format of time without date

  Default value: `H:i`

# More

1. [**Configuration**](Configuration.md)
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
8. [Translations](Translations.md)
9. Twig extensions:
    - [ApplicationExtension](Twig-Extensions/ApplicationExtension.md)
    - [CommonExtension](Twig-Extensions/CommonExtension.md)
    - [FormExtension](Twig-Extensions/FormExtension.md)

[&lsaquo; Back to `Readme`](../README.md)
