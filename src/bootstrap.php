<?php
/**
 * BellHop
 *
 * @author    Jacques Marneweck <jacques@siberia.co.za>
 * @copyright 2018 Jacques Marneweck.  All rights strictly reserved.
 * @license   proprietary
 */

require_once __DIR__.'/../vendor/autoload.php';

use \Jacques\BellHop\Template;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'illuminate_non_laravel',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
]);

session_name('bellhop');
session_start();

define('TEMPLATE_SMARTY_BASEDIR', __DIR__.'/../tmp/');
define('TEMPLATE_BASEDIR', __DIR__.'/../');

$app = new \Slim\App;
$app->template = new Template;

require_once __DIR__.'/functions.php';
require_once __DIR__.'/routes.php';
