<?php

    ini_set('display_errors', 1);
    include_once 'dbase.php';
    class Auth extends Dbase implements AuthInterface{

        private static $instance;
        
        public $__auth_table;
        public $__auth_column;
        
        
        public function __construct($table, $column){
            
            Dbase::__construct('localhost', 'root', '', 'followup');
            
            $this->__auth_table = $table;
            $this->__auth_column = $column;
            
            if (!isset(self::$instance)){

                self::$instance = $this;
                return self::$instance;
            
            }else{
                return self::$instance;
            }
        }

        public function authenticate($user, $password){
            $auth_flag = false;
            $result = $this->get($this->__auth_table, [$this->__auth_column], [$this->__auth_column, 'password'],[$user, $password], 'single');
            if($result){
                $auth_flag = true;
            }
            return $auth_flag;
        }


        public function login($user, $pass, $page){
            if($this->authenticate($user, md5("'{$pass}'"))){
                $this->session->session_set([$this->__auth_column],[$user]);
                $this->redirect($page); 
            }else{
                $this->redirect('login.php');
            }
        }

        
        public function register($columns, $values){
            $ct=0;
            foreach($columns as $colum){
                if($colum=='password'){
                    $enc = md5($values[$ct]);
                    $values[$ct]="'{$enc}'";
                }
            $ct+=1;
            }
            $reg = $this->put($this->__auth_table, $columns, $values);
            return $reg;
        }

        public function reset_password($username, $old, $new){
            $reset_flag = false;
            $old = md5("'{$old}'");
            $new = md5("'{$new}'");
            if($this->authenticate($username, $old)==true){
                $reset_flag = true;
                $this->update($this->__auth_table, ['password'],[$new],[$this->__auth_column,'password'],[$username, $old]);
            }
            return $reset_flag; 
        }

        private function redirect($page){

            echo"
                <script type='text/javascript'>
                window.location.href='$page';
                </script>
            ";
        }

        public function logout($page){
            session_destroy();
            $this->redirect($page);
            
        }

          public function __destruct(){
            
          }   
}
?>