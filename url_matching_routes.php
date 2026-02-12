<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/xdebug' => [[['_route' => '_profiler_xdebug', '_controller' => 'web_profiler.controller.profiler::xdebugAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/ajouter_genre' => [[['_route' => 'ajouter_genre', '_controller' => 'App\\Controller\\LivreController::ajouter_genre'], null, null, null, false, false, null]],
        '/ajouter_auteur' => [[['_route' => 'ajouter_auteur', '_controller' => 'App\\Controller\\LivreController::ajouter'], null, null, null, false, false, null]],
        '/livre_titre_inverse' => [[['_route' => 'livre_titre_inverse', '_controller' => 'App\\Controller\\LivreController::inversé_titre_livre'], null, null, null, false, false, null]],
        '/recherche' => [[['_route' => 'recherche_livre', '_controller' => 'App\\Controller\\LivreController::rechercheLivre'], null, null, null, false, false, null]],
        '/menu' => [[['_route' => 'menu', '_controller' => 'App\\Controller\\LivreController::menu'], null, null, null, false, false, null]],
        '/ajouter_livre' => [[['_route' => 'ajouter_livre', '_controller' => 'App\\Controller\\LivreController::ajouter_livre'], null, null, null, false, false, null]],
        '/auteur_3_livres_au_moins' => [[['_route' => 'auteur_3_livres_au_moins', '_controller' => 'App\\Controller\\LivreController::auteur_3_livres_au_moins'], null, null, null, false, false, null]],
        '/autantHommeFemme' => [[['_route' => 'autantHommeFemme', '_controller' => 'App\\Controller\\LivreController::autantHommeFemme'], null, null, null, false, false, null]],
        '/genres/auteurs' => [[['_route' => 'genres_auteurs', '_controller' => 'App\\Controller\\LivreController::genresAuteurs'], null, null, null, false, false, null]],
        '/auteurs/genres' => [[['_route' => 'auteurs_genres', '_controller' => 'App\\Controller\\LivreController::auteursGenres'], null, null, null, false, false, null]],
        '/auteur3livresAuMoins' => [[['_route' => 'auteur3livresAuMoins', '_controller' => 'App\\Controller\\LivreController::auteur3livresAuMoins'], null, null, null, false, false, null]],
        '/autantHommesFemmes' => [[['_route' => 'autantHommesFemmes', '_controller' => 'App\\Controller\\LivreController::autantHommesFemmes'], null, null, null, false, false, null]],
        '/livreNationaliteDiff' => [[['_route' => 'livreNationaliteDiff', '_controller' => 'App\\Controller\\LivreController::livreNationaliteDiff'], null, null, null, false, false, null]],
        '/lister_livres' => [[['_route' => 'lister_livres', '_controller' => 'App\\Controller\\LivreController::lister_livres'], null, null, null, false, false, null]],
        '/lister_auteurs' => [[['_route' => 'lister_auteurs', '_controller' => 'App\\Controller\\LivreController::list_auteurs'], null, null, null, false, false, null]],
        '/lister_genres' => [[['_route' => 'lister_genres', '_controller' => 'App\\Controller\\LivreController::list_genres'], null, null, null, false, false, null]],
        '/list_genre_all' => [[['_route' => 'list_genre_all', '_controller' => 'App\\Controller\\LivreController::list_genre_all'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/(?'
                        .'|font/([^/\\.]++)\\.woff2(*:98)'
                        .'|([^/]++)(?'
                            .'|/(?'
                                .'|search/results(*:134)'
                                .'|router(*:148)'
                                .'|exception(?'
                                    .'|(*:168)'
                                    .'|\\.css(*:181)'
                                .')'
                            .')'
                            .'|(*:191)'
                        .')'
                    .')'
                .')'
                .'|/afficher_detail_auteur/([^/]++)(*:234)'
                .'|/modifier_(?'
                    .'|auteur/([^/]++)(*:270)'
                    .'|genre/([^/]++)(*:292)'
                    .'|livre/([^/]++)(*:314)'
                .')'
                .'|/supprimer_(?'
                    .'|auteur/([^/]++)(*:352)'
                    .'|genre/([^/]++)(*:374)'
                    .'|livre/([^/]++)(*:396)'
                .')'
                .'|/details_livre/([^/]++)(*:428)'
                .'|/lister_livres_date/([^/]++)/([^/]++)(*:473)'
                .'|/genre/([^/]++)/total\\-pages(*:509)'
                .'|/Livres2date2notes/([^/]++)/([^/]++)(?:/([^/]++)(?:/([^/]++))?)?(*:581)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        98 => [[['_route' => '_profiler_font', '_controller' => 'web_profiler.controller.profiler::fontAction'], ['fontName'], null, null, false, false, null]],
        134 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        148 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        168 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        181 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        191 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        234 => [[['_route' => 'afficher_detail_auteur', '_controller' => 'App\\Controller\\LivreController::afficher_detail_auteur'], ['id'], null, null, false, true, null]],
        270 => [[['_route' => 'modifier_auteur', '_controller' => 'App\\Controller\\LivreController::modifier_auteur'], ['id'], null, null, false, true, null]],
        292 => [[['_route' => 'modifier_genre', '_controller' => 'App\\Controller\\LivreController::modifier_genre'], ['id'], null, null, false, true, null]],
        314 => [[['_route' => 'modifier_livre', '_controller' => 'App\\Controller\\LivreController::modifier_livre'], ['id'], null, null, false, true, null]],
        352 => [[['_route' => 'supprimer_auteur', '_controller' => 'App\\Controller\\LivreController::supprimer_auteur'], ['id'], null, null, false, true, null]],
        374 => [[['_route' => 'supprimer_genre', '_controller' => 'App\\Controller\\LivreController::supprimer_genre'], ['id'], null, null, false, true, null]],
        396 => [[['_route' => 'supprimer_livre', '_controller' => 'App\\Controller\\LivreController::supprimer_livre'], ['id'], null, null, false, true, null]],
        428 => [[['_route' => 'details_livre', '_controller' => 'App\\Controller\\LivreController::details_livre'], ['id'], null, null, false, true, null]],
        473 => [[['_route' => 'lister_livres_date', '_controller' => 'App\\Controller\\LivreController::lister_livres_date'], ['annee_debut', 'annee_fin'], null, null, false, true, null]],
        509 => [[['_route' => 'genre_total_pages', '_controller' => 'App\\Controller\\LivreController::totalPagesGenre'], ['id'], null, null, false, false, null]],
        581 => [
            [['_route' => 'Livres2date2notes', 'note1' => null, 'note2' => null, '_controller' => 'App\\Controller\\LivreController::Livres2date2notes'], ['dateDebut', 'dateFin', 'note1', 'note2'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
