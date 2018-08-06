# imarkdown
Simply markdown toolkit

>这个项目参考了 broqiang/laravel-markdown

## 依赖组件

- [Laravel](https://laravel.com/) 框架

- [editor.md](http://pandao.github.io/editor.md/) Markdown 富文本编辑器

- [github-markdown-css](https://github.com/sindresorhus/github-markdown-css) 样式是通过此 css 修改的

- [highlight.js](https://github.com/isagalaev/highlight.js) 预览代码高亮，是通过这个实现的

- [prettify.js]() 代码框添加编号，直接使用的是 `editor.md/lib` 中的

- [erusev/parsedown](https://github.com/erusev/parsedown) 用来将 markdown 转换成 html

- [mews/purifier](https://github.com/mewebstudio/Purifier) markdown 转换 html 的时候进行过滤，方式 XSS 攻击

- [league/html-to-markdown](https://github.com/thephpleague/html-to-markdown) 用来将 html 转换成 markdown


## 安装组件

```bash
composer require nomandia/imarkdown
```

#### 发布配置文件

这里面有一些默认的配置，如下，如果需要自定义配置执行此部，如果不需要可以不用发布配置文件

```bash
php artisan vendor:publish --provider="Nomandia\IMarkdown\IMarkdownProvider" --tag="config"
```

配置文件详情，可以根据实际需求去配置

```php
<?php

return [

    /**
     * markdown 预览相关的配置
     */

    // 预览时的 css
    'markdown_preview_css' => [
        'vendor/markdown.show/css/markdown.css',
    ],

    // 预览时的 js
    'markdown_preview_js' => [
        'vendor/markdown.show/js/highlight.js',
        'vendor/editormd/lib/prettify.min.js',
    ],

    /**
     * 下面是富文本编辑器 editor.md 相关的配置
     */

    // markdown 富文本编辑器的 css 路径
    'editormd_css'         => [
        'vendor/editormd/css/editormd.css',
        'vendor/markdown.show/css/markdown.css',
    ],

    // markdown 富文本编辑器的 js 路径
    'editormd_js'          => [
        'vendor/editormd/js/editormd.js',
    ],

    // 上传文件目录，根目录由依赖的 broqiang/laravel-image  的配置文件决定，这里是二级目录
    // 更多的 上传部分去配置 broqiang/laravel-image 的配置文件
    'upload_path'          => 'editormd',

    'image_prefix'         => '', // 上传图片的前缀

    // 文本编辑器的配置，可以直接多个，一个数据是一个，模本中的 id 就是 这里的key，如 editormd_id1
    'editormds'            => [
        'editormd_id' => [
            'id'             => 'editormd_id', // 模板中使用的 id，这里要求和 key 相同
            'width'          => '100%', // 编辑器宽度
            'height'         => '100%', // 编辑器高度
            'theme'          => 'default', // 主题，可以用的：白色-default，黑色-dark
            'path'           => '/vendor/editormd/lib/', // 插件保存位置
            'toolbarIcons'   => [
                "undo", "redo", "|",
                "bold", "del", "italic", "quote", "|",
                "h1", "h2", "h3", "h4", "h5", "h6", "|",
                "list-ul", "list-ol", "hr", "|",
                "link", "image", "code", "code-block", "table", "html-entities", "||",
                "watch", "preview", "fullscreen", "clear", "search", "|",
                "help",
            ], // 工具栏按钮
            'autoHeight'     => 'true', // 自动高度
            'imageUpload'    => 'true', // 是否可以上传图片
            'imageFormats'   => ['jpg', 'jpeg', 'gif', 'png'], // 允许上传的图片类型
            // 上传图片的路由，使用的是 name() 中的内容，也可以自己写上传类，将路由改成自己的路由即可
            'imageUploadURL' => 'bro.emditormd.upload', 
        ],
    ],
];
```


#### 生成静态资源 css、 js 等

```bash
php artisan vendor:publish --provider="BroQiang\LaravelMarkdown\LaravelMarkdownProvider" --tag="public"
```

## 模板中使用

#### 预览时

__css 部分配置__

```php
<head>
{!! markdown_preview_css() !!}
</head>
```

__js 部分配置__

```php
{!! markdown_preview_js() !!}
```

#### 文本编辑器中使用

__css 部分配置__

```php
{!! editormd_css() !!}
```

__js 部分配置__

> 这个需要注意，要将这个标签写在 jquery 之后

```php
{!! editormd_js() !!}
```

__模板部分__

bootstrap 4

```html
<!-- 这里因为用的是 bootstrap 4，所以使用的 d-none 来隐藏 textarea -->
<div id="editormd_id">
    <textarea class="d-none" name="body"># 我是标题</textarea>
</div>
```

bootstrap 3

```html
<!-- 这里因为用的是 bootstrap 4，所以使用的 d-none 来隐藏 textarea -->
<div id="editormd_id">
    <textarea name="body" style="display: none;"># 我是标题</textarea>
</div>
```
