<?php
namespace Deployer;

require 'recipe/symfony4.php';

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
    ->roles('app')
    ->set('deploy_path', '~/projects/{{application}}');    
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

/*
task('update:permissions', function () {
    run('chmod -R a+w {{release_path}}/bootstrap/cache');
    run('chown -R {{user}}:{{user}} {{release_path}} -h');
});
*/

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');

