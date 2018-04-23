<?php
namespace T3v\T3vDataMapper\Service;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

use T3v\T3vCore\Service\AbstractService;
use T3v\T3vCore\Service\LanguageService;

use T3v\T3vDataMapper\Domain\Model\Page;
use T3v\T3vDataMapper\Domain\Model\Page\LanguageOverlay;
use T3v\T3vDataMapper\Service\DatabaseService;

/**
 * The page service class.
 *
 * @package T3v\T3vDataMapper\Service
 */
class PageService extends AbstractService {
  /**
   * The database service.
   *
   * @var \T3v\T3vDataMapper\Service\DatabaseService
   */
  protected $databaseService;

  /**
   * The language service.
   *
   * @var \T3v\T3vCore\Service\LanguageService
   */
  protected $languageService;

  /**
   * The constructor function.
   */
  public function __construct() {
    parent::__construct();

    $this->databaseService = $this->objectManager->get(DatabaseService::class);
    $this->databaseService->setup();

    $this->languageService = $this->objectManager->get(LanguageService::class);
  }

  /**
   * Gets a page by UID.
   *
   * @param int $uid The UID of the page
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return array The row for the page or empty if no page was found
   */
  public function getPage(int $uid, int $languageUid = null) {
    $languageUid = isset($languageUid) ? $languageUid : $this->$languageService->getLanguageUid();
    $page        = Page::find($uid);

    if ($page) {
      $page              = $page->getAttributes();
      $l18nCfg           = intval($page['l18n_cfg']);
      $settings          = $this->getSettings();
      $hideNotTranslated = (boolean) $settings['page.']['hideNotTranslated'];

      if ($l18nCfg === 1) {
        $page['hidden'] = '1';
      }

      if ($languageUid > 0 && $hideNotTranslated) {
        $overlay = LanguageOverlay::where([['pid', '=', $uid], ['sys_language_uid', '=', $languageUid]])->first();

        if ($overlay) {
          $page = array_merge($page, $overlay->getAttributes());
        }
      }
    }

    return $page;
  }

  /**
   * Alias for `getPage`.
   *
   * @param int $uid The UID of the page
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return array The row for the page or empty if no page was found
   */
  public function getPageByUid(int $uid, int $languageUid = null) {
    $languageUid = isset($languageUid) ? $languageUid : $this->$languageService->getLanguageUid();

    return $this->getPage($uid, $languageUid);
  }

  /**
   * Gets the current page.
   *
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return array The row for the current page or empty if no page was found
   */
  public function getCurrentPage(int $languageUid = null) {
    $languageUid = isset($languageUid) ? $languageUid : $this->$languageService->getLanguageUid();
    $uid         = intval($GLOBALS['TSFE']->id);

    return $this->getPage($uid, $languageUid);
  }

  /**
   * Gets the settings from `plugin.tx_t3vdatamapper.settings`.
   *
   * @return array The settings
   */
  protected function getSettings() {
    $configurationManager = $this->objectManager->get(ConfigurationManagerInterface::class);
    $configuration        = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

    return $configuration['plugin.']['tx_t3vdatamapper.']['settings.'];
  }
}