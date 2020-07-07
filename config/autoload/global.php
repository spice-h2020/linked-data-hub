<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'db'    => [
            'host'     => '127.0.0.1',
            'port'     => '8889',
            'user'     => 'datahub_spice',
            'password' => 'zfs6ho1CahSnZoP1',
            'dbname'   => 'datahub_beta'
        ],
    'mkdf-stream'   =>  [
            'user'  =>  'admin',
            'pass'  =>  'klas228JD!',
            'server-url'    =>  'http://apif1-dev.datahub.kmi.open.ac.uk',
            'public-url'    =>  'https://api.pp.datahub.kmi.open.ac.uk'
        ],
        'mkdf-file' => [
            'destination' => '/Users/ed4565/Sites/datahub-data',
        ]
];
