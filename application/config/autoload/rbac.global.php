<?php

return [
    'zfc_rbac' => [
        'protection_policy' => \ZfcRbac\Guard\GuardInterface::POLICY_DENY,
        'guards'            => [
            'ZfcRbac\Guard\RouteGuard' => [

                //Public pages
                'home' => ['guest'],
                'logout' => ['user'],
                'login' => ['guest'],
                'register' => ['guest'],
                'identity' => ['guest'],
                'passport' => ['guest'],
                'birth' => ['guest'],
                'marriage' => ['guest'],
                'money' => ['guest'],
                'conveyance' => ['guest'],
                'reporting' => ['guest'],

                //Account pages
                'user/account' => ['user']
            ]
        ],
        'identity_provider' => \User\Service\AuthenticationService::class,
        'role_provider'     => [
            'ZfcRbac\Role\ObjectRepositoryRoleProvider' => [
                'object_manager'     => 'doctrine.entitymanager.orm_default',
                'class_name'         => 'User\Entity\HierarchicalRole',
                'role_name_property' => 'name'
            ]
        ],
        //IMPORTANT in  Module.php you can set either a redirect strategy OR an error output strategy
        'redirect_strategy' => [
            'redirect_when_connected'        => true,
            'redirect_to_route_connected'    => 'home',
            'redirect_to_route_disconnected' => 'login',
            'append_previous_uri'            => true,
            'previous_uri_query_key'         => 'redirectTo'
        ],

    ]
];
