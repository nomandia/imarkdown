<?php
/**
 * Created by imarkdown.
 * Author: Nomandia
 * Date: 2018/8/6
 * Time: 17:40
 */

namespace Nomandia\IMarkdown\Traits;

use Nomandia\IMarkdown\IMarkdown;

class MarkdownTrait
{
    protected $imarkdown = null;

    public function htmlToMarkdown($html = null)
    {
        $html = $html ?: $this->{$this->getHtmlColumn()};
        if (is_null($html)) {
            return null;
        }
        return $this->getIMarkdown()->html2Markdown($html);
    }

    public function markdownToHTML($markdown = null)
    {
        $markdown = $markdown ?: $this->{$this->getMarkdownColumn()};
        if (is_null($markdown)) {
            return null;
        }
        return $this->getIMarkdown()->markdown2Html($markdown);
    }

    public function getHtmlColumn()
    {
        return defined('static::HTML_COL') ? static::HTML_COL : 'html';
    }

    public function getMarkdownColumn()
    {
        return defined('static::MARKDOWN_COL') ? static::MARKDOWN_COL : 'content';
    }

    protected function getIMarkdown()
    {
        return $this->imarkdown ?: $this->imarkdown = new IMarkdown();
    }
}