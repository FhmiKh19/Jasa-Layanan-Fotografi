<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Socialite Factory jika belum terdaftar
        $factoryClass = 'Laravel\Socialite\Contracts\Factory';
        if (!$this->app->bound($factoryClass)) {
            // Pastikan semua file Socialite ter-load
            $basePath = base_path('vendor/laravel/socialite/src');
            
            // Load interface Factory
            $factoryFile = $basePath . '/Contracts/Factory.php';
            if (file_exists($factoryFile) && !interface_exists($factoryClass)) {
                require_once $factoryFile;
            }
            
            // Load SocialiteManager dan dependency-nya
            $this->loadSocialiteFiles($basePath);
            
            $this->app->singleton($factoryClass, function ($app) {
                $socialiteManagerClass = 'Laravel\Socialite\SocialiteManager';
                return new $socialiteManagerClass($app);
            });
        }
    }
    
    /**
     * Load semua file Socialite yang diperlukan
     */
    private function loadSocialiteFiles($basePath): void
    {
        // Load Contracts terlebih dahulu
        $contracts = ['Factory', 'Provider', 'User'];
        foreach ($contracts as $contract) {
            $file = $basePath . '/Contracts/' . $contract . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
        }
        
        // Load Two/ProviderInterface
        $providerInterfaceFile = $basePath . '/Two/ProviderInterface.php';
        if (file_exists($providerInterfaceFile) && !interface_exists('Laravel\Socialite\Two\ProviderInterface')) {
            require_once $providerInterfaceFile;
        }
        
        // Load AbstractUser terlebih dahulu (dependency untuk Two\User)
        $abstractUserFile = $basePath . '/AbstractUser.php';
        if (file_exists($abstractUserFile) && !class_exists('Laravel\Socialite\AbstractUser')) {
            require_once $abstractUserFile;
        }
        
        // Load Token terlebih dahulu sebelum AbstractProvider
        $tokenFile = $basePath . '/Two/Token.php';
        if (file_exists($tokenFile) && !class_exists('Laravel\Socialite\Two\Token')) {
            require_once $tokenFile;
        }
        
        // Load User class untuk Two (setelah AbstractUser)
        $twoUserFile = $basePath . '/Two/User.php';
        if (file_exists($twoUserFile) && !class_exists('Laravel\Socialite\Two\User')) {
            require_once $twoUserFile;
        }
        
        // Load AbstractProvider
        $abstractProviderFile = $basePath . '/Two/AbstractProvider.php';
        if (file_exists($abstractProviderFile) && !class_exists('Laravel\Socialite\Two\AbstractProvider')) {
            require_once $abstractProviderFile;
        }
        
        // Load GoogleProvider
        $googleProviderFile = $basePath . '/Two/GoogleProvider.php';
        if (file_exists($googleProviderFile) && !class_exists('Laravel\Socialite\Two\GoogleProvider')) {
            require_once $googleProviderFile;
        }
        
        // Load SocialiteManager terakhir (setelah semua provider ter-load)
        $managerFile = $basePath . '/SocialiteManager.php';
        if (file_exists($managerFile) && !class_exists('Laravel\Socialite\SocialiteManager')) {
            require_once $managerFile;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix cURL SSL certificate untuk Laragon
        // Cek beberapa lokasi yang mungkin
        $possiblePaths = [
            base_path('vendor/guzzlehttp/guzzle/src/cacert.pem'),
            'D:/laragon-6.0-minimal/etc/ssl/cacert.pem',
            'D:/laragon-8.2/etc/ssl/cacert.pem',
            'C:/laragon-6.0-minimal/etc/ssl/cacert.pem',
            'C:/laragon-8.2/etc/ssl/cacert.pem',
            base_path('vendor/guzzlehttp/guzzle/cacert.pem'),
        ];
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                putenv("SSL_CERT_FILE={$path}");
                putenv("CURL_CA_BUNDLE={$path}");
                break;
            }
        }
    }
}
