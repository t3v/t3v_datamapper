<?php
$EM_CONF[$_EXTKEY] = [
  'title' => 'T3v DataMapper',
  'description' => 'Bring the Database and Validation magic from Laravel to TYPO3.',
  'author' => 'Maik Kempe',
  'author_email' => 'mkempe@bitaculous.com',
  'author_company' => 'Bitaculous - It\'s all about the bits, baby!',
  'category' => 'be',
  'state' => 'stable',
  'version' => '0.0.1',
  'createDirs' => '',
  'uploadfolder' => false,
  'clearCacheOnLoad' => false,
  'constraints' => [
    'depends' => [
      'typo3' => '7.6.0-8.1.99',
      't3v_core' => ''
    ],
    'conflicts' => [
    ],
    'suggests' => []
  ],
  'autoload' => [
    'psr-4' => [
      'T3v\\T3vDataMapper\\' => 'Classes'
    ]
  ],
  'autoload-dev' => [
    'psr-4' => [
      'T3v\\T3vDataMapper\\Tests\\' => 'Tests'
    ]
  ]
];