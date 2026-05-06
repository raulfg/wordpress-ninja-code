<?php

namespace Deployer;

require 'recipe/common.php';

host('produccion')
    ->setHostname(getenv('DEPLOY_HOST'))
    ->setRemoteUser(getenv('DEPLOY_USER'))
    ->setIdentityFile('~/.ssh/id_deploy')
    ->setDeployPath('/var/www/html');

set('repository', 'git@github.com:tuusuario/tu-proyecto.git');
set('branch', 'main');
set('keep_releases', 5);

set('shared_dirs', ['wp-content/uploads']);
set('shared_files', ['.env']);
set('writable_dirs', ['wp-content/uploads', 'wp-content/cache']);

task('wp:update_db', function () {
    run('cd {{release_path}} && wp core update-db --allow-root');
});

task('wp:cache_flush', function () {
    run('cd {{release_path}} && wp cache flush --allow-root');
});

after('deploy:symlink', 'wp:update_db');
after('deploy:symlink', 'wp:cache_flush');
after('deploy:failed', 'deploy:unlock');
