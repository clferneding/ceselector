<?php

$EM_CONF[$_EXTKEY] = [
  'title' => 'Content Element Selector',
  'description' => 'Selects and displays content elements according to certain parameters (Max elements, sorting, persistent mode)',
  'category' => 'plugin',
  'author' => 'Matthias Mächler',
  'author_email' => 'maechler@mm-computing.ch',
  'author_company' => 'https://mm-computing.ch',
  'state' => 'stable',
  'version' => '3.0.2999',
  'clearCacheOnLoad' => true,
  'uploadfolder' => false,
  'constraints' => [
    'depends' => [
      'typo3' => '10.4.0-11.5.99',
    ],
    'conflicts' => [],
    'suggests' => [],
  ]
];
