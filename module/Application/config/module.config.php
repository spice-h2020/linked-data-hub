<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthenticated visitors.
    'access_filter' => [
        'options' => [
            // The access filter can work in 'restrictive' (recommended) or 'permissive'
            // mode. In restrictive mode all controller actions must be explicitly listed
            // under the 'access_filter' config key, and access is denied to any not listed
            // action for users not logged in. In permissive mode, if an action is not listed
            // under the 'access_filter' key, access to it is permitted to anyone (even for
            // users not logged in. Restrictive mode is more secure and recommended.
            'mode' => 'restrictive'
        ],
        'controllers' => [
            Controller\IndexController::class => [
                // Allow anyone to visit "index" and "about" actions
                ['actions' => ['index'], 'allow' => '*'],
                // Allow authenticated users to visit "settings" action
                //['actions' => ['settings'], 'allow' => '@']
            ],
            Controller\StaticController::class => [
                // Allow anyone to visit "index" and "about" actions
                ['actions' => ['documentation'], 'allow' => '*'],
                // Allow authenticated users to visit "settings" action
                //['actions' => ['settings'], 'allow' => '@']
            ],
        ]
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Datasets',
                'route' => 'dataset',
                'pages' => [
                    [
                        'label'=>'Overview',
                        'route'=>'dataset',
                        'action' => 'details'
                    ],
                    [
                        'label'=>'Location',
                        'route'=>'dataset',
                        'action' => 'geospatial-details'
                    ],
                    [
                        'label'=>'Ownership and licensing',
                        'route'=>'dataset',
                        'action' => 'ownership-details'
                    ],
                    [
                        'label'=>'Permissions',
                        'route'=>'dataset',
                        'action' => 'permissions-details'
                    ],
                    [
                        'label'=>'Licences',
                        'route'=>'dataset',
                        'action' => 'licence'
                    ],
                    [
                        'label'=>'Collections',
                        'route'=>'dataset-collections',
                        'action' => 'details'
                    ],
                    [
                        'label'=>'Tags',
                        'route'=>'dataset-tags',
                        //'action' => 'details'
                    ],
                    [
                        'label'=>'Files',
                        'route'=>'file',
                        //'action' => 'details',
                    ],
                    [
                        'label'=>'Stream',
                        'route'=>'stream',
                        //'action' => 'details',
                    ],
                ]
            ],
            // [
//                 'label' => 'Collections',
//                 'route' => 'collection'
//             ],
            // [
            //     'label' => 'Help',
            //     'route' => 'content',
            //     /*'pages' => [
            //         [
            //             'label' => 'About',
            //             'route' => 'content',
            //             'page' => 'about'
            //         ],
            //         [
            //             'label' => 'Stream API',
            //             'route' => 'content',
            //             'page' => 'streamapi'
            //         ],
            //         [
            //             'label' => 'Developer',
            //             'route' => 'content',
            //             'page' => 'developer'
            //         ],
            //         [
            //             'label' => 'Terms and conditions',
            //             'route' => 'content',
            //             'page' => 'termsconditions'
            //         ],
            //         [
            //             'label' => 'The team',
            //             'route' => 'content',
            //             'page' => 'team'
            //         ],
            //         [
            //             'label' => 'Contact',
            //             'route' => 'content',
            //             'page' => 'contact'
            //         ]
            //     ]*/
            // ],
            [
                'label' => 'Users',
                'route' => 'users',
            ],
            [
                'label' => 'Login',
                'route' => 'login',
                'hide_from_menu' => true,
            ],
            [
                'label' => 'My account',
                'route' => 'my-account',
                'hide_from_menu' => true,
                'pages' => [
                    [
                        'label'=>'Overview',
                        'route'=>'my-account',
                        'action' => 'overview',
                        'hide_from_menu' => true,
                    ],
                    // [
                    //     'label'=>'My datasets',
                    //     'route'=>'my-account/mydatasets',
                    //     'action' => 'mydatasets',
                    //     'hide_from_menu' => true,
                    // ],
                    // [
                    //     'label'=>'My keys',
                    //     'route'=>'key',
                    //     'action' => 'index',
                    //     'hide_from_menu' => true,
                    // ],
                ]
            ],
        ],
    ],
];
