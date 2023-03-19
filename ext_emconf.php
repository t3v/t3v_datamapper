<?php
$EM_CONF['t3v_datamapper'] = [
    'title' => 'T3v DataMapper',
    'description' => 'The data mapper extension of TYPO3voilà.',
    'author' => 'Maik Kempe',
    'author_email' => 'mkempe@bitaculous.com',
    'author_company' => 'Bitaculous - It\'s all about the bits, baby!',
    'category' => 'be',
    'state' => 'stable',
    'version' => '9.1.0',
    'createDirs' => '',
    'uploadfolder' => false,
    'clearCacheOnLoad' => false,
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99',
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
