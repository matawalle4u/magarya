<?php

    ini_set('display_errors', 1);
    include('interfaces.php');
    
    class Utils{

        private static $instance;
        
        public function __construct(){

            if (!isset(self::$instance)){
                self::$instance = $this;
                return self::$instance;
            }else{
                return self::$instance;
            }
        }

        public function upload($file, $unique_param){

            $uploaddir = 'uploads/';
            $h = date('g');
            $m = date('i');
            $s = date('s');
            $format = date('a');

            $upload_flag=false;

            $date = date('l'). ',' . ' ' .date('F') . ' ' . date('j') . ' ' . date('Y');
            $time = $date.$h.':'.$m.':'.$s.' '.$format;
            $picN = $uploaddir . md5($time.$unique_param) . "." . array_pop(explode("/", $_FILES[$file]['type']));
            if(($_FILES[$file]['type'] == "image/gif" OR $_FILES[$file]['type'] == "image/jpeg" OR $_FILES[$file]['type'] == "image/png") ) {
                if((move_uploaded_file($_FILES[$file]['tmp_name'], $picN) )){
                    $upload_flag =true;
                }
            }
        }

        
        public function __destruct(){
        }
    }
?>