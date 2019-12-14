<?php
namespace Deployer;

require 'recipe/symfony.php';

// Project name
set('application', 'aukcje');

// Project repository
set('repository', 'git@github.com:maruleq/aukcje.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('grabowskispace.pl')
        ->stage('production')
        ->user('marek')
        ->set('branch', 'master')
        ->set('deploy_path', '~/projects/{{application}}');    
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');

