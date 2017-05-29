<?php
namespace T3v\T3vDataMapper\Service;

use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

use \T3v\T3vCore\Service\AbstractService;
use \T3v\T3vCore\Service\LanguageService;

use \T3v\T3vDataMapper\Domain\Model\Page;
use \T3v\T3vDataMapper\Domain\Model\Page\LanguageOverlay;
use \T3v\T3vDataMapper\Service\DatabaseService;

/**
 * Page Service Class
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

    $this->configurationManager = $this->objectManager->get('TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface');

    $this->databaseService = $this->objectManager->get('T3v\T3vDataMapper\Service\DatabaseService');
    $this->databaseService->setup();

    $this->languageService = $this->objectManager->get('T3v\T3vCore\Service\LanguageService');
  }

  /**
   * Get a page by UID.
   *
   * @param int $uid The UID of the page
   * @param boolean $languageOverlay If set, the language record (overlay) will be applied
   * @param int $sysLanguageUid The optional system language UID, defaults to the current system language UID
   * @return array The row for the page or empty if no page was found
   */
  public function getPage($uid, $languageOverlay = null, $sysLanguageUid = null) {
    $uid             = intval($uid);
    $languageOverlay = isset($languageOverlay) ? (boolean) $languageOverlay : null;
    $sysLanguageUid  = intval($sysLanguageUid) ?: $this->languageService->getSysLanguageUid();

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

      if ($applyLanguageOverlay && $sysLanguageUid > 0) {
        $overlay = LanguageOverlay::where([['pid', '=', $uid], ['sys_language_uid', '=', $sysLanguageUid]])->first();

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
   * @param int $sysLanguageUid The optional system language UID, defaults to the current system language UID
   * @return array The row for the page or empty if no page was found
   */
  public function getPageByUid($uid, $languageOverlay = null, $sysLanguageUid = null) {
    $uid             = intval($uid);
    $languageOverlay = isset($languageOverlay) ? (boolean) $languageOverlay : null;
    $sysLanguageUid  = intval($sysLanguageUid) ?: $this->languageService->getSysLanguageUid();

    return $this->getPage($uid, $languageOverlay, $sysLanguageUid);
  }

  /**
   * Get the current page.
   *
   * @param boolean $languageOverlay If set, the language record (overlay) will be applied
   * @param int $sysLanguageUid The optional system language UID, defaults to the current system language UID
   * @return array The row for the current page or empty if no page was found
   */
  public function getCurrentPage($languageOverlay = null, $sysLanguageUid = null) {
    $uid             = intval($GLOBALS['TSFE']->id);
    $languageOverlay = isset($languageOverlay) ? (boolean) $languageOverlay : null;
    $sysLanguageUid  = intval($sysLanguageUid) ?: $this->languageService->getSysLanguageUid();

    return $this->getPage($uid, $languageOverlay, $sysLanguageUid);
  }

  /**
   * Helper function to get the settings (`plugin.tx_t3vdatamapper.settings`).
   *
   * @return array The settings
   */
  protected function getSettings() {
    $configuration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

    return $configuration['plugin.']['tx_t3vdatamapper.']['settings.'];
  }
}