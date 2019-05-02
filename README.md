# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

[![PHP Version](https://img.shields.io/badge/php-%5E7.2-blue.svg?style=flat-square)](https://img.shields.io/badge/php-%5E7.2-blue.svg)
[![Build Status](https://travis-ci.com/meritoo/common-bundle.svg?style=flat-square&branch=master)](https://travis-ci.com/meritoo/common-bundle)
[![Packagist](https://img.shields.io/packagist/v/meritoo/common-bundle.svg?style=flat-square)](https://packagist.org/packages/meritoo/common-bundle)
[![license](https://img.shields.io/github/license/meritoo/common-bundle.svg?style=flat-square)](https://github.com/meritoo/common-bundle)
[![GitHub commits](https://img.shields.io/github/commits-since/meritoo/common-bundle/0.0.1.svg?style=flat-square)](https://github.com/meritoo/common-bundle)
[![Coverage Status](https://coveralls.io/repos/github/meritoo/common-bundle/badge.svg?branch=master&style=flat-square)](https://coveralls.io/github/meritoo/common-bundle)

# Installation

Run [Composer](https://getcomposer.org) to install this package in your project:

```bash
composer require meritoo/common-bundle
```

> [How to install Composer?](https://getcomposer.org/download)

# Configuration

All parameters have default values. After installation of this bundle, you have to do nothing. If you want to tweak 
some of parameters, create proper configuration file and enter desired parameters.

Example:

```yaml
# config/packages/meritoo_common.yaml

meritoo_common:
    application:
        name: YourApp
```

[Read more](docs/Configuration.md)

# Usage

1. [Configuration](docs/Configuration.md)
2. [Dependency Injection Extension](docs/Dependency-Injection-Extension.md)
3. [Descriptor of application](docs/Descriptor-of-application.md)
4. [Descriptor of bundle](docs/Descriptor-of-bundle.md)
5. [Descriptors of bundles](docs/Descriptors-of-bundles.md)
6. Services:
    - [ApplicationService](docs/Services/ApplicationService.md)
    - [FormService](docs/Services/FormService.md)
    - [ResponseService](docs/Services/ResponseService.md)
7. [Tests](docs/Tests.md)
8. [Translations](docs/Translations.md)
9. Twig extensions:
    - [ApplicationExtension](docs/Twig-Extensions/ApplicationExtension.md)
    - [CommonExtension](docs/Twig-Extensions/CommonExtension.md)
    - [FormExtension](docs/Twig-Extensions/FormExtension.md)

# Development

More information [you can find here](docs/Development.md)
