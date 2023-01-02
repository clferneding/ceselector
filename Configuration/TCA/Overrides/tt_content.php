<?php
defined('TYPO3_MODE') || die();

(function () {

	$tempColumns = array (
		'tx_ceselector_max_el' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:ceselector/Resources/Private/Language/locallang_db.xlf:tt_content.tx_ceselector_max_el',
			'config' => array (
				'type' => 'input',
				'size' => '5',
				'max' => '5',
				'eval' => 'required,int,nospace',
				'default' => '1'
			)
		),
		'tx_ceselector_orderby' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:ceselector/Resources/Private/Language/locallang_db.xlf:tt_content.tx_ceselector_orderby',
			'config' => array (
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array (
					array('LLL:EXT:ceselector/Resources/Private/Language/locallang_db.xlf:tt_content.tx_ceselector_orderby.I.0', '0'),
					array('LLL:EXT:ceselector/Resources/Private/Language/locallang_db.xlf:tt_content.tx_ceselector_orderby.I.1', '1'),
					array('LLL:EXT:ceselector/Resources/Private/Language/locallang_db.xlf:tt_content.tx_ceselector_orderby.I.2', '2'),
					array('LLL:EXT:ceselector/Resources/Private/Language/locallang_db.xlf:tt_content.tx_ceselector_orderby.I.3', '3'),
					array('LLL:EXT:ceselector/Resources/Private/Language/locallang_db.xlf:tt_content.tx_ceselector_orderby.I.4', '4'),
				),
				'size' => 1,
				'maxitems' => 1,
			)
		),
		'tx_ceselector_persistent_mode' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:ceselector/Resources/Private/Language/locallang_db.xlf:tt_content.tx_ceselector_persistent_mode',
			'config' => array (
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array (
					array('LLL:EXT:ceselector/Resources/Private/Language/locallang_db.xlf:tt_content.tx_ceselector_persistent_mode.I.0', '0'),
					array('LLL:EXT:ceselector/Resources/Private/Language/locallang_db.xlf:tt_content.tx_ceselector_persistent_mode.I.1', '1'),
					array('LLL:EXT:ceselector/Resources/Private/Language/locallang_db.xlf:tt_content.tx_ceselector_persistent_mode.I.2', '2'),
				),
				'size' => 1,
				'maxitems' => 1,
			)
		),
		'tx_ceselector_cookie_exp' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:ceselector/Resources/Private/Language/locallang_db.xlf:tt_content.tx_ceselector_cookie_exp',
			'config' => array (
				'type' => 'input',
				'size' => '10',
				'max' => '10',
				'eval' => 'int,nospace',
			)
		),
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns("tt_content", $tempColumns);
	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['ceselector_pi1']='layout,select_key,header,spaceBefore,spaceAfter,section_frame';
	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['ceselector_pi1']='tx_ceselector_orderby,tx_ceselector_max_el, tx_ceselector_persistent_mode, tx_ceselector_cookie_exp, records';

  \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		'MMC.Ceselector',
		'pi1',
		'LLL:EXT:ceselector/Resources/Private/Language/locallang_db.xlf:plugin_name'
  );

})();
