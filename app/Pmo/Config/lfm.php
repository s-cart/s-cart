<?php

/*
|--------------------------------------------------------------------------
| Documentation for this config :
|--------------------------------------------------------------------------
| online  => http://unisharp.github.io/laravel-filemanager/config
| offline => vendor/unisharp/laravel-filemanager/docs/config.md
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
     */

    'use_package_routes'       => false,
    // The url to this package. Change it if necessary.
    'url_prefix' => 'uploads',
    /*
    |--------------------------------------------------------------------------
    | Shared folder / Private folder
    |--------------------------------------------------------------------------
    |
    | If both options are set to false, then shared folder will be activated.
    |
     */

    'allow_private_folder'     => true,

    // Flexible way to customize client folders accessibility
    // If you want to customize client folders, publish tag="lfm_handler"
    // Then you can rewrite userField function in App\Handler\ConfigHandler class
    // And set 'user_field' to App\Handler\ConfigHandler::class
    // Ex: The private folder of user will be named as the user id.
    'private_folder_name'      => \App\Pmo\Handlers\LfmConfigHandler::class,

    'allow_shared_folder'      => false,

    'shared_folder_name'       => 'shares',

    /*
    |--------------------------------------------------------------------------
    | Folder Names
    |--------------------------------------------------------------------------
     */
    'folder_categories' => [
        'product' => [
            'folder_name' => 'product',
            'startup_view' => 'grid',
            'max_size' => 30000, // size in KB
            'thumb' => true,
            'thumb_width' => 80,
            'thumb_height' => 80,
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],

        'category' => [
            'folder_name' => 'category',
            'startup_view' => 'grid',
            'max_size' => 30000, // size in KB
            'thumb' => true,
            'thumb_width' => 80,
            'thumb_height' => 80,
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],

        'category_store' => [
            'folder_name' => 'category_store',
            'startup_view' => 'grid',
            'max_size' => 30000, // size in KB
            'thumb' => true,
            'thumb_width' => 80,
            'thumb_height' => 80,
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],

        'brand' => [
            'folder_name' => 'brand',
            'startup_view' => 'grid',
            'max_size' => 30000, // size in KB
            'thumb' => true,
            'thumb_width' => 80,
            'thumb_height' => 80,
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],

        'supplier' => [
            'folder_name' => 'supplier',
            'startup_view' => 'grid',
            'max_size' => 30000, // size in KB
            'thumb' => true,
            'thumb_width' => 80,
            'thumb_height' => 80,
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],

        'language' => [
            'folder_name' => 'language',
            'startup_view' => 'grid',
            'max_size' => 30000, // size in KB
            'thumb' => true,
            'thumb_width' => 80,
            'thumb_height' => 80,
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],

        'currency' => [
            'folder_name' => 'currency',
            'startup_view' => 'grid',
            'max_size' => 30000, // size in KB
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],

        'logo' => [
            'folder_name' => 'logo',
            'startup_view' => 'grid',
            'max_size' => 50000, // size in KB
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],

        'content' => [
            'folder_name' => 'content',
            'startup_view' => 'grid',
            'max_size' => 30000, // size in KB
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],
        'page' => [
            'folder_name' => 'page',
            'startup_view' => 'grid',
            'max_size' => 30000, // size in KB
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],

        'avatar' => [
            'folder_name' => 'avatar',
            'startup_view' => 'grid',
            'max_size' => 30000, // size in KB
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],

        'other' => [
            'folder_name' => 'other',
            'startup_view' => 'grid',
            'max_size' => 30000, // size in KB
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],

        'banner' => [
            'folder_name' => 'banner',
            'startup_view' => 'grid',
            'max_size' => 50000, // size in KB
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],

        'cms-image' => [
            'folder_name' => 'cms-image',
            'startup_view' => 'grid',
            'max_size' => 50000, // size in KB
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
            ],
        ],

        'file' => [
            'folder_name' => 'file',
            'startup_view' => 'list',
            'max_size' => 50000, // size in KB
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
                'application/pdf',
                'text/plain',
            ],
        ],

        'manager' => [
            'folder_name' => '',
            'startup_view' => 'list',
            'max_size' => 50000, // size in KB
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
                'application/pdf',
                'text/plain',
            ],
        ],
    ],

    'paginator' => [
        'perPage' => 20,
    ],

    /*
    |--------------------------------------------------------------------------
    | Upload / Validation
    |--------------------------------------------------------------------------
     */

    'disk'                     => env('SC_UPLOAD_DISK', 'uploads'),

    'rename_file'              => false,

    'alphanumeric_filename'    => false,

    'alphanumeric_directory'   => false,

    'should_validate_size'     => true,

    'should_validate_mime'     => true,

    // behavior on files with identical name
    // setting it to true cause old file replace with new one
    // setting it to false show `error-file-exist` error and stop upload
    'over_write_on_duplicate'  => env('SC_UPLOAD_OVER_WRITE_DUPLICATE', false),

    // Item Columns
    'item_columns' => ['name', 'url', 'time', 'icon', 'is_file', 'is_image', 'thumb_url'],

    /*
    |--------------------------------------------------------------------------
    | Thumbnail
    |--------------------------------------------------------------------------
     */

    // If true, image thumbnails would be created during upload
    'should_create_thumbnails' => env('SC_UPLOAD_THUMB_STATUS', false),

    'thumb_folder_name'        => env('SC_UPLOAD_THUMB_FOLDER', 'thumbs'),

    // Create thumbnails automatically only for listed types.
    'raster_mimetypes'         => [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
    ],

    'thumb_img_width'          => env('SC_UPLOAD_THUMB_WIDTH', '200'), // px

    'thumb_img_height'         => env('SC_UPLOAD_THUMB_HEIGHT', '200'), // px

    /*
    |--------------------------------------------------------------------------
    | File Extension Information
    |--------------------------------------------------------------------------
     */

    'file_type_array'          => [
        'pdf'  => 'Adobe Acrobat',
        'doc'  => 'Microsoft Word',
        'docx' => 'Microsoft Word',
        'xls'  => 'Microsoft Excel',
        'xlsx' => 'Microsoft Excel',
        'zip'  => 'Archive',
        'gif'  => 'GIF Image',
        'jpg'  => 'JPEG Image',
        'jpeg' => 'JPEG Image',
        'png'  => 'PNG Image',
        'ppt'  => 'Microsoft PowerPoint',
        'pptx' => 'Microsoft PowerPoint',
    ],

    /*
    |--------------------------------------------------------------------------
    | php.ini override
    |--------------------------------------------------------------------------
    |
    | These values override your php.ini settings before uploading files
    | Set these to false to ingnore and apply your php.ini settings
    |
    | Please note that the 'upload_max_filesize' & 'post_max_size'
    | directives are not supported.
     */
    'php_ini_overrides'        => [
        'memory_limit' => '256M',
    ],
];
