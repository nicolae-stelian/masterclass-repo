<?php


class FrontController
{

    private $config;
    private $serverRedirectBase = '';
    private $serverRequestUri = '';

    private $controller = '';
    private $method = '';

    public function __construct($config, $requestUri = '', $redirectBase = '')
    {
        $this->config = $config;
        $this->serverRequestUri = $requestUri;
        $this->serverRedirectBase = $redirectBase;
        $this->parse();
    }

    public function execute()
    {
        $class = $this->getController();
        $method = $this->getMethod();
        $o = new $class($this->config);
        return $o->$method();
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMethod()
    {
        return $this->method;
    }

    protected function parse()
    {
        $path = str_replace($this->serverRedirectBase, '', $this->serverRequestUri);

        foreach ($this->config['routes'] as $routePath => $route) {
            $matches = array();
            $pattern = '$' . $routePath . '$';
            if (preg_match($pattern, $path, $matches)) {
                $parts = explode('/', $route);
                $this->controller = ucfirst($parts[0]);
                $this->method = $parts[1];
            }
        }
    }
}