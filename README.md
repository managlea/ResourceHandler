# ResourceHandler
Package to provide wrapper for handling resources (resource as in RESTful APIs etc)

[![Build Status](https://scrutinizer-ci.com/g/managlea/ResourceHandler/badges/build.png?b=master)](https://scrutinizer-ci.com/g/managlea/ResourceHandler/build-status/master) [![Code Coverage](https://scrutinizer-ci.com/g/managlea/ResourceHandler/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/managlea/ResourceHandler/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/managlea/ResourceHandler/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/managlea/ResourceHandler/?branch=master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/39e46ddc-da95-4449-a104-616a1f55dde9/mini.png)](https://insight.sensiolabs.com/projects/39e46ddc-da95-4449-a104-616a1f55dde9)
## Basic usage
Read more about packages which are required by ResourceHandler
* [Managlea/ResourceMapper](https://github.com/managlea/ResourceMapper) - for mapping resources to objects
* [Managlea/EntityManager](https://github.com/managlea/EntityManager) - for getting objects from DB
```php
// Create new EntityManagerFactory (instanceof Managlea\Component\EntityManagerFactoryInterface)
$entityManagerFactory = new EntityManagerFactory();

// Create new ResourceMapper by passing $entityManagerFactory in as parameter
$resourceMapper = ResourceMapper::initialize($entityManagerFactory);


// Create new resourceHandler (by passing correct resourceMapper in as parameter)
$resourceHandler = ResourceHandler::initialize($resourceMapper);

// Get single foo object with id 1
$foo = $resourceHandler->getSingle('foo', 1);

// Get collection of foos (by default 20 items, without any filters)
$fooCollection = $resourceHandler->getCollection('foo');
```
