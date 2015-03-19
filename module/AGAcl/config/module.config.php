<?php

namespace AGAcl;

return array(
    'router' => array(
        'routes' => array(
            
            'agacl-admin-roles' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/acl/roles',
                    'defaults' => array(
                        'controller' => 'AGAcl\Controller\Roles',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'AGAcl\Controller',
                                'controller' => 'Roles',
                                'action' => 'index'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/page[/:page]',
                            'constraints' => array(
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'AGAcl\Controller',
                                'controller' => 'Roles',
                                'action' => 'index'
                            )
                        )
                    )  
                )
            ),            
            
            'agacl-admin-resources' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/acl/resources',
                    'defaults' => array(
                        'controller' => 'AGAcl\Controller\Resources',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'AGAcl\Controller',
                                'controller' => 'Resources',
                                'action' => 'index'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/page[/:page]',
                            'constraints' => array(
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'AGAcl\Controller',
                                'controller' => 'Resources',
                                'action' => 'index'
                            )
                        )
                    )  
                )
            ),            
            
            'agacl-admin-privileges' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/acl/privileges',
                    'defaults' => array(
                        'controller' => 'AGAcl\Controller\Privileges',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'AGAcl\Controller',
                                'controller' => 'Privileges',
                                'action' => 'index'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/page[/:page]',
                            'constraints' => array(
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'AGAcl\Controller',
                                'controller' => 'Privileges',
                                'action' => 'index'
                            )
                        )
                    )  
                )
            ),            
            
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'AGAcl\Controller\Roles' => 'AGAcl\Controller\RolesController',
            'AGAcl\Controller\Resources' => 'AGAcl\Controller\ResourcesController',
            'AGAcl\Controller\Privileges' => 'AGAcl\Controller\PrivilegesController',
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'AGAcl/index/index' => __DIR__ . '/../view/AGAcl/index/index.phtml',
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
        'AGAcl_fixture' => __DIR__ . '/../src/AGAcl/Fixture',
    ),
);