<?php

return array(
    'user' => array(
        'create' => array(
                'email' => array('required', 'email'),
                'pass' => array('required', 'min:6', 'max:255'),
            ),
        'update' => array(
            'email' => array('required', 'email'),
            'pass' => array('min:6', 'max:255'),
            ),
        'login' => array(
                'username' => array('required', 'min:3', 'max:255', 'alpha'),
                'email' => array('required', 'email'),
                'pass' => array('required', 'min:1', 'max:255'),
            ),
    ),
    'group' => array(
        'groupname' => array('required', 'min:3', 'max:16', 'alpha'),
    ),
    'permission' => array(
        'name' => array('required', 'min:3', 'max:100'),
        'value' => array('required', 'alpha_dash', 'min:3', 'max:100'),
        'description' => array('required', 'min:3', 'max:255')
    ),
);