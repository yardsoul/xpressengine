<?php
/**
 * Service provider
 *
 * @category  Install
 * @package   Xpressengine\Install
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   LGPL-2.1
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link      https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Route;
use File;

/**
 * Install Service Provider
 *
 * @category Install
 * @package  Xpressengine\Install
 */
class InstallServiceProvider extends ServiceProvider
{

    /**
     * Service Provider Boot
     *
     * @return void
     */
    public function boot()
    {
        Route::get('/', function() {
            return redirect('/web_installer');
        });

        Route::post('/install/post', '\App\Http\Controllers\InstallController@install');

        \App\Http\Middleware\ExceptAppendableVerifyCsrfToken::setExcept('/install/post');

        $appKeyPath = storage_path('app') . '/appKey';
        if (File::exists($appKeyPath) === false) {
            File::put($appKeyPath, Str::random(32));
        }
        app('config')->set('app.key', File::get($appKeyPath));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}
