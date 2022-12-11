<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Mockery;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $fakeFilesystem = Storage::fake('public');
        $proxyMockedFakeFilesystem = Mockery::mock($fakeFilesystem);
        $proxyMockedFakeFilesystem->shouldReceive('temporaryUrl')
            ->andReturn('http://localhost/temporary');
        Storage::set('public', $proxyMockedFakeFilesystem);
    }
}
