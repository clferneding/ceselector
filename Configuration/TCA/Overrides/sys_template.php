<?php
defined('TYPO3_MODE') || die();

(function () {
  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('ceselector', 'Configuration/TypoScript', 'MMC content element selector');
})();
