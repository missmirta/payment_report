<?php

return [
    'payment_report' => [
        'api' => [
            'title' => 'GWCL API Payment Report documentation',
        ],

        'routes' => [
            /*
             * Route for accessing api documentation interface
            */
            'api' => 'api/payment_report/documentation',
            'docs' => storage_path('api-docs/payment_report'),
            'oauth2_callback' => 'api/payment_report/oauth2-callback',
        ],
        'paths' => [
            /*
             * File name of the generated json documentation file
            */
            'docs_json' => 'api-payment_report-docs.json',

            /*
             * File name of the generated YAML documentation file
            */
            'docs_yaml' => 'api-payment_report-docs.yaml',

            /*
            * Set this to `json` or `yaml` to determine which documentation file to use in UI
            */
            'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),

            /*
             * Absolute paths to directory containing the swagger annotations are stored.
            */
            'annotations' => [
                base_path() . "/packages/app/payment_report"
            ],
        ],
    ],
];
