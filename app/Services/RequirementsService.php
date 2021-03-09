<?php


namespace App\Services;

/*
 *
 * Special thanks for the help https://github.com/GastonHeim
 * https://github.com/GastonHeim/Laravel-Requirement-Checker
 *
 */

use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class RequirementsService
{
    public $laravel_version;
    public $laravel_final_version;
    public $required_versions    = array();
    public $required_modules     = array();
    public $required_services    = array();
    public $required_connections = array();


    public function __construct()
    {
        $this->laravel_version       = app()->version();
        $this->laravel_final_version = substr($this->laravel_version, 0, 1) . '.0';

        $scheduler_log = File::get(storage_path("scheduler_heartbeat.log"));
        $this->laravel_scheduler_diff = Carbon::parse($scheduler_log)->diffInMinutes(Carbon::now());

        $this->requiredVersions();
        $this->requiredModules();
        $this->requiredServices();
        $this->requiredConnections();

        $this->laravel_packagist = end($this->getComposerPackage('laravel', 'framework')->packages->{'laravel/framework'});
        $this->compare_laravel_versions = version_compare($this->laravel_version, substr($this->laravel_packagist->version, 1), ">=");

        $this->laravel_horizon = class_exists('\Laravel\Horizon\Horizon');
        $this->laravel_telescope = class_exists('\Laravel\Telescope\Telescope');
        $this->laravel_socialite = class_exists('\Laravel\Socialite\Facades\Socialite');

    }

    public function requiredModules()
    {
        $this->required_modules['php'] = ['loaded' => false, 'v' => '0'];
        // PHP Version
        if (is_array($this->required_versions[$this->laravel_final_version]['php'])) {
            $this->required_modules['php']['loaded'] = true;
            foreach ($this->required_versions[$this->laravel_final_version]['php'] as $operator => $version) {
                if (!version_compare(PHP_VERSION, $version, $operator)) {
                    $this->required_modules['php']['loaded'] = false;
                    break;
                }
            }
        } else {
            $this->required_modules['php']['loaded'] = version_compare(PHP_VERSION, $this->required_versions[$this->laravel_final_version]['php'], ">=");
        }
        $this->required_modules['php']['v'] = PHP_VERSION;

        // OpenSSL PHP Extension
        $this->required_modules['openssl'] = [
            'loaded' => extension_loaded("openssl"),
            'v' => phpversion("openssl")
        ];

        // PDO PHP Extension
        $this->required_modules['pdo'] = [
            'loaded' => defined('PDO::ATTR_DRIVER_NAME'),
            'v' => phpversion("pdo")
        ];

        // Mbstring PHP Extension
        $this->required_modules['mbstring'] = [
            'loaded' => extension_loaded("mbstring"),
            'v' => phpversion("mbstring")
        ];

        // Tokenizer PHP Extension
        $this->required_modules['tokenizer'] = [
            'loaded' => extension_loaded("tokenizer"),
            'v' => phpversion("tokenizer")
        ];

        // XML PHP Extension
        $this->required_modules['xml'] = [
            'loaded' => extension_loaded("xml"),
            'v' => phpversion("xml")
        ];

        // CTYPE PHP Extension
        $this->required_modules['ctype'] = [
            'loaded' => extension_loaded("ctype"),
            'v' => phpversion("ctype")
        ];

        // JSON PHP Extension
        $this->required_modules['json'] = [
            'loaded' => extension_loaded("json"),
            'v' => phpversion("json")
        ];

        // Mcrypt
        $this->required_modules['mcrypt_encrypt'] = [
            'loaded' => extension_loaded("mcrypt_encrypt"),
            'v' => phpversion("mcrypt_encrypt"),
        ];

        // BCMath
        $this->required_modules['bcmath'] = [
            'loaded' => extension_loaded("bcmath"),
            'v' => phpversion("bcmath")
        ];

        // mod_rewrite
        $this->required_modules['mod_rewrite'] = ['loaded' => '', 'v' => ''];

        if (function_exists('apache_get_modules')) {
            $this->required_modules['mod_rewrite']['loaded'] = in_array('mod_rewrite', apache_get_modules());
            $this->required_modules['mod_rewrite']['v'] = phpversion("mod_rewrite");
        }
    }

    public function requiredVersions()
    {
        $laravel42Obs = 'As of PHP 5.5, some OS distributions may require you to manually install the PHP JSON extension.
When using Ubuntu, this can be done via apt-get install php5-json.';
        $laravel50Obs = 'PHP version should be < 7. As of PHP 5.5, some OS distributions may require you to manually install the PHP JSON extension.
When using Ubuntu, this can be done via apt-get install php5-json';

        $this->required_versions = array(
            '4.2' => array(
                'php'       => '5.4',
                'mcrypt'    => true,
                'pdo'       => false,
                'openssl'   => false,
                'mbstring'  => false,
                'tokenizer' => false,
                'xml'       => false,
                'ctype'     => false,
                'json'      => false,
                'obs'       => $laravel42Obs
            ),
            '5.0' => array(
                'php'       => '5.4',
                'mcrypt'    => true,
                'openssl'   => true,
                'pdo'       => false,
                'mbstring'  => true,
                'tokenizer' => true,
                'xml'       => false,
                'ctype'     => false,
                'json'      => false,
                'obs'       => $laravel50Obs
            ),
            '5.1' => array(
                'php'       => '5.5.9',
                'mcrypt'    => false,
                'openssl'   => true,
                'pdo'       => true,
                'mbstring'  => true,
                'tokenizer' => true,
                'xml'       => false,
                'ctype'     => false,
                'json'      => false,
                'obs'       => ''
            ),
            '5.2' => array(
                'php'       => array(
                    '>=' => '5.5.9',
                    '<'  => '7.2.0',
                ),
                'mcrypt'    => false,
                'openssl'   => true,
                'pdo'       => true,
                'mbstring'  => true,
                'tokenizer' => true,
                'xml'       => false,
                'ctype'     => false,
                'json'      => false,
                'obs'       => ''
            ),
            '5.3' => array(
                'php'       => array(
                    '>=' => '5.6.4',
                    '<'  => '7.2.0',
                ),
                'mcrypt'    => false,
                'openssl'   => true,
                'pdo'       => true,
                'mbstring'  => true,
                'tokenizer' => true,
                'xml'       => true,
                'ctype'     => false,
                'json'      => false,
                'obs'       => ''
            ),
            '5.4' => array(
                'php'       => '5.6.4',
                'mcrypt'    => false,
                'openssl'   => true,
                'pdo'       => true,
                'mbstring'  => true,
                'tokenizer' => true,
                'xml'       => true,
                'ctype'     => false,
                'json'      => false,
                'obs'       => ''
            ),
            '5.5' => array(
                'php'       => '7.0.0',
                'mcrypt'    => false,
                'openssl'   => true,
                'pdo'       => true,
                'mbstring'  => true,
                'tokenizer' => true,
                'xml'       => true,
                'ctype'     => false,
                'json'      => false,
                'obs'       => ''
            ),
            '5.6' => array(
                'php'       => '7.1.3',
                'mcrypt'    => false,
                'openssl'   => true,
                'pdo'       => true,
                'mbstring'  => true,
                'tokenizer' => true,
                'xml'       => true,
                'ctype'     => true,
                'json'      => true,
                'obs'       => ''
            ),
            '5.7' => array(
                'php'       => '7.1.3',
                'mcrypt'    => false,
                'openssl'   => true,
                'pdo'       => true,
                'mbstring'  => true,
                'tokenizer' => true,
                'xml'       => true,
                'ctype'     => true,
                'json'      => true,
                'obs'       => ''
            ),
            '5.8' => array(
                'php'       => '7.1.3',
                'mcrypt'    => false,
                'openssl'   => true,
                'pdo'       => true,
                'mbstring'  => true,
                'tokenizer' => true,
                'xml'       => true,
                'ctype'     => true,
                'json'      => true,
                'obs'       => ''
            ),
            '6.0' => array(
                'php'       => '7.2.0',
                'mcrypt'    => false,
                'openssl'   => true,
                'pdo'       => true,
                'mbstring'  => true,
                'tokenizer' => true,
                'xml'       => true,
                'ctype'     => true,
                'json'      => true,
                'bcmath'    => true,
                'obs'       => ''
            ),
            '7.0' => array(
                'php'       => '7.2.5',
                'mcrypt'    => false,
                'openssl'   => true,
                'pdo'       => true,
                'mbstring'  => true,
                'tokenizer' => true,
                'xml'       => true,
                'ctype'     => true,
                'json'      => true,
                'bcmath'    => true,
                'obs'       => ''
            ),
        );
    }

    public function requiredServices()
    {

        $this->required_services['Redis']     = $this->checkModuleLoaded("redis");
        $this->required_services['Memcached'] = $this->checkModuleLoaded("memcache");

    }

    public function requiredConnections()
    {
        $this->required_connections['Redis']     = $this->checkConnectionFsocket(env("REDIS_HOST", '127.0.0.1'), env("REDIS_PORT", 6379));
        $this->required_connections['Memcached'] = $this->checkConnectionFsocket(env('MEMCACHED_HOST', '127.0.0.1'), env('MEMCACHED_PORT', 11211));

    }

    public function checkModuleLoaded($module)
    {
        if (extension_loaded($module)) {
            return true;
        }
        return false;
    }

    public function checkConnectionFsocket($host, $port)
    {
        if (!@fsockopen($host, $port, $errno, $errstr, 3)) {
            return false;
        }
        return true;
    }

    public function getComposerPackage($vendor, $package)
    {
        $ApiService = new ApiService('https://repo.packagist.org/p/'.$vendor.'/'.$package.'.json', 'GET', []);
        $ApiService->setCurlCache(true, 4800);
        return $ApiService->call();
    }
}