<?php
namespace T3v\T3vDataMapper\Service;

use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
   * The page doktypes.
   */
  const PAGE_DOKTYPES = [1, 2];

  /**
   * The page language overlay attributes.
   */
  const PAGE_LANGUAGE_OVERLAY_ATTRIBUTES = [
    'abstract',
    'author',
    'author_email',
    'crdate',
    'description',
    'doktype',
    'endtime',
    'hidden',
    'keywords',
    'nav_title',
    'starttime',
    'subtitle',
    'title',
    'tstamp',
    'tx_realurl_pathsegment',
    'tx_t3vpage_claim',
    'tx_t3vpage_outline',
    'tx_t3vpage_summary'
  ];

  /**
   * The preview mode.
   */
  const PREVIEW_MODE = 'preview';

  /**
   * The query generator.
   *
   * @var \TYPO3\CMS\Core\Database\QueryGenerator
   */
  protected $queryGenerator;

  /**
   * The language service.
   *
   * @var \T3v\T3vCore\Service\LanguageService
   */
  protected $languageService;

  /**
   * The database service.
   *
   * @var \T3v\T3vDataMapper\Service\DatabaseService
   */
  protected $databaseService;

  /**
   * The constructor function.
   */
  public function __construct() {
    parent::__construct();

    $this->queryGenerator  = $this->objectManager->get(QueryGenerator::class);
    $this->languageService = $this->objectManager->get(LanguageService::class);
    $this->databaseService = $this->objectManager->get(DatabaseService::class);

    $this->databaseService->setup();
  }

  /**
   * Gets the current page.
   *
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return array|null The row for the current page or null if no page was found
   */
  public function getCurrentPage(int $languageUid = null) {
    $uid = intval($GLOBALS['TSFE']->id);

    return $this->getPage($uid, $languageUid);
  }

  /**
   * Gets a page.
   *
   * @param int $uid The UID of the page
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return array|null The row for the page or null if no page was found
   */
  public function getPage(int $uid, int $languageUid = null) {
    $page   = null;
    $record = Page::find($uid);

    if ($record) {
      $record = $record->getAttributes();

      if (is_array($record) && !empty($record) && in_array($record['doktype'], self::PAGE_DOKTYPES)) {
        $page                  = $record;
        $l18nCfg               = isset($page['l18n_cfg']) ? $page['l18n_cfg'] : 0;
        $hideIfDefaultLanguage = (boolean) GeneralUtility::hideIfDefaultLanguage($l18nCfg);
        $hideIfNotTranslated   = (boolean) GeneralUtility::hideIfNotTranslated($l18nCfg);
        $languageUid           = isset($languageUid) ? $languageUid : $this->languageService->getLanguageUid();

        if ($hideIfDefaultLanguage) {
          $page['hidden'] = 1;
        }

        if ($languageUid > 0) {
          $constraints     = [['pid', '=', $uid], ['sys_language_uid', '=', $languageUid], ['deleted', '=', 0]];
          $languageOverlay = LanguageOverlay::where($constraints)->first();

          if ($languageOverlay) {
            $languageOverlayAttributes = [];
            $attributes                = $languageOverlay->getAttributes();

            foreach (self::PAGE_LANGUAGE_OVERLAY_ATTRIBUTES as $attribute) {
              if (!empty($attributes[$attribute])) {
                $languageOverlayAttributes[$attribute] = $attributes[$attribute];
              }
            }

            $page = array_merge($page, $languageOverlayAttributes);

            if ($this->previewMode() && !$hideIfDefaultLanguage && !$hideIfNotTranslated) {
              $page['hidden'] = 0;
            }
          }
        }
      }
    }

    return $page;
  }

  /**
   * Gets a page by UID.
   *
   * Alias for `getPage`.
   *
   * @param int $uid The UID of the page
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return array|null The row for the page or null if no page was found
   */
  public function getPageByUid(int $uid, int $languageUid = null) {
    return $this->getPage($uid, $languageUid);
  }

  /**
   * Gets pages.
   *
   * @param array|string $uids The UIDs as array or as string, seperated by `,`
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return array The pages or empty if no pages were found
   */
  public function getPages($uids, int $languageUid = null): array {
    $pages = [];

    if (is_string($uids)) {
      $uids = GeneralUtility::intExplode(',', $uids, true);
    }

    if ($uids) {
      foreach($uids as $uid) {
        $record = $this->getPage($uid, $languageUid);

        if ($record) {
          $pages[] = $record;
        }
      }
    }

    return $pages;
  }

  /**
   * Gets pages by UIDs.
   *
   * Alias for `getPages`.
   *
   * @param array|string $uids The UIDs as array or as string, seperated by `,`
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return array The pages or empty if no pages were found
   */
  public function getPagesByUids($uids, int $languageUid = null): array {
    return $this->getPages($uids, $languageUid);
  }

  /**
   * Gets the subpages of a page.
   *
   * @param int $pid The PID of the entry page to search from
   * @param int $recursion The recursion, defaults to `1`
   * @param bool $exclude If set, the entry page should be excluded, defaults to `true`
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return array The subpages or empty if no subpages were found
   */
  public function getSubpages(int $pid, int $recursion = 1, bool $exclude = true, int $languageUid = null): array {
    $subpages     = [];
    $subpagesUids = $this->getSubpagesUids($pid, $recursion, $exclude);

    if ($subpagesUids) {
      foreach ($subpagesUids as $subpageUid) {
        $record = $this->getPage($subpageUid, $languageUid);

        if ($record) {
          $subpages[] = $record;
        }
      }
    }

    return $subpages;
  }

  /**
   * Gets the UIDs of the subpages of a page.
   *
   * @param int $pid The PID of the entry page to search from
   * @param int $recursion The recursion level, defaults to `1`
   * @param bool $exclude If set, the entry page should be excluded, defaults to `true`
   * @return array The subpages UIDs or empty if no subpages UIDs were found
   */
  public function getSubpagesUids(int $pid, int $recursion = 1, bool $exclude = true): array {
    $subpagesUids = [];
    $treeList     = $this->queryGenerator->getTreeList($pid, $recursion, 0, 1);
    $recordUids   = GeneralUtility::intExplode(',', $treeList, true);

    if ($recordUids) {
      foreach ($recordUids as $recordUid) {
        if ($this->getPage($recordUid)) {
          $subpagesUids[] = $recordUid;
        }
      }
    }

    if ($exclude) {
      unset($subpagesUids[0]);
    }

    return $subpagesUids;
  }

  /**
   * Checks if T3v DataMapper is running in preview mode.
   *
   * @return bool If T3v DataMapper is running in preview mode
   */
  protected function previewMode(): bool {
    $previewMode = false;
    $settings    = $this->getSettings();

    if (is_array($settings) && !empty($settings)) {
      $mode = $settings['mode'];

      if ($mode === self::PREVIEW_MODE) {
        $previewMode = true;
      }
    }

    return $previewMode;
  }

  /**
   * Gets the settings from `plugin.tx_t3vdatamapper.settings`.
   *
   * @return array The settings
   */
  protected function getSettings(): array {
    $configurationManager = $this->objectManager->get(ConfigurationManagerInterface::class);
    $configuration        = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

    return $configuration['plugin.']['tx_t3vdatamapper.']['settings.'];
  }
}