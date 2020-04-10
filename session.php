<?php

    ini_set('display_errors', 1);

    class Session{

        private static $instance;
        public function __construct(){
          
          if (!isset(self::$instance)){
              session_start();
            self::$instance = $this;
            return self::$instance;
          }else{
                return self::$instance;
          }
        }

        public function session_set($names, $values){
          for($i=0; $i<=sizeof($names)-1; $i++){
              $_SESSION[$names[$i]] = $values[$i];
          }
        }
        public function session_get($value){
          return $_SESSION[$value];
        }
        public function __destruct(){
        }   
    }
?>