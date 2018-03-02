<?php
defined('TYPO3_MODE') or die();

// === Variables ===

$namespace          = 't3v';
$extensionKey       = $_EXTKEY;
$extensionSignature = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($namespace . '.' . $extensionKey);

// === Extbase Commands ===

if (TYPO3_MODE === 'BE') {
  $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][$extensionKey] = \T3v\T3vDataMapper\Command\PageLanguageOverlayCommandController::class;
}