<?php
/**
 * Hydra Framework
 *
 * PHP Version 5
 *
 * @package   Hydra
 * @author    Jacques Marneweck <jacques@php.net>
 * @copyright 2002-2018 Jacques Marneweck.  All rights reserved.
 * @version   SVN: $Id: Template.php 1503 2014-07-10 20:58:23Z jacques $
 */

namespace Jacques\BellHop;

/**
 * Wrapper around Smarty
 *
 * @package Hydra
 * @author  Jacques Marneweck <jacques@php.net>
 */
class Template extends \Smarty
{
    /**
     * Constructor
     */
    public function __construct(): void
    {
        /**
         * Required for Smart v3.1.x
         */
        parent::__construct();

        $this->template_dir = TEMPLATE_BASEDIR . '/templates/';
        $this->compile_dir = TEMPLATE_SMARTY_BASEDIR . '/templates_c/';
        $this->cache_dir = TEMPLATE_SMARTY_BASEDIR . '/cache/';

        $this->caching = false;
        $this->compile_check = true;
        $this->force_compile = false;
        $this->debugging = false;

        /**
         * We need to specify the plugins dir of smarty else smarty is
         * dumb enough to not know where it's default plugins are located
         * when using Smarty 3.x.x
         */
        if ('Darwin' === php_uname('s')) {
            $this->setPluginsDir(SMARTY_DIR . '/plugins')
                ->addPluginsDir(TEMPLATE_BASEDIR . '/plugins/');
        } else {
            $this->setPluginsDir(SMARTY_DIR . '/plugins')
                ->addPluginsDir(TEMPLATE_BASEDIR . '/plugins/');
        }

        if (!is_writable($this->compile_dir)) {
            die('Cannot write to specified compile directory.');
        }

        if (!is_writable($this->cache_dir)) {
            die('Cannot write to specified cache directory.');
        }
    }

    /**
     * Bulk assign variables from an array
     *
     * @param array   array of key => values to set
     */
    public function bulkAssign(array $array): void
    {
        while (list($key, $value) = each($array)) {
            $this->assign($key, $value);
        }
    }
}
