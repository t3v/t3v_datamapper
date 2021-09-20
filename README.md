[T3v DataMapper]
================

**The Data Mapper extension of TYPO3voilà.**

Brings the [Database] and [Validation] magic from [Laravel] to [TYPO3].

Dependencies
------------

* TYPO3 CMS 9.5 or greater
* PHPLucidFrame ConsoleTable library
* Illuminate Database component
* Illuminate Validation component
* T3v Core extension

Installation
------------

1. Add T3v DataMapper as dependency to the [Composer] configuration
2. Run `composer install` or `composer update` to install all dependencies with Composer
3. Include the TypoScript for T3v DataMapper

Domain
------

### Model

* Page

Service
-------

* Database Service
* Page Service

### Validation

* Validator Service

View Helpers
------------

* Page View Helper

Development
-----------

### Setup

```sh
git clone https://github.com/t3v/t3v_datamapper.git && cd t3v_datamapper

./Scripts/Setup.sh
```

### Testing

```sh
./Scripts/Tests.sh
./Scripts/Tests/Unit.sh
./Scripts/Tests/Functional.sh
./Scripts/Tests/Maintenance.sh
```

Bug Reports
-----------

GitHub Issues are used for managing bug reports and feature requests. If you run into issues, please search the issues and submit new
problems [here].

Versioning
----------

This project aims to adhere to [Semantic Versioning 2.0.0]. Violations of this scheme should be reported as bugs. Specifically, if a minor
or patch version is being released that breaks backward compatibility, that version should be immediately yanked and / or a new version
should be immediately released that restores compatibility.

Credits
-------

[Sven Lahann] for the idea and the first prototype.

The [Laravel] team for the [Database] and [Validation] component.

License
-------

T3v DataMapper is released under the [MIT License (MIT)], see [LICENSE].

[Acceptance testing TYPO3]: https://wiki.typo3.org/Acceptance_testing "Acceptance testing TYPO3"
[Automated testing TYPO3]: https://wiki.typo3.org/Automated_testing "Automated testing TYPO3"
[Composer]: https://getcomposer.org "Dependency Manager for PHP"
[Database]: https://github.com/illuminate/database "Illuminate Database component"
[Functional testing TYPO3]: https://wiki.typo3.org/Functional_testing "Functional testing TYPO3"
[here]: https://github.com/t3v/t3v_datamapper/issues "GitHub Issue Tracker"
[Illuminate]: https://github.com/illuminate "The components that make up the Laravel PHP framework."
[Laravel]: https://laravel.com "The PHP Framework For Web Artisans"
[LICENSE]: https://raw.githubusercontent.com/t3v/t3v_datamapper/master/LICENSE "License"
[MIT License (MIT)]: http://opensource.org/licenses/MIT "The MIT License (MIT)"
[Semantic Versioning 2.0.0]: http://semver.org "Semantic Versioning 2.0.0"
[Sven Lahann]: https://github.com/svenlahann "Sven Lahann at GitHub"
[T3v DataMapper]: https://t3v.github.io/t3v_datamapper/ "The Data Mapper extension of TYPO3voilà."
[TYPO3]: https://typo3.org "The Enterprise Open Source CMS"
[TYPO3voilà]: https://github.com/t3v "“UH LÁLÁ, TYPO3!”"
[Unit Testing TYPO3]: https://wiki.typo3.org/Unit_Testing_TYPO3 "Unit testing TYPO3"
[Validation]: https://github.com/illuminate/validation "Illuminate Validation component"
