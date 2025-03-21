<?php

namespace Deployer;

require_once __DIR__.'/vendor/autoload.php';
require 'contrib/cachetool.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'vendor/tombroucke/otomaties-deployer/deploy.php';

/** Config */
set('web_root', 'web');
set('application', 'De BeTOOGing');
set('repository', 'git@github.com:tombroucke/debetooging.git');
set('sage/theme_path', get('web_root').'/app/themes/debetooging');
set('sage/build_command', 'build --clean --flush'); // build --clean for bud, build:production for mix

/** Hosts */
host('production')
    ->set('hostname', 'ssh102.webhosting.be')
    ->set('url', 'https://debetooging.be')
    ->set('basic_auth_user', $_SERVER['BASIC_AUTH_USER'] ?? '')
    ->set('basic_auth_pass', $_SERVER['BASIC_AUTH_PASS'] ?? '')
    ->set('remote_user', 'debetoogingbe')
    ->set('branch', 'main')
    ->set('deploy_path', '/data/sites/web/debetoogingbe/app/main');

host('staging')
    ->set('hostname', 'ssh102.webhosting.be')
    ->set('url', 'https://staging.debetooging.be')
    ->set('basic_auth_user', $_SERVER['BASIC_AUTH_USER'] ?? '')
    ->set('basic_auth_pass', $_SERVER['BASIC_AUTH_PASS'] ?? '')
    ->set('remote_user', 'debetoogingbe')
    ->set('branch', 'staging')
    ->set('deploy_path', '/data/sites/web/debetoogingbe/app/staging');

/** Install theme dependencies */
after('deploy:vendors', 'sage:vendors');

/** Push theme assets */
after('deploy:update_code', 'sage:compile_and_upload_assets');

/** Write revision to file */
after('deploy:update_code', 'otomaties:write_revision_to_file');

/** Reload Combell */
after('deploy:symlink', 'combell:reloadPHP');

/** Clear OPcode cache */
after('deploy:symlink', 'combell:reset_opcode_cache');

/** Cache ACF fields */
after('deploy:symlink', 'acorn:acf_cache');

/** Optimize acorn */
after('deploy:symlink', 'acorn:optimize');

/** Reload cache & preload */
after('deploy:symlink', 'wp_rocket:clear_cache');

/** Reload cache & preload */
after('deploy:symlink', 'wp_rocket:preload_cache');

/** Remove unused themes */
after('deploy:cleanup', 'cleanup:unused_themes');

/** Unlock deploy */
after('deploy:failed', 'deploy:unlock');
