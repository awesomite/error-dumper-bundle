# ErrorDumperBundle

Integrates [awesomite/error-dumper](https://github.com/awesomite/error-dumper) into your Symfony application

## Why?

To display easy to debug stack trace (**[see example](https://awesomite.github.io/error-dumper/examples/exception.html)**).

## Installation

First of all add library to the project:

```bash
composer require awesomite/error-dumper-bundle
```

Then register bundle in `AppKernel::registerBundles`:

```php
if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
    $bundles[] = new \Awesomite\ErrorDumperBundle\AwesomiteErrorDumperBundle();
}
```

## IDE integration

Define value of [framework.ide](http://symfony.com/doc/current/reference/configuration/framework.html#ide).
Functions and numbers of lines will be links to source code in your IDE.
