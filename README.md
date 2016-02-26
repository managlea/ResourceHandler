# ResourceHandler
Package to provide wrapper for handling resources (resource as in RESTful APIs etc)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/managlea/ResourceHandler/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/managlea/ResourceHandler/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/managlea/ResourceHandler/badges/build.png?b=master)](https://scrutinizer-ci.com/g/managlea/ResourceHandler/build-status/master) [![Code Coverage](https://scrutinizer-ci.com/g/managlea/ResourceHandler/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/managlea/ResourceHandler/?branch=master)  
[![Code Climate](https://codeclimate.com/github/managlea/ResourceHandler/badges/gpa.svg)](https://codeclimate.com/github/managlea/ResourceHandler) [![Test Coverage](https://codeclimate.com/github/managlea/ResourceHandler/badges/coverage.svg)](https://codeclimate.com/github/managlea/ResourceHandler/coverage)  
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/39e46ddc-da95-4449-a104-616a1f55dde9/mini.png)](https://insight.sensiolabs.com/projects/39e46ddc-da95-4449-a104-616a1f55dde9)  
[![Codacy Badge](https://api.codacy.com/project/badge/grade/0d97db45677b41ae8e941ebf99d1f7e0)](https://www.codacy.com/app/Managlea/ResourceHandler)
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
