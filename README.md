LaBlog - A Simple Laravel 4 Bloging System
==========================================

Currently there is no readme as the project is in very VERY early stages of development.

If anyone would be interested to learn more about the project or would be interesting in becoming a contributor or tester, please feel free to email me at joe@joescode.co.uk

Please stay tuned for updates!

Looking for Developers
----------------------

Interested on working on constributing to this project? Feel free to drop me an email and let me know. Or stay tuned for the alpha or beta releases to join in.

Install
-------

Add following service providers to laravel 4 app config.

```php
...
'Lablog\Lablog\LablogServiceProvider',
'TwigBridge\TwigServiceProvider'
...
```

Create folder in app directory.

`app/lablog`

ToDo
----

- Create 'pass-to-template' system to register plugins in service provider and pass an object into the specified template.
- Create lablog/stringy to adapt stringy/stringy to be passed into twig template.
    - Look into twig extensions for stringy adaption.
- Add options to change content processor.
    - Markdown
    - HTML
