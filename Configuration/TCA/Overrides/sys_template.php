<?php
defined('TYPO3') or die();

// === Variables ===

$extensionKey = 't3v_datamapper';
$extensionTitle = 'T3v DataMapper';

// === TypoScript ===

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extensionKey, 'Configuration/TypoScript', $extensionTitle);

# === T3v Generator ===
