Generate WordPress Settings
===========================
**This package is in development and is not suitable for production yet.**

Configuring plugin settings with the WordPress settings API can be a bit tricky.

It's difficult to keep your code DRY, and the relationship between the different functions can be tricky to set up.

It makes sense to register settings the WordPress way because your code may well have to play nicely with other developers who you're never going to meet. It also has to robust enough to survive future WordPress upgrades.

The downside of this is that you need to manage the relationship between `register_setting()`, `add_settings_field()`, `add_settings_section()`, `add_settings_field()`, `settings_fields()`, `do_settings_sections()` etc...just to output a simple form that saves a value to the WP options table.

This package is a first stab at abstracting the settings setup. You just pass in a config file which returns a PHP array. This is used to configure settings.

## Usage
~~~php
$optionsPageConfig = dirname(__FILE__) . '/options-page-config.php';
$menuPageConfig = dirname(__FILE__) . '/menu-page-settings-config.php';
// Settings Page
$optionsPage = new SettingsController;
$optionsPage->setOptionsPageArgs($optionsPageConfig)->initOptionsPage();
~~~

## TODO
Build a fluent interface so you can add settings pages like:

~~~
<?php
$settingsPage = new Carawebs\Settings\SettingsPage($pageData);
$settingsPage->newTab('Social Media')->withSection($sectionData)->withFields($fieldsData);
~~~
