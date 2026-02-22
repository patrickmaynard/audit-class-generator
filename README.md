Audit class generator
================

This simple package adds pseudorandomized audit tags to your Twig html class definitions.

This can be useful if you don't have traditional debugging tools available. 

By seeing a short, pseudorandom audit tag among the classes applied to an html element, 
you can quickly determine exactly which Twig template the html element came from. 

That can save significant debugging time, since you don't have to guess at which Twig
template to modify for a given task.  

In other words, if you can view the source in a browser, you can now grep definitively 
for any HTML tag that already has a "class" attribute, finding exactly which Twig 
template generated that DOM element. Pretty neat!  

## Installation

To install this tool as a dev dependency:

```
composer require --dev patrick-maynard/audit-class-generator
```

Installing this in a production environment is not recommended. 

## Usage

> ⚠️ **Warning:** Always create a new Git branch before running this tool. Otherwise, you may accidentally commit the generated audit classes to your production branch.

Once the tool has been installed, you can run it directly from Composer’s `vendor/bin`

```bash
vendor/bin/audit-class-generator
```

This will apply temporary audit classes to any Twig HTML elements that already have a "class" attribute defined.

Then view the source of the page you want to debug in a browser. You'll see that any tag that already had a "class" attribute now has a unique, pseudorandom class like `audit_34f39d` appended to the class list.


Just grep for that audit class, and you'll find the Twig template you want in a jiffy. 

Happy debugging!
