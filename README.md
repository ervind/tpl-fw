# tpl-fw
TPL (Tiny Plugin Loom) Framework - a plugin options framework for WordPress

This framework gives you a powerful options/settings management system that lets you set up Plugin Settings screen and Post custom fields / postmeta settings.

## Basic Setup

1. Copy the /framework folder into your WordPress plugin's directory
2. Load the framework with this code into your plugin:
```php
// Where PLUGIN_ROOT_DIR is the root directory of your plugin. You can add a constant for it or use plugin_dir_path()
require_once PLUGIN_ROOT_DIR . 'framework/tpl-fw.php';
```
3. Now you can add Settings Pages, Sections and Options using the TPL backend functions
4. Then, after you added some options, you can see and edit them inside WP-Admin
5. And you can display or use the saved values of the options in your plugin or theme using the TPL frontend functions

## Changelog

### v2.2.1 (2021-03-05)
* JS fixes to make some functions accessible from outside + WYSIWYG editor visual mode loader fix


### v2.2 (2021-02-12)
* Instead of the global $tpl_fw variable, we now use the singleton approach with TPL_FW()
* Sections and Options now can have priorities (used with ordering inside a settings page)
* Better tooltips for combined subitem descriptions
* Options UI fine-tuning
* Now you can hide intro text in TPL Error boxes


### v2.1.1 (2020-08-19)
* Values refresher for Select data type


### v2.1 (2020-08-02)
* Post Data Type: added easy way to generate new posts from templates
* Added Hidden Data Type
* Combined DT can now have multi-level default values


### v2.0 (2020-06-18)
* The PHP codebase was rewritten significantly to follow OOP / Clean Code principles
* Now the framework loads earlier in the sequence - making it possible to use its functions right away after loading it (no need to wait until the init hook any longer)
* Demo options were created in order to make things easier to test
* Improved templating - a move towards being more MVC
* Select2 updated from 4.0.5 to 4.0.13
* Font Awesome updated from 5.2.0 to 5.13.0. Now all icons and variants can be selected from the dropdown
* The working mechanisms of tpl_get_option() and tpl_get_value() were changed, so in some cases you might need to alter your code to work properly with 2.0
* Success message is displayed when options were saved. Finally!
* Tested metaboxes under Gutenberg: TinyMCE might have some isues, but other fields are working fine.


### v1.3.8 (2020-04-23)
* Fixed an issue with admin submenu pages


### v1.3.7 (2020-04-05)
* Fixed an issue with Textarea and TinyMCE fields
* Plugin settings pages can now have unique menu icons


### v1.3.6 (2020-02-05)
* Updated Font Awesome to 5.2
* Fixed Post data type to list all items if no max value present
* Added a URL param standardizer to admin scripts


### v1.3.4 (2019-07-03)
* Made it possible to run the FW code earlier in the hooks


### v1.3.3 (2019-04-17)

* TinyMCE double button line bugfix
* Post type: remove HTML tags from title when using in select
* Minor bugfix in the core for not throwing notice if the options array is empty
* Support for submenu pages


### v1.3.1 (2018-12-07)

* Minor bugfixes after Font Awesome 5 update


---

Original version of this package was the [Themple Framework](https://github.com/ervind/themple), which was a theme framework for WordPress (that was forked from [NUTS](https://github.com/wholegraindigital/nuts)), but now it's development is discontinued.
