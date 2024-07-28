<?php
namespace WebConfig;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
class WCServiceProvider extends ServiceProvider {
	protected $defer = false;
    public function register() {
        $this->app->bind('gpwebconfig', function (Application $app) {
            $config = $app->make('config');
            $class = $config->get('gpwebconfig');
            return new $class;
        });
    }
    public function provides() {
        return ['gpwebconfig'];
    }
    public function boot() {
        $this->registerConfigurations();
    }
    protected function registerConfigurations() {
        $this->mergeConfigFrom($this->packagePath('config/gpwebconfig.php'), '');
        $this->publishes([$this->packagePath('config/gpwebconfig.php') => config_path('gpwebconfig.php')]);
    }
    protected function packagePath($path = '') {
        return sprintf('%s/../%s', __DIR__, $path);
    }
}