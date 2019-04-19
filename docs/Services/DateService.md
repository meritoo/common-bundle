# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# DateService

Located here: `Meritoo\CommonBundle\Service\DateService`. Serves dates.

### Parameters from configuration

Uses parameters:

- date.format.date: `d.m.Y` (default value)
- date.format.datetime: `d.m.Y H:i` (default value)
- date.format.time: `H:i` (default value)

### Methods

##### getDateFormat()

Returns format of date according to given length of date. There are 3 lengths of date:

- date - `Meritoo\CommonBundle\Type\Date\DateLength::DATE` constant
- datetime - `Meritoo\CommonBundle\Type\Date\DateLength::DATETIME` constant
- time - `Meritoo\CommonBundle\Type\Date\DateLength::TIME` constant

Format of date is based on those lengths of date that are stored in application's configuration in these parameters:

- date.format.date
- date.format.datetime
- date.format.time

##### getDateFormatted()

Returns date formatted according to given length of date. Format of date is provided by `getDateFormat()` method (described above).

# More

1. [Configuration](../Configuration.md)
2. [Descriptor of application](../Descriptor-of-application.md)
3. [Descriptor of bundle](../Descriptor-of-bundle.md)
4. [Descriptors of bundles](../Descriptors-of-bundles.md)
5. Services:
    - [ApplicationService](ApplicationService.md)
    - [**DateService**](DateService.md)
    - [FormService](FormService.md)
    - [ResponseService](ResponseService.md)
6. [Tests](../Tests.md)
7. [Translations](../Translations.md)
8. Twig extensions:
    - [ApplicationExtension](../Twig-Extensions/ApplicationExtension.md)
    - [CommonExtension](../Twig-Extensions/CommonExtension.md)
    - [FormExtension](../Twig-Extensions/FormExtension.md)

[&lsaquo; Back to `Readme`](../../README.md)
