[T3v DataMapper]
================

**Bring the [Database] and [Validation] component from [Laravel] to [TYPO3].**

Installation
------------

1. Add `t3v_datamapper` to the [Composer] configuration (`composer.json`)
2. Run `composer install` or `composer update` to install all dependencies with Composer
3. Include the TypoScript for T3v DataMapper in the main TypoScript template

Command
-------

### Page

* [Language Overlay Command Controller]

    * List Command
    * Hide Command
    * Unhide Command

Domain
------

### Model

* [Abstract Model]
* [Page]

#### Page

* [Language Overlay]

Service
-------

* [Database Service]
* [Page Service]

### Validation

* [Validator Service]

View Helpers
------------

* [Page View Helper]

Bug Reports
-----------

GitHub Issues are used for managing bug reports and feature requests. If you run into issues, please search the issues
and submit new problems [here].

Versioning
----------

This library aims to adhere to [Semantic Versioning 2.0.0]. Violations of this scheme should be reported as bugs.
Specifically, if a minor or patch version is released that breaks backward compatibility, that version should be
immediately yanked and / or a new version should be immediately released that restores compatibility.

Credits
-------

[Sven Lahann] for the idea and the first prototype.

The [Laravel] team for the [Database] and [Validation] component.

License
-------

T3v DataMapper is released under the [MIT License (MIT)], see [LICENSE].

[Abstract Model]: https://github.com/t3v/t3v_datamapper/blob/master/Classes/Domain/Model/AbstractModel.php "Abstract Model"
[Database Service]: https://github.com/t3v/t3v_datamapper/blob/master/Classes/Service/DatabaseService.php "Database Service"
[Language Overlay Command Controller]: https://github.com/t3v/t3v_datamapper/blob/master/Classes/Command/Page/LanguageOverlayCommandController.php "Language Overlay Command Controller"
[Language Overlay]: https://github.com/t3v/t3v_datamapper/blob/master/Classes/Domain/Model/Page/LanguageOverlay.php "Language Overlay"
[Page Service]: https://github.com/t3v/t3v_datamapper/blob/master/Classes/Service/PageService.php "Page Service"
[Page View Helper]: https://github.com/t3v/t3v_datamapper/blob/master/Classes/ViewHelpers/PageViewHelper.php "Page View Helper"
[Page]: https://github.com/t3v/t3v_datamapper/blob/master/Classes/Domain/Model/Page.php "Page"
[Validator Service]: https://github.com/t3v/t3v_datamapper/blob/master/Classes/Service/Validation/ValidatorService.php "Validator Service"

[Composer]: https://getcomposer.org "Dependency Manager for PHP"
[Database]: https://github.com/illuminate/database "Illuminate Database component"
[here]: https://github.com/t3v/t3v_datamapper/issues "GitHub Issue Tracker"
[Illuminate]: https://github.com/illuminate "The components that make up the Laravel PHP framework."
[Laravel]: https://laravel.com "The PHP Framework For Web Artisans"
[LICENSE]: https://raw.githubusercontent.com/t3v/t3v_datamapper/master/LICENSE "License"
[MIT License (MIT)]: http://opensource.org/licenses/MIT "The MIT License (MIT)"
[Semantic Versioning 2.0.0]: http://semver.org "Semantic Versioning 2.0.0"
[Sven Lahann]: https://github.com/svenlahann "Sven Lahann at GitHub"
[T3v DataMapper]: https://t3v.github.io/t3v_datamapper/ "Bring the Database and Validation component from Laravel to TYPO3."
[TYPO3]: https://typo3.org "The Enterprise Open Source CMS"
[TYPO3voila]: https://github.com/t3v "“UH LÁLÁ, TYPO3!”"
[Validation]: https://github.com/illuminate/validation "Illuminate Validation component"