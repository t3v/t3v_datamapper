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
   * The configuration manager.
   *
   * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
   */
  protected $configurationManager;

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
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();

    $this->configurationManager = $this->objectManager->get(ConfigurationManagerInterface::class);

    $this->databaseService = $this->objectManager->get(DatabaseService::class);
    $this->databaseService->setup();

    $this->languageService = $this->objectManager->get(LanguageService::class);
  }

  /**
   * Get a page by UID.
   *
   * @param int $uid The UID of the page
   * @param boolean $languageOverlay If set, the language record (overlay) will be applied
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return array The row for the page or empty if no page was found
   */
  public function getPage($uid, $languageOverlay = null, $languageUid = null) {
    $uid             = intval($uid);
    $languageOverlay = isset($languageOverlay) ? (boolean) $languageOverlay : null;
    $languageUid     = isset($languageUid) ? intval($languageUid) : $this->$languageService->getLanguageUid();

    $settings             = $this->getSettings();
    $applyLanguageOverlay = (boolean) $settings['languageOverlay'];

    if (isset($languageOverlay)) {
      $applyLanguageOverlay = $languageOverlay;
    }

    $page = Page::find($uid);

    if ($page) {
      $page    = $page->getAttributes();
      $l18nCfg = intval($page['l18n_cfg']);

      if ($l18nCfg === 1) {
        $page['hidden'] = '1';
      }

      if ($applyLanguageOverlay && $languageUid > 0) {
        $overlay = LanguageOverlay::where([['pid', '=', $uid], ['sys_language_uid', '=', $languageUid]])->first();

        if ($overlay) {
          $overlay = $overlay->getAttributes();

          $page = array_merge($page, $overlay);
        }
      }
    }

    return $page;
  }

  /**
   * Alias for `getPage`.
   *
   * @param int $uid The UID of the page
   * @param boolean $languageOverlay If set, the language record (overlay) will be applied
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return array The row for the page or empty if no page was found
   */
  public function getPageByUid($uid, $languageOverlay = null, $languageUid = null) {
    $uid             = intval($uid);
    $languageOverlay = isset($languageOverlay) ? (boolean) $languageOverlay : null;
    $languageUid     = isset($languageUid) ? intval($languageUid) : $this->$languageService->getLanguageUid();

    return $this->getPage($uid, $languageOverlay, $languageUid);
  }

  /**
   * Get the current page.
   *
   * @param boolean $languageOverlay If set, the language record (overlay) will be applied
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return array The row for the current page or empty if no page was found
   */
  public function getCurrentPage($languageOverlay = null, $languageUid = null) {
    $uid             = intval($GLOBALS['TSFE']->id);
    $languageOverlay = isset($languageOverlay) ? (boolean) $languageOverlay : null;
    $languageUid     = isset($languageUid) ? intval($languageUid) : $this->$languageService->getLanguageUid();

    return $this->getPage($uid, $languageOverlay, $languageUid);
  }

  /**
   * Helper function to get the settings from `plugin.tx_t3vdatamapper.settings`.
   *
   * @return array The settings
   */
  protected function getSettings() {
    $configuration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

    return $configuration['plugin.']['tx_t3vdatamapper.']['settings.'];
  }
}