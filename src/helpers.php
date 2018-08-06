<?php

use Nomandia\IMarkdown\IMarkdown;

/**
 * editor.md 输出md的页面内容
 * 使用方法：{!! editormd_css() !!}
 */

if (!function_exists('editormd_css')) {
    function editormd_css()
    {
        return IMarkdown::editormdCss();
    }
}

if (!function_exists('editormd_js')) {
    function editormd_js($is_width = true, $height = false)
    {
        return IMarkdown::editormdJs($is_width, $height);
    }
}

if (!function_exists('markdown_preview_css')) {
    function markdown_preview_css()
    {
        return IMarkdown::markdownPreviewCss();
    }
}

if (!function_exists('markdown_preview_js')) {
    function markdown_preview_js()
    {
        return IMarkdown::markdownPreviewJs();
    }
}
