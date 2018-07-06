Changelog
=========

Notable changes will be documented in this file. The project adheres to [Semantic Versioning].

Unreleased
----------

* Changed TypoScript setting `page.hideNotTranslated` to `mode` (breaking change)
* Improved `PageService`

4.6.4
-----

* Improved `PageLanguageOverlayCommandController`

4.6.3
-----

* Cleaned up

4.6.2
-----

* Bugfixing

4.6.1
-----

* Bugfixing

4.6.0
-----

* Changed TypoScript setting `languageOverlay` to `page.hideNotTranslated` (breaking change)
* Refactoring and Type Hinting
* Updated classes
* Improved tests
* Updated AppVeyor configuration
* Cleaned up

4.5.0
-----

* Fixed / improved `PageLanguageOverlayCommandController`
* Updated AppVeyor configuration
* Cleaned up

4.4.0
-----

* Cleaned up `DatabaseService`
* Updated Tests
* Updated Travis CI and AppVeyor configuration
* Updated dependencies
* Updated constraints to TYPO3 7.6

4.3.0
-----

* Updated TypoScript
* Cleaned up

4.2.0
-----

* Updated Composer configuration and scripts
* Updated Travis CI and AppVeyor configuration
* Updated dependencies

4.1.0
-----

* Updated TypoScript
* Updated dependencies
* Fixed functional tests
* Updated AppVeyor configuration

4.0.0
-----

* Refactored TypoScript
* Updated constants and configuration
* Merged Extensions and Vendor TypoScript
* Fixed Command Controller registration (`PageLanguageOverlayCommandController`)
* Updated AppVeyor configuration
* Updated dependencies
* Dropped support for PHP 5.x

3.0.0
-----

* Renamed `Page\LanguageOverlayCommandController` to `PageLanguageOverlayCommandController`
* Updated Travis CI and AppVeyor configuration

2.3.1
-----

* Updated database fixtures
* Updated dependencies
* Updated AppVeyor configuration

2.3.0
-----

* Streamlined `getConnection` in `DatabaseService`
* Added configuration option for driver used in the Laravel Capsule instance
* Formatted code and cleanup
* Updated Composer configuration
* Updated AppVeyor configuration

2.2.2
-----

* Reformatted code and cleanup

2.2.1
-----

* Updated dependencies
* Updated Travis CI and AppVeyor configuration
* Cleaned up

2.2.0
-----

* Improved `PageViewHelper`, `HiddenViewHelper` and `VisibleViewHelper`
* Improved `PageService`

2.1.0
-----

* Added `HiddenViewHelper` and `VisibleViewHelper`
* Improved `PageService`
* Defined namespace in `ext_localconf` and `ext_tables`
* Updated extension icon
* Updated code comments
* Updated scripts

2.0.1
-----

* Updated Composer configuration

2.0.0
-----

* Compatibility for TYPO3 8.7
* Added configuration for AppVeyor
* Use `nimut/testing-framework` as testing framework

1.0.2
-----

* Updated Composer dependencies
* Updated scripts

1.0.1
-----

* Bugfixing

1.0.0
-----

* First release
* Improved `PageService` and `PageViewHelper`
* Configured Travis CI
* Added unit and functional tests
* Updated Composer configuration / dependencies
* Updated naming and claim
* Updated comments
* Cloned from T3v Illuminate

[Semantic Versioning]: http://semver.org "Semantic Versioning"