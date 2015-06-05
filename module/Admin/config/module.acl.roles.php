<?php
return array(
    'admin/configurations-form' => array(
        'resources' => array('configurations_update',)
    ),
    /* Contenuti */
    'admin/contenuti-summary' => array(
        'resources' => array('contenuti_add', 'contenuti_update', 'contenuti_viewall')
    ),
    'admin/contenuti-form' => array(
        'resources' => array('contenuti_add', 'contenuti_update')
    ),
    /* Blogs */
    'admin/blogs-summary' => array(
        // 'resources' => array('blogs_add', 'blogs_update', 'blogs_viewall')
    ),
    'admin/blogs-form' => array(
        // 'resources' => array('blogs_add', 'blogs_update', 'blogs_viewall')
    ),
    /* Photo */
    'admin/photo-summary' => array(
        // 'resources' => array('photo_add', 'photo_update', 'photo_viewall')
    ),
    'admin/photo-form' => array(
        // 'resources' => array('photo_add', 'photo_update', 'photo_viewall')
    ),
    /*
    'admin/posizioni-sezioni' => array(
        'resources' => array( 'contenuti_sezioni_update' )
    ),
    'admin/posizioni-sezioni-update' => array(
        'resources' => array( 'contenuti_sezioni_update' )
    ),
    */
    /* Contacts */
    'admin/contacts-summary' => array(
        'resources' => array( 'contacts_update')
    ),
    /* Albo pretorio */
    'admin/albo-pretorio-summary' => array(
        'resources' => array( 'albo_pretorio_add', 'albo_pretorio_update')
    ),
    'admin/albo-pretorio-form' => array(
        'resources' => array( 'albo_pretorio_add', 'albo_pretorio_update')
    ),
    'admin/albo-pretorio-form-post' => array(
        'resources' => array( 'albo_pretorio_add', 'albo_pretorio_update')
    ),
    /* Stato civile */
    'admin/stato-civile-summary' => array(
        'resources' => array('stato_civile_add', 'stato_civile_update')
    ),
    'admin/stato-civile-form' => array(
        'resources' => array('stato_civile_add', 'stato_civile_update')
    ),
    'admin/stato-civile-insert' => array(
        'resources' => array('stato_civile_add',)
    ),
    'admin/stato-civile-update' => array(
        'resources' => array('stato_civile_update',)
    ),
    /* Contratti pubblici */
    'admin/contratti-pubblici-summary' => array(
        'resources' => array('contratti_pubblici_add', 'contratti_pubblici_update')
    ),
    'admin/contratti-pubblici-form' => array(
        'resources' => array('contratti_pubblici_add', 'contratti_pubblici_update')
    ),
    'admin/contratti-pubblici-operatori-summary' => array(
        'resources' => array('contratti_pubblici_operatori_add', 'contratti_pubblici_operatori_update')
    ),
    'admin/contratti-pubblici-operatori-form' => array(
        'resources' => array('contratti_pubblici_operatori_add', 'contratti_pubblici_operatori_update')
    ),
    /* Atti concessione */
    'admin/atti-concessione-summary' => array(
        'resources' => array('atti_concessione_add', 'atti_concessione_update')
    ),
    'admin/atti-concessione-form' => array(
        'resources' => array('atti_concessione_add', 'atti_concessione_update')
    ),
    /* Responsabili procedimento */
    'admin/users-resp-proc-management' => array(
        'resources' => array('contenuti_sezioni_update')
    ),
    /* Users roles */
    'users-roles-summary' => array(
        'resources' => array('users_roles_update')
    ),
    'users-roles-form' => array(
        'resources' => array('users_roles_add', 'users_roles_update')
    ),
    'users-roles-permissions' => array(
        'resources' => array('users_roles_add', 'users_roles_update')
    ),
    /* Enti terzi */
    'admin/enti-terzi-summary' => array(
        'resources' => array('enti_terzi_add', 'enti_terzi_update')
    ),
    'admin/enti-terzi-form' => array(
        'resources' => array('enti_terzi_add', 'enti_terzi_update')
    ),
    /* Tickets */
    'admin/tickets-summary' => array(
        //'resources' => array('tickets_add', 'tickets_update')
    ),
    'admin/tickets-form' => array(
        //'resources' => array('tickets_add', 'tickets_update')
    ),
    /* Sezioni */
    'admin/sezioni-summary' => array(
        'resources' => array( 'contenuti_sezioni_update' )
    ),
    'admin/sezioni-form' => array(
        'resources' => array( 'contenuti_sezioni_add', 'contenuti_sezioni_update' )
    ),
    /* Sottosezioni */
    'admin/sottosezioni-summary' => array(
        'resources' => array( 'contenuti_sezioni_update' )
    ),
    'admin/sottosezioni-form' => array(
        'resources' => array( 'contenuti_sezioni_add', 'contenuti_sezioni_update' )
    ),
    /* Logs */
    'admin/log-summary' => array(
        'resources' => array('logs_add')
    ),
    /* Home page */
    'admin/homepage-blocks-positions' => array(
        // 'resources' => array('homepage_positions_update')
    ),
    /* Datatables summary */
    'datatables' => array(
        'sottosezioni-contenuti' => array(
            'resources' => array(
                'contenuti_sottosezioni_add', 'contenuti_sottosezioni_update',
            )
        ),
        'albo-pretorio' => array(
            'resources' => array(
                'albo_pretorio_add', 'albo_pretorio_update'
            )
        ),
        'albo-pretorio-sezioni' => array(
            'resources' => array(
                'albo_pretorio_sezioni_add', 'albo_pretorio_sezioni_update'
            )
        ),
        'stato-civile-sezioni' => array(
            'resources' => array(
                'stato_civile_sezioni_add', 'stato_civile_sezioni_update'
            )
        ),
        'atti-concessione-mod-assign' => array(
            'resources' => array(
                'atti_concessione_mod-assign_add', 'atti_concessione_update'
            )
        ),
        'contratti-pubblici-scelta-contraente' => array(
            'resources' => array(
                'contratti_pubblici_scelta_contraente_add', 'contratti_pubblici_scelta_contraente_update'
            )
        ),
        'users' => array(
            'resources' => array(
                'users_add', 'users_update'
            )
        ),
        'users-roles' => array(
            'resources' => array(
                'users_roles_add', 'users_roles_update'
            )
        ),
        'users-settori' => array(
            'resources' => array(
                'users_settori_add', 'users_settori_update'
            )
        ),
    ),
);
