<?php
defined('TYPO3_MODE') || die();

call_user_func(
    function()
    {

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin (
		'Ceselector',
		'pi1',
		[ \MMC\Ceselector\Controller\SelectorController::class => 'render'],
		// non-cacheable actions
		[ \MMC\Ceselector\Controller\SelectorController::class => 'render']
	);

	}
);

