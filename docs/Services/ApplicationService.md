# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# ApplicationService

Located here: `Meritoo\CommonBundle\Service\ApplicationService`. Serves application. Provides methods related to whole application.

### Parameters from configuration

Uses parameters:

- application.version.file_path
- application.name
- application.description

### Methods

##### getDescriptor()

Returns descriptor of application, instance of `Meritoo\CommonBundle\Application\Descriptor` class. Descriptor delivers information about application such as:

1. Name of application
2. Description of application
3. Version of application

# More

1. [Descriptor of application](../Descriptor-of-application.md)
2. [Descriptor of bundle](../Descriptor-of-bundle.md)
3. [Descriptors of bundles](../Descriptors-of-bundles.md)
4. Services:
	- [**ApplicationService**](ApplicationService.md)
	- [FormService](FormService.md)
5. Twig extensions:
	- [ApplicationExtension](../Twig-Extensions/ApplicationExtension.md)
	- [FormExtension](../Twig-Extensions/FormExtension.md)

[&lsaquo; Back to `Readme`](../../README.md)
