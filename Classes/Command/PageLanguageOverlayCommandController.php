<?php
namespace T3v\T3vDataMapper\Command;

use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use T3v\T3vCore\Command\AbstractCommandController;

use T3v\T3vDataMapper\Domain\Model\Page\LanguageOverlay;
use T3v\T3vDataMapper\Service\DatabaseService;

/**
 * Page Language Overlay Command Controller Class
 *
 * @package T3v\T3vDataMapper\Command
 */
class PageLanguageOverlayCommandController extends AbstractCommandController {
  /**
   * The query generator
   *
   * @var \TYPO3\CMS\Core\Database\QueryGenerator
   * @inject
   */
  protected $queryGenerator;

  /**
   * The database service
   *
   * @var \T3v\T3vDataMapper\Service\DatabaseService
   * @inject
   */
  protected $databaseService;

  /**
   * The list command.
   *
   * @param int $sysLanguageUid The system language UID to search for
   * @param int $pid The optional PID of the page to search from, defaults to `1`
   * @param int $recursion The optional recursion, defaults to `99`
   * @param string $exclude The optional UIDs of pages to exclude as string, seperated by `,`, empty by default
   * @return void
   */
  public function listCommand($sysLanguageUid, $pid = 1, $recursion = 99, $exclude = '') {
    $this->beforeCommand();

    $sysLanguageUid = intval($sysLanguageUid);
    $pid            = intval($pid);
    $recursion      = intval($recursion);
    $exclude        = GeneralUtility::intExplode(',', $exclude, true);
    $pagesTreeList  = $this->queryGenerator->getTreeList($pid, $recursion, 0, 1);
    $pageUids       = GeneralUtility::intExplode(',', $pagesTreeList, true);
    $pageUids       = array_diff($pageUids, $exclude);

    foreach ($pageUids as $pageUid) {
      $languageOverlay = LanguageOverlay::where([['pid', '=', $pageUid], ['sys_language_uid', '=', $sysLanguageUid]])->first();

      if ($languageOverlay) {
        $uid    = $languageOverlay->uid;
        $title  = $languageOverlay->title;
        $status = $languageOverlay->hidden ? 'hidden' : 'visible';

        $this->log("{$title} ({$uid}) [{$status}]");
      }
    }
  }

  /**
   * The hide command.
   *
   * @param int $sysLanguageUid The system language UID to hide
   * @param int $pid The optional PID of the page to search from, defaults to `1`
   * @param int $recursion The optional recursion, defaults to `99`
   * @param string $exclude The optional UIDs of pages to exclude as string, seperated by `,`, empty by default
   * @return void
   */
  public function hideCommand($sysLanguageUid, $pid = 1, $recursion = 99, $exclude = '') {
    $this->beforeCommand();

    $sysLanguageUid = intval($sysLanguageUid);
    $pid            = intval($pid);
    $recursion      = intval($recursion);
    $exclude        = GeneralUtility::intExplode(',', $exclude, true);
    $pagesTreeList  = $this->queryGenerator->getTreeList($pid, $recursion, 0, 1);
    $pageUids       = GeneralUtility::intExplode(',', $pagesTreeList, true);
    $pageUids       = array_diff($pageUids, $exclude);

    foreach ($pageUids as $pageUid) {
      $languageOverlay = LanguageOverlay::where([['pid', '=', $pageUid], ['sys_language_uid', '=', $sysLanguageUid]])->first();

      if ($languageOverlay) {
        $hidden = $languageOverlay->hidden;

        if (!$hidden) {
          $uid    = $languageOverlay->uid;
          $title  = $languageOverlay->title;

          $this->log("Hiding {$title} ({$uid})...", 'info');

          $languageOverlay->hidden = true;
          $languageOverlay->save();

          $this->log("{$title} ({$uid}) is hidden.", 'ok');
        }
      }
    }
  }

  /**
   * The unhide command.
   *
   * @param int $sysLanguageUid The system language UID to unhide
   * @param int $pid The optional PID of the page to search from, defaults to `1`
   * @param int $recursion The optional recursion, defaults to `99`
   * @param string $exclude The optional UIDs of pages to exclude as string, seperated by `,`, empty by default
   * @return void
   */
  public function unhideCommand($sysLanguageUid, $pid = 1, $recursion = 99, $exclude = '') {
    $this->beforeCommand();

    $sysLanguageUid = intval($sysLanguageUid);
    $pid            = intval($pid);
    $recursion      = intval($recursion);
    $exclude        = GeneralUtility::intExplode(',', $exclude, true);
    $pagesTreeList  = $this->queryGenerator->getTreeList($pid, $recursion, 0, 1);
    $pageUids       = GeneralUtility::intExplode(',', $pagesTreeList, true);
    $pageUids       = array_diff($pageUids, $exclude);

    foreach ($pageUids as $pageUid) {
      $languageOverlay = LanguageOverlay::where([['pid', '=', $pageUid], ['sys_language_uid', '=', $sysLanguageUid]])->first();

      if ($languageOverlay) {
        $hidden = $languageOverlay->hidden;

        if ($hidden) {
          $uid    = $languageOverlay->uid;
          $title  = $languageOverlay->title;

          $this->log("Unhiding {$title} ({$uid})...", 'info');

          $languageOverlay->hidden = false;
          $languageOverlay->save();

          $this->log("{$title} ({$uid}) is visible.", 'ok');
        }
      }
    }
  }

  /**
   * Helper function which gets executed before a command.
   *
   * @return void
   */
  protected function beforeCommand() {
    $this->databaseService->setup();
  }
}