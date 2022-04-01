<?php

$modules =  config('application_modules.modules');


return [
  'role_structure' => [
    'super_admin' =>  $modules,
  ],
  'permissions_map' => [
    'c' => 'create',
    'r' => 'read',
    'u' => 'update',
    'd' => 'delete'
  ]
];
