<?php
namespace T3v\T3vDataMapper\Service;

use T3v\T3vCore\Service\AbstractService;
use T3v\T3vCore\Service\LocalizationService as LanguageService;
use T3v\T3vCore\Service\SettingsService;
use T3v\T3vDataMapper\Domain\Model\Page;
use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The page service class.
 *
 * @package T3v\T3vDataMapper\Service
 */
class PageService extends AbstractService
{
    /**
     * The page doktypes.
     */
    public const PAGE_DOKTYPES = [1, 2];

    /**
     * The query generator.
     *
     * @var \TYPO3\CMS\Core\Database\QueryGenerator
     */
    protected $queryGenerator;

    /**
     * The settings service.
     *
     * @var \T3v\T3vCore\Service\SettingsService
     */
    protected $settingsService;

    /**
     * The language service.
     *
     * @var \T3v\T3vCore\Service\LocalizationService
     */
    protected $languageService;

    /**
     * The database service.
     *
     * @var \T3v\T3vDataMapper\Service\DatabaseService
     */
    protected $databaseService;

    /**
     * Constructs a new page service.
     */
    public function __construct()
    {
        // parent::__construct();

        $this->queryGenerator = GeneralUtility::makeInstance(QueryGenerator::class);
        $this->settingsService = GeneralUtility::makeInstance(SettingsService::class);
        $this->languageService = GeneralUtility::makeInstance(LanguageService::class);
        $this->databaseService = GeneralUtility::makeInstance(DatabaseService::class);
        $this->databaseService::setup();
    }

    /**
     * Gets the current page.
     *
     * @param int $languageUid The optional language UID, defaults to the UID of the current system language
     * @return array|null The row for the current page or null if no page was found
     */
    public function getCurrentPage(int $languageUid = null)
    {
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
    public function getPage(int $uid, int $languageUid = null)
    {
        $page = null;
        $record = Page::find($uid);

        if ($record) {
            $record = $record->getAttributes();

            if (is_array($record) && !empty($record) && in_array($record['doktype'], self::PAGE_DOKTYPES)) {
                $page = $record;
                $l18nCfg = isset($page['l18n_cfg']) ? $page['l18n_cfg'] : 0;
                $hideIfDefaultLanguage = (boolean)GeneralUtility::hideIfDefaultLanguage($l18nCfg);
                $hideIfNotTranslated = (boolean)GeneralUtility::hideIfNotTranslated($l18nCfg);
                $languageUid = isset($languageUid) ? $languageUid : $this->languageService->getLanguageUid();

                if ($hideIfDefaultLanguage) {
                    $page['hidden'] = 1;
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
    public function getPageByUid(int $uid, int $languageUid = null)
    {
        return $this->getPage($uid, $languageUid);
    }

    /**
     * Gets pages.
     *
     * @param array|string $uids The UIDs as array or as string, seperated by `,`
     * @param int $languageUid The optional language UID, defaults to the UID of the current system language
     * @return array The pages or empty if no pages were found
     */
    public function getPages($uids, int $languageUid = null): array
    {
        $pages = [];

        if (is_string($uids)) {
            $uids = GeneralUtility::intExplode(',', $uids, true);
        }

        if ($uids) {
            foreach ($uids as $uid) {
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
    public function getPagesByUids($uids, int $languageUid = null): array
    {
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
    public function getSubpages(int $pid, int $recursion = 1, bool $exclude = true, int $languageUid = null): array
    {
        $subpages = [];
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
     * Gets the subpages UIDs of a page.
     *
     * @param int $pid The PID of the entry page to search from
     * @param int $recursion The recursion level, defaults to `1`
     * @param bool $exclude If set, the entry page should be excluded, defaults to `true`
     * @return array The subpages UIDs or empty if no subpages were found
     */
    public function getSubpagesUids(int $pid, int $recursion = 1, bool $exclude = true): array
    {
        $subpagesUids = [];
        $treeList = $this->queryGenerator->getTreeList($pid, $recursion, 0, 1);
        $recordUids = GeneralUtility::intExplode(',', $treeList, true);

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
}
