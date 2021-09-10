<?php

    declare(strict_types=1);
    namespace App;

    class Router
    {
        private array $handlers;
        private $notFoundHandler;
        

        public function get(string $path, $handler):void
        {
            $this->addHandler('GET', $path, $handler);   
        }

        public function post(string $path, $handler):void
        {
            $this->addHandler('POST', $path, $handler);  
        }

        private function addHandler(string $method, string $path, $handler): void {

            $this->handlers[$method.$path] = [

                'path'=>$path,
                'method'=>$method,
                'handler'=>$handler
            ];
        }

        public function addNotFoundHandler($handler): void
        {
            $this->notFoundHandler = $handler; 
        }

        public function run()
        {
            $requestedURL = parse_url($_SERVER['REQUEST_URI']);
            $reqPath = $requestedURL['path'];
            $reqMethod = $_SERVER['REQUEST_METHOD'];

            $callback=null;
            foreach($this->handlers as $handler)
            {
                if($handler['path'] === $reqPath && $reqMethod === $handler['method'])
                {
                    $callback = $handler['handler'];
                }
            }

            //var_dump($reqPath);

            if(!$callback){
                
                header("HTTP/1.0 404 Not Found ");
                if(!empty($this->notFoundHandler))
                {
                    $callback = $this->notFoundHandler;
                }
                
            }

            call_user_func_array($callback, [
                array_merge($_GET, $_POST)
            ]);


        }
    }

?>