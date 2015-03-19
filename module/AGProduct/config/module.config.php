<?php

namespace AGProduct;

return array(
    'router' => array(
        'routes' => array(
            'agpdct-home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/loja',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AGProduct\Controller',
                        'controller' => 'Products',
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
                                '__NAMESPACE__' => 'AGProduct\Controller',
                                'controller' => 'Products',
                                'action'     => 'index',
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
                                '__NAMESPACE__' => 'AGProduct\Controller',
                                'controller' => 'Products',
                                'action'     => 'index',
                            )
                        )
                    ),
                )
            )            
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'AGProduct\Controller\Products'  => 'AGProduct\Controller\ProductsController'            
        ),
    ), 
    'view_manager' => array(
        'template_map' => array(
            'AGProduct/index/index'   => __DIR__ . '/../view/AGProduct/index/index.phtml',
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
        'AGProduct_fixture' => __DIR__ . '/../src/AGProduct/Fixture'
    ),
);
