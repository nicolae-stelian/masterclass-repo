<?php


class MasterController {
    
    private $config;
    private $serverRedirectBase = '';
    private $serverRequestUri = '';
    
    public function __construct($config, $requestUri = '', $redirectBase = '') {
        $this->config = $config;
        if (isset($_SERVER['REQUEST_URI'])) {
            $this->serverRequestUri = $_SERVER['REQUEST_URI'];
        }

        if (isset($_SERVER['REDIRECT_BASE'])) {
            $this->serverRedirectBase = $_SERVER['REDIRECT_BASE'];
        }

        if (!empty($requestUri)) {
            $this->serverRequestUri = $requestUri;
        }
        if (!empty($redirectBase)) {
            $this->serverRedirectBase = $redirectBase;
        }

    }
    
    public function execute() {
        $call = $this->determineControllers();
        $call_class = $call['call'];
        $class = ucfirst(array_shift($call_class));
        $method = array_shift($call_class);
        $o = new $class($this->config);
        return $o->$method();
    }
    
    public function determineControllers()
    {
        $path = str_replace($this->serverRedirectBase, '', $this->serverRequestUri);
        $return = array();
        
        foreach($this->config['routes'] as $k => $v) {
            $matches = array();
            $pattern = '$' . $k . '$';
            if(preg_match($pattern, $path, $matches))
            {
                $controller_details = $v;
                $controller_method = explode('/', $controller_details);
                $return = array('call' => $controller_method);
            }
        }
        
        return $return;
    }

}