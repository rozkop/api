<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/rozkop/api.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('rozkop.com')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/rozkop');

// Hooks

after('deploy:failed', 'deploy:unlock');
