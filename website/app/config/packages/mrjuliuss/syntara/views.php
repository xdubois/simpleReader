<?php 

return array(
    // layouts
    'master' => 'syntara::layouts.dashboard.master',
    'header' => 'backend.layouts.header',
    'permissions-select' => 'syntara::layouts.dashboard.permissions-select',

    // dashboard
    'dashboard-index' => 'syntara::dashboard.index',
    'login' => 'syntara::dashboard.login',
    'error' => 'syntara::dashboard.error',

    // users
    'users-index' => 'backend.user.index-user',
    'users-list' => 'backend.user.list-users',
    'user-create' => 'backend.user.new-user',
    'user-informations' => 'backend.user.user-informations',
    'user-profile' => 'backend.user.show-user',
    'user-activation' => 'backend.user.activation',

    // groups
    'groups-index' => 'syntara::group.index-group',
    'groups-list' => 'syntara::group.list-groups',
    'group-create' => 'syntara::group.new-group',
    'users-in-group' => 'backend.group.list-users-group',
    'group-edit' => 'syntara::group.show-group',

    // permissions
    'permissions-index' => 'syntara::permission.index-permission',
    'permissions-list' => 'syntara::permission.list-permissions',
    'permission-create' => 'syntara::permission.new-permission',
    'permission-edit' => 'syntara::permission.show-permission',
);