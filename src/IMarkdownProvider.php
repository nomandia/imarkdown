<?php

namespace Nomandia\IMarkdown;

use Illuminate\Support\ServiceProvider;

class IMarkdownProvider extends ServiceProvider
{
    public function boot()
    {
        $rootPath = dirname(__DIR__);

        // 复制配置文件到config目录
        if (!file_exists(config_path('imarkdown.php'))) {
            $this->publishes([
                $rootPath . '/config/imarkdown.php' => config_path('imarkdown.php'),
            ], 'config');
        }

        // 复制静态资源, editor.md 、css 、js 等, 这里目标时复制到 public/vendor目录下
        $this->publishes([
            $rootPath . '/public/' => public_path()
        ], 'public');

        // 复制路由配置
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/config/imarkdown.php', 'imarkdown'
        );
    }
}
