<?php


namespace Upvote\Views;


class View
{
    protected $layout;
    protected $templateDir;
    protected $params;

    public function __construct()
    {
        $this->layout = 'layout.phtml';
        $this->templateDir = __DIR__ . '/template/';
    }

    public function parseTemplate($template, $params = array())
    {
        $content = file_get_contents($this->templateDir . '/' . $template);
        foreach ($params as $name => $value) {
            $content = str_replace('{{' . $name . '}}', $value, $content);
        }
        return $content;
    }

    public function parseLayout($content)
    {
        $params = array();
        $params['content'] = $content;

        if (isset($_SESSION['AUTHENTICATED'])) {
            $params['links'] = '<a href="/story/create">new</a> ';
            $params['links'] .= '| <a href="/user/account">account</a> ';
            $params['links'] .= '| <a href="/user/logout">logout</a>';
        } else {
            $params['links'] = '<a href="/user/login">login</a>';
        }

        return $this->parseTemplate($this->layout, $params);
    }
} 