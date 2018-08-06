<?php
namespace BroQiang\LaravelMarkdown;

class IMarkdownView
{

    protected $autoHeight = false;

    protected $height = false;

    public static function markdownPreviewCss()
    {
        return static::getEditorCss(config('imarkdown.markdown_preview_css'));
    }

    public static function markdownPreviewJs()
    {
        $js = static::getEditorJs(config('imarkdown.markdown_preview_js'));

        $lineNumbers = config('imarkdown.markdown_preview_line_number') ? 'hljs.initLineNumbersOnLoad();' : '';

        $js .= '<script>
    $("pre code").each(function(e, t) {
        hljs.highlightBlock(t);
    });' . 
    $lineNumbers .
'</script>';

        return $js;
    }

    public static function editormdCss()
    {
        return static::getEditorCss(config('imarkdown.editormd_css'));
    }

    protected static function getEditorCss($list)
    {
        return array_reduce($list, function ($str = '', $css) {
            $str .= '<link rel="stylesheet" href="' . asset($css) . '"/>' . "\n";
            return $str;
        });
    }

    public static function editormdJs($is_width = true, $height = false)
    {
        $instance   = new static;
        $editormdJs = static::getEditorJs(config('imarkdown.editormd_js'));

        $instance->autoHeight = $is_width;

        if ($height) {
            $instance->height = $height;
        }

        $editormds = config('imarkdown.editormds');

        $editormdJs .= '
            <script type="text/javascript">
    var ' . implode(array_keys($editormds), ', ') . ';
    ' . array_reduce($editormds, [$instance, 'formatEditormds']) . '
</script>
        ';

        return $editormdJs;
    }

    protected function formatEditormds($str = '', $item = null)
    {
        $autoHeight = $this->autoHeight ? $item['autoHeight'] : 'false';

        $height = $this->height ?: $item['height'];

        $str .= '
    $(function () {
        ' . $item['id'] . ' = editormd("' . $item['id'] . '",{
            width: "' . $item['width'] . '",
            height: ' . $height . ',
            theme: "' . $item['theme'] . '",
            editorTheme:"default",
            previewTheme:"default",
            path: "' . $item['path'] . '",
            toolbarIcons : function() {
                return ' . json_encode($item['toolbarIcons']) . '
            },
            codeFold:true,
            autoHeight : ' . $autoHeight . ',
            saveHTMLToTextarea: true,
            searchReplace: true,
            imageUpload: ' . $item['imageUpload'] . ',
            imageFormats: ' . json_encode($item['imageFormats']) . ',
            imageUploadURL: "' . route($item['imageUploadURL']) . '?token=' . csrf_token() . '",
        });
    });
        ';

        return $str;
    }

    protected static function getEditorJs($list)
    {
        return array_reduce($list, function ($str = '', $js) {
            $str .= '<script src="' . asset($js) . '"></script>' . "\n";
            return $str;
        });
    }
}
