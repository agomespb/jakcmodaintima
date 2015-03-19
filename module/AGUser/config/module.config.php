<?php

namespace AGUser;

return array(
    'router' => array(
        'routes' => array(
            'aguser-register' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/register',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AGUser\Controller',
                        'controller'    => 'Index',
                        'action'        => 'register',
                    ),                    
                )
            ),
            'aguser-activate' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/register/activate[/:key]',
                    'defaults' => array(
                        'controller' => 'AGUser\Controller\Index',
                        'action' => 'activate'
                    )
                )
            ),
            'aguser-auth' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'=>'/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AGUser\Controller',
                        'controller' => 'Auth',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'ajuda' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/ajuda',
                            'defaults' => array(
                                '__NAMESPACE__' => 'AGUser\Controller',
                                'controller' => 'Auth',
                                'action' => 'ajuda'
                            )
                        )
                    ),
                    'remember' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/remember[/:remember]',
                            'defaults' => array(
                                '__NAMESPACE__' => 'AGUser\Controller',
                                'controller' => 'Auth',
                                'action' => 'newPassWord'
                            )
                        )
                    )
                )
            ),
            'aguser-logout' => array(
              'type' => 'Literal',
                'options' => array(
                    'route'=>'/auth/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AGUser\Controller',
                        'controller' => 'Auth',
                        'action' => 'logout'
                    )
                )
            ),
            'aguser-admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AGUser\Controller',
                        'controller' => 'users',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'AGUser\Controller',
                                'controller' => 'users',
                                'action' => 'index'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'AGUser\Controller',
                                'controller' => 'users',
                                'action' => 'index'
                            )
                        )
                    ),
                    'upload' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/users/upload[/:controller]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'AGUser\Controller',
                                'controller' => 'upload'
                            )
                        )
                    ),
                )
            )            
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'AGUser\Controller\Index'  => 'AGUser\Controller\IndexController',
            'AGUser\Controller\Users'  => 'AGUser\Controller\UsersController',
            'AGUser\Controller\Auth'   => 'AGUser\Controller\AuthController',            
            'AGUser\Controller\Upload' => 'AGUser\Controller\UploadController',            
        ),
    ), 
    'view_manager' => array(
        'template_map' => array(
            'AGUser/index/index'   => __DIR__ . '/../view/AGUser/index/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ), 
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),
    'data-fixture' => array(
        'AGUser_fixture' => __DIR__ . '/../src/AGUser/Fixture'
    ),
);
