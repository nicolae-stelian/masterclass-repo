<?php


class MasterController {
    
    private $config;
    private $serverRedirectBase;
    private $serverRequestUri;
    
    public function __construct($config, $requestUri = '', $redirectBase = '') {
        $this->_setupConfig($config);
        $this->serverRequestUri = $_SERVER['REQUEST_URI'];
        $this->serverRedirectBase = $_SERVER['REDIRECT_BASE'];

        if (!empty($requestUri)) {
            $this->serverRequestUri = $requestUri;
            $this->serverRedirectBase = $redirectBase;
        }

    }
    
    public function execute() {
        $call = $this->_determineControllers();
        $call_class = $call['call'];
        $class = ucfirst(array_shift($call_class));
        $method = array_shift($call_class);
        $o = new $class($this->config);
        return $o->$method();
    }
    
    public function _determineControllers()
    {
        if (isset($this->serverRedirectBase)) {
            $rb = $this->serverRedirectBase;
        } else {
            $rb = '';
        }


        $ruri = $this->serverRequestUri;
        $path = str_replace($rb, '', $ruri);
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
    
    private function _setupConfig($config) {
        $this->config = $config;
    }
    
}