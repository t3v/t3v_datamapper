CHANGELOG
=========

Notable changes will be documented in this file. The project adheres to [Semantic Versioning].

8.0.0
-----

* Dropped support for TYPO3 8.x
* Updated dependencies
* Updated Travis CI and AppVeyor configuration
* Cleaned up

7.3.2
-----

* Updated Travis CI configuration and dependencies

7.3.1
-----

* Updated Travis CI configuration and dependencies
* Cleaned up

7.3.0
-----

* Updated Composer configuration
* Updated Travis CI and AppVeyor configuration
* Updated dependencies
* Cleaned up

7.2.1
-----

* Updated dependencies

7.2.0
-----

* Improved `AbstractModel` and `PageLanguageOverlayCommandController`
* Introduced `strict` and `fallback` mode (breaking change)
* Moved functionality from `PageService` to `ExtensionService`
* Updated dependencies
* Updated Travis CI and AppVeyor configuration
* Cleaned up

7.1.0
-----

* Updated dependencies
* Updated Travis CI and AppVeyor configuration
* Cleaned up

7.0.1
-----

* Fixed `PageService`

7.0.0
-----

* Improved `PageService`
* Changed TypoScript setting `page.hideNotTranslated` to `mode` (breaking change)

6.0.4
-----

* Improved `PageLanguageOverlayCommandController`

6.0.3
-----

* Updated dependencies
* Cleaned up

6.0.2
-----

* Bugfixing

6.0.1
-----

* Bugfixing

6.0.0
-----

* Changed TypoScript setting `languageOverlay` to `page.hideNotTranslated` (breaking change)
* Refactoring and Type Hinting
* Updated classes
* Improved tests
* Updated AppVeyor configuration
* Cleaned up

5.1.0
-----

* Updated TypoScript structure
* Fixed / improved `PageLanguageOverlayCommandController`
* Updated AppVeyor configuration
* Cleaned up

5.0.0
-----

* Improved `DatabaseService`
* Updated Tests
* Updated Travis CI and AppVeyor configuration
* Updated dependencies
* Dropped support for TYPO3 7.x

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
