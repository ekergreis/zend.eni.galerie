<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Galerie\Controller\Index' =>
                'Galerie\Controller\IndexController',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'MessageGetter' =>
                'Custom\Mvc\Controller\Plugin\MessageGetter',
        ),
    ),
    'view_manager' => array(
        'template_map' => array( 
            'galerie/index/index' =>
			__DIR__ . '/../view/galerie/index/index.phtml', 
            'galerie/index/edit' =>
			__DIR__ . '/../view/galerie/index/edit.phtml', 
            'galerie/index/del' =>
			__DIR__ . '/../view/galerie/index/del.phtml', 
            'galerie/index/view' =>
			__DIR__ . '/../view/galerie/index/view.phtml',  
            'galerie/mail/test' =>
			__DIR__ . '/../view/galerie/mail/test.phtml',  
            'galerie/index/rsscheck' =>
			__DIR__ . '/../view/galerie/index/rsscheck.phtml', 
        ), 
        'template_path_stack' => array(
            'galerie' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'router' => array(
        'routes' => array(
            'galerie' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/galeries',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Galerie\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'verb' => 'get',
                'may_terminate' => true,
                'child_routes' => array(
                    'add' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/ajout',
                            'defaults' => array(
                                'action' => 'edit',
                            ),
                        ),
                        'verb' => 'get,post',
                    ),
                    'edit' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/editer/:id',
                            'constraints' => array(
                                'id' => '[1-9][0-9]*',
                            ),
                            'defaults' => array(
                                'action' => 'edit',
                            ),
                        ),
                        'verb' => 'get,post',
                    ),
                    'del' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/supprimer/:id',
                            'constraints' => array(
                                'id' => '[1-9][0-9]*',
                            ),
                            'defaults' => array(
                                'action' => 'del',
                            ),
                        ),
                        'verb' => 'get,post',
                    ),
                    'view' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/voir/:id',
                            'constraints' => array(
                                'id' => '[1-9][0-9]*',
                            ),
                            'defaults' => array(
                                'action' => 'view',
                            ),
                        ),
                    ),
                    'add_or_edit' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/ajouter_editer/[:id]',
                            'constraints' => array(
                                'id' => '[1-9][0-9]*',
                            ),
                            'defaults' => array(
                                'action' => 'edit',
                                'id' => null,
                            ),
                        ),
                        'verb' => 'get,post',
                    ),
                    'list' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/liste',
                            'defaults' => array(
                                'action' => 'list',
                            ),
                        ),
                        'verb' => 'get',
                    ),
                    'csv' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/csv',
                            'defaults' => array(
                                'action' => 'csv',
                            ),
                        ),
                        'verb' => 'get',
                    ),
                    'excel' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/excel',
                            'defaults' => array(
                                'action' => 'excel',
                            ),
                        ),
                        'verb' => 'get',
                    ),
                    'mail' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/mail',
                            'defaults' => array(
                                'action' => 'mail',
                            ),
                        ),
                        'verb' => 'get',
                    ),
                    'pie' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/pie',
                            'defaults' => array(
                                'action' => 'pie',
                            ),
                        ),
                        'verb' => 'get',
                    ),
                    'rss' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/rss',
                            'defaults' => array(
                                'action' => 'rss',
                            ),
                        ),
                        'verb' => 'get',
                    ),
                    'rsscheck' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/rsscheck',
                            'defaults' => array(
                                'action' => 'rsscheck',
                            ),
                        ),
                        'verb' => 'get',
                    ),
/*
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),*/
                ),
            ),
        ),
    ),
    'service_manager' => array( 
        'factories' => array( 
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ), 
    ), 
    'translator' => array( 
        'locale' => 'fr_FR', 
        'translation_file_patterns' => array( 
            array( 
                'type'     => 'gettext', 
                'base_dir' => __DIR__ . '/../language', 
                'pattern'  => '%s.mo', 
                'text_domain'  => 'galerie', 
            ), 
            array( 
                'type'     => 'phpArray', 
                'base_dir' => __DIR__ . '/../language/val', 
                'pattern'  => 'Zend_Validate_%s.php', 
                'text_domain'  => 'val', 
            ), 
        ), 
    ), 
    'mail' => array(
        'name' => 'free',
        'host' => 'smtp.free.fr',
        'port' => 25,
    ),
    'rss' => array(
        'title' => 'Galeries',
        'description' => 'Liste des galeries disponibles',
        'link' => 'http://zf2.biz/galeries',
        'setfeedlink' => array(
            'link' => 'http://zf2.biz/galeries/rss',
            'type' => 'rss'
        ),
        'author' => array(
            'name'  => 'Sébastien CHAZALLET',
            'email' => 'contact@zf2.biz',
            'uri'   => 'http://zf2.biz',
        )
    ),
);
