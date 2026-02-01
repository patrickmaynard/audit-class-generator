Audit class generator
================

This simple package adds pseudorandomized audit tags to your Twig html class definitions.

This can be useful if you don't have traditional debugging tools available. 

By seeing a short, pseudorandom audit tag among the classes applied to an html element, 
you can quickly determine exactly which Twig template the html element came from. 

That can save significant debugging time, since you don't have to guess at which Twig
template to modify for a given task.  

## Installation

To install this tool as a dev dependency:

```
composer require --dev patrick-maynard/audit-class-generator
```

Installing this in a production environment is not recommended. 

## Usage

One the tool has been installed, you can use the following command to open a new
git branch and apply the temporary audit classes to any Twig html elements that 
already have a "class" attribute defined. 

```
vendor/patrick-maynard/audit-class-generator/apply.php
``` 

Happy debugging!
