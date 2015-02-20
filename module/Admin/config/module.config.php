<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Auth' => 'Admin\Controller\AuthController',
            'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
            'Admin\Controller\Pdf\AlboPretorioPdf' => 'Admin\Controller\Pdf\AlboPretorioPdfController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'login' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Auth',
                        'action'        => 'showFormLogin',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            'admin' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/admin/main[/:lang][/]',
                    'constraints' => array(
                        'lang' => '[a-z]{2}',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Admin',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'formdata' => array(
                        'type'    => 'Segment',
                        'options' => array(
                                    'route'    => 'formdata[/][:formsetter][/][:option][/][:id][/]',
                                    'constraints' => array(
                                                'formsetter' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'option'     => '[a-zA-Z0-9_-]*',
                                                'id'         => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                                'controller' => 'Admin\Controller\Admin',
                                                'action'     => 'index',
                                    ),
                        ),
                    ),
                    'datatable' => array(
                                    'type'    => 'Segment',
                                    'options' => array(
                                                'route'       => 'datatable[/][:tablesetter][/][page/:page][/][/order_by/:order_by][/:order]',
                                                'constraints' => array(
                                                        'tablesetter' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'page'        => '[0-9]+',
                                                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'order' => 'ASC|DESC',
                                                ),
                                                'defaults' => array(
                                                        'controller' => 'Admin\Controller\Admin',
                                                        'action'     => 'index',
                                                ),
                                    ),
                    ),
                    'config-edit' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => 'config-edit[/]',
                            'constraints' => array(

                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Admin',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'invio-ente-terzo' => array(
                                    'type'    => 'Segment',
                                    'options' => array(
                                                'route'       => 'invio-ente-terzo[/][:modulename][/][:id][/]',
                                                'constraints' => array(
                                                        'modulename' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id'         => '[0-9]+',
                                                ),
                                                'defaults' => array(
                                                        'controller' => 'Admin\Controller\Admin',
                                                        'action'     => 'index',
                                                ),
                                    ),
                    ),
                    'formpost' => array(
                                    'type'    => 'Segment',
                                    'options' => array(
                                                'route'         => 'formpost[/][:form_post_handler][/][:operation][/][:id][/]',
                                                'constraints'   => array(
                                                    'form_post_handler' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                    'operation'         => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                    'id'                => '[0-9]+',
                                                ),
                                                'defaults' => array(
                                                    'controller' => 'Admin\Controller\Admin',
                                                    'action'     => 'formpost',
                                                ),
                                    ),
                    ),
                    'pdf-albo-pretorio' => array(
                                    'type'    => 'Segment',
                                    'options' => array(
                                                'route'         => 'pdf/albo-pretorio/:id',
                                                'constraints'   => array(
                                                    'id' => '[0-9]+',
                                                ),
                                                'defaults' => array(
                                                    'controller' => 'Admin\Controller\Pdf\AlboPretorioPdf',
                                                    'action'     => 'relata',
                                                ),
                                    ),
                    ),
                ),
            ),
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'      => 'gettext',
                'base_dir'  => __DIR__ . '/../language',
                'pattern'   => '%s.mo',
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'template_map' => array(            
            'admin/admin/login'             => __DIR__ . '../../view/admin/auth/login.phtml',
            'admin/admin/index'             => __DIR__ . '../../view/admin/index.phtml',
            'admin/admin/formpost'          => __DIR__ . '../../view/admin/formpost-empty.phtml',
            'admin/admin/invio-ente-terzo'  => __DIR__ . '/../view/invio-ente-terzo-empty.phtml',
            'admin/admin/invio-ente-terzo'  => __DIR__ . '/../view/config-edit-empty.phtml',
            'admin/'                        => __DIR__ . '/../view/empty.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '../../view',
            __DIR__ . '../../public'
        ),
    ),
    /* Backend Router Class Map */
    'be_router' => array(
        "admin"                     => '\Admin\Model\AdminDashboard',
        "admin/formdata"            => '\Admin\Model\FormData\FormDataHandler',
        "admin/config-edit"         => '\Admin\Model\Config\ConfigEditHandler',
        "admin/datatable"           => '\Admin\Model\DataTable\DataTableHandler',
        "admin/invio-ente-terzo"    => '\Admin\Model\EntiTerzi\InvioEnteTerzoHandler',
        "admin/sezioni"             => '\Admin\Model\Sezioni\SezioniHandler',
    ),
    /* FormData Class Map */
    'formdata_classmap' => array(
        'attachments'                   => 'Admin\Model\Attachments\AttachmentsFormDataHandler',
        'albo-pretorio'                 => 'Admin\Model\AlboPretorio\AlboPretorioFormDataHandler',
        'albo-pretorio-sezioni'         => 'Admin\Model\AlboPretorio\AlboPretorioSezioniFormDataHandler',
        'amministrazione-trasparente'   => 'Admin\Model\AmministrazioneTrasparente\AmministrazioneTrasparenteFormDataHandler',
        'atti-concessione'              => 'Admin\Model\AttiConcessione\AttiConcessioneFormDataHandler',
        'atti-concessione-settori'      => 'Admin\Model\AttiConcessione\AttiConcessioneSettoriFormDataHandler',
        'atti-concessione-resp'         => 'Admin\Model\AttiConcessione\AttiConcessioneRespFormDataHandler',
        'contenuti'                     => 'Admin\Model\Contenuti\ContenutiFormDataHandler',
        'sezioni-contenuti'             => 'Admin\Model\Sezioni\SezioniFormDataHandler',
        'sottosezioni-contenuti'        => 'Admin\Model\Sezioni\SottoSezioniFormDataHandler',
        'stato-civile'                  => 'Admin\Model\StatoCivile\StatoCivileFormDataHandler',
        'stato-civile-sezioni'          => 'Admin\Model\StatoCivile\StatoCivileSezioniFormDataHandler',
        'contratti-pubblici'            => 'Admin\Model\ContrattiPubblici\ContrattiPubbliciFormDataHandler',
        'contratti-pubblici-scelta-contraente'  => 'Admin\Model\ContrattiPubblici\SceltaContraenteFormDataHandler',
        'contratti-pubblici-responsabili'       => 'Admin\Model\ContrattiPubblici\ResponsabiliProcedimentoFormDataHandler',
        'contratti-pubblici-settori'            => 'Admin\Model\ContrattiPubblici\SettoriFormDataHandler',
        'contratti-pubblici-partecipanti'       => 'Admin\Model\ContrattiPubblici\PartecipantiFormDataHandler',
        'contratti-pubblici-operatori'          => 'Admin\Model\ContrattiPubblici\OperatoriFormDataHandler',
        'enti-terzi'                    => 'Admin\Model\EntiTerzi\EntiTerziFormDataHandler',
        'posts'                         => 'Admin\Model\Posts\PostsFormDataHandler',
        'categories'                    => 'Admin\Model\Posts\CategoriesFormDataHandler',
        'tickets'                       => 'Admin\Model\Tickets\TicketsFormDataHandler',
        'users'                         => 'Admin\Model\Users\UsersFormDataHandler',
    ),
    /* FormData CRUD Class Map */
    'formdata_crud_classmap' => array( 
        'albo-pretorio'               => 'Admin\Model\AlboPretorio\AlboPretorioArticoliCrudHandler',
        'albo-pretorio-sezioni'       => 'Admin\Model\AlboPretorio\AlboPretorioSezioniCrudHandler',
        'amministrazione-trasparente' => 'Admin\Model\AmministrazioneTrasparente\AmministrazioneTrasparenteCrudHandler',
        'attachments'                 => 'Admin\Model\Attachments\AttachmentsCrudHandler',
        'atti-concessione'            => 'Admin\Model\AttiConcessione\AttiConcessioneCrudHandler',
        'atti-concessione-settori'    => 'Admin\Model\AttiConcessione\AttiConcessioneSettoriCrudHandler',
        'atti-concessione-resp'       => 'Admin\Model\AttiConcessione\AttiConcessioneRespProcCrudHandler',
        'categories'                  => 'Admin\Model\Posts\CategoriesCrudHandler',
        'contenuti'                   => 'Admin\Model\Contenuti\ContenutiCrudHandler',
        'sezioni-contenuti'           => 'Admin\Model\Sezioni\SezioniCrudHandler',
        'contratti-pubblici'          => 'Admin\Model\ContrattiPubblici\ContrattiPubbliciCrudHandler',
        'contratti-pubblici-scelta-contraente'  => 'Admin\Model\ContrattiPubblici\SceltaContraenteCrudHandler',
        'contratti-pubblici-responsabili'       => 'Admin\Model\ContrattiPubblici\ResponsabiliProcedimentoCrudHandler',
        'contratti-pubblici-settori'            => 'Admin\Model\ContrattiPubblici\SettoriCrudHandler',
        'contratti-pubblici-partecipanti'       => 'Admin\Model\ContrattiPubblici\PartecipantiCrudHandler',
        'contratti-pubblici-operatori'          => 'Admin\Model\ContrattiPubblici\OperatoriCrudHandler',
        'contatti'              => 'Admin\Model\Contacts\ContactsCrudHandler',
        'faq'                   => 'Admin\Model\Faq\FaqCrudHandler',
        'newsletter'            => 'Admin\Model\Newsletter\NewsletterCrudHandler',
        'posts'                 => 'Admin\Model\Posts\PostsCrudHandler',
        'enti-terzi'            => 'Admin\Model\EntiTerzi\EntiTerziCrudHandler',
        'invio-ente-terzo'      => 'Admin\Model\EntiTerzi\InvioEnteTerzoCrudHandler',
        'stato-civile'          => 'Admin\Model\StatoCivile\StatoCivileCrudHandler',
        'stato-civile-sezioni'  => 'Admin\Model\StatoCivile\StatoCivileSezioniCrudHandler',
        'tickets'               => 'Admin\Model\Tickets\TicketsCrudHandler',
        'users'                 => 'Admin\Model\Users\UsersCrudHandler',
    ),
    /* DataTables Class Map */
    'datatables_classmap' => array(
        'tickets'                     => 'Admin\Model\Tickets\TicketsDataTable',
        'categories'                  => 'Admin\Model\Posts\CategoriesDataTable',
        'contacts'                    => 'Admin\Model\Contacts\ContactsDataTable',
        'faq'                         => 'Admin\Model\Faq\FaqDataTable',
        'newsletter'                  => 'Admin\Model\Newsletter\NewsletterDataTable',
        'contenuti'                   => 'Admin\Model\Contenuti\ContenutiDataTable',
        'sezioni-contenuti'           => 'Admin\Model\Sezioni\SezioniDataTable',
        'sottosezioni-contenuti'      => 'Admin\Model\Sezioni\SottoSezioniDataTable',
        'contents'                    => 'Admin\Model\Posts\PostsDataTable',
        'photo'                       => 'Admin\Model\Posts\PostsDataTable',
        'blog'                        => 'Admin\Model\Posts\PostsDataTable',
        'albo-pretorio'               => 'Admin\Model\AlboPretorio\AlboPretorioArticoliDataTable',
        'atti-ufficiali'              => 'Admin\Model\AlboPretorio\AttiUfficialiDataTable',
        'albo-pretorio-sezioni'       => 'Admin\Model\AlboPretorio\AlboPretorioSezioniDataTable',
        'amministrazione-trasparente' => 'Admin\Model\AmministrazioneTrasparente\AmministrazioneTrasparenteDataTable',
        'atti-concessione'            => 'Admin\Model\AttiConcessione\AttiConcessioneDataTable',
        'atti-concessione-settori'    => 'Admin\Model\AttiConcessione\AttiConcessioneSettoriDataTable',
        'atti-concessione-resp'       => 'Admin\Model\AttiConcessione\AttiConcessioneRespProcDataTable',
        'contratti-pubblici'          => 'Admin\Model\ContrattiPubblici\ContrattiPubbliciDataTable',
        'contratti-pubblici-scelta-contraente'  => 'Admin\Model\ContrattiPubblici\SceltaContraenteDataTable',
        'contratti-pubblici-responsabili'       => 'Admin\Model\ContrattiPubblici\ResponsabiliProcedimentoDataTable',
        'contratti-pubblici-settori'            => 'Admin\Model\ContrattiPubblici\SettoriDataTable',
        'contratti-pubblici-partecipanti'       => 'Admin\Model\ContrattiPubblici\PartecipantiDataTable',
        'contratti-pubblici-operatori'          => 'Admin\Model\ContrattiPubblici\OperatoriDataTable',
        'enti-terzi'                  => 'Admin\Model\EntiTerzi\EntiTerziDataTable',
        'logs'                        => 'Admin\Model\Logs\LogsDataTable',
        'stato-civile'                => 'Admin\Model\StatoCivile\StatoCivileDataTable',
        'stato-civile-sezioni'        => 'Admin\Model\StatoCivile\StatoCivileSezioniDataTable',
        'users'                       => 'Admin\Model\Users\UsersDataTable',
    ),
);