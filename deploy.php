<?php
namespace Deployer;

require 'recipe/composer.php';

// Config
try {


    // Config
    // Use ssh multiplexing for speedup native ssh client.
    set('ssh_multiplexing', false);

    set('git_ssh_command', 'ssh');

    set('repository', 'git@github.com:Caricanary/ShortCutService.git');

    // [Optional] Allocate tty for git clone. Default value is false.

    set('git_tty', true);

    set('default_timeout', 720);
}catch (\Exception $e){
    echo $e->getMessage();
}
add('shared_files', ['.env']);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('canary_shortcut')
    ->set('remote_user', 'web')
    ->set('port', 22)
    ->set('deploy_path', '/var/www/html')
    ->set('forwardAgent', true)
    ->set('branch', 'main')
    ->set('labels', ['stage' => 'main']);

// Hooks

after('deploy:failed', 'deploy:unlock');
