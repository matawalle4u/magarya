<?php

    ini_set('display_errors', 1);
    include('interfaces.php');
    include_once 'session.php';
    
    class Dbase implements DBaseInterface{

        private static $instance;
        public $sql;
        public $session;
        
	public $host;
	public $user;
	public $password;
		
        public function __construct($host, $user, $password){

            $this->sql = new mysqli($host, $user, $password);
            $this->session = new Session();
			
	    $this->host = $host;
	    $this->user = $user;
            $this->password = $password;
            
            if (!isset(self::$instance)){
                self::$instance = $this;
                return self::$instance;
            }else{
                return self::$instance;
            }
        }

        private function create_delete($operation, $name){
            $execute = $this->sql->query("$operation DATABASE $name");
            if($execute){
                return true;
            }else{
                return false;
            }
        }

        public function create_db($name){
            $newname = "`{$name}`";
	    $created = $this->create_delete('CREATE', $newname);
            if($created){
		$this->sql = new mysqli($this->host, $this->user, $this->password, $name);
		$this->sql->select_db($name);
		return $created;
	    }else{
		return false;
	    }
        }
		
	public function get_current_db(){
	    $result = $this->sql->query("SELECT DATABASE()");
	    if($result){
	        $row = $result->fetch_row();
	        $name= $row[0];
		$result->close();
		return $name;
	    }else{
		return false;
	    }
	}
		
	public function change_active_db($name){
	    $this->sql->select_db($name);
	}

        public function delete_db($name){
            $name = "`{$name}`";
            $deleted = $this->create_delete('DROP', $name);
            return $deleted;
        }


        public function create_table($name, array $columns, array $types, array $numbers){
            
           //$this->sql->query(" CREATE TABLE `{$name}' ('woo' int(11) NOT NULL )ENGINE=InnoDB DEFAULT CHARSET=latin1; ");
        }


        public function put($table, array $columns, array $values){
            //"'{$name}'"

            $put_flag = false;
            $cols = implode(',', $columns);
            $vals = implode(',', $values);

            $result = $this->sql->query("INSERT INTO $table ($cols) VALUES ($vals)");

            if($result==true){
                $put_flag = true;
            }

            return $put_flag;
        }
        
        public function get($table, array $columns, array $conditions, array $values, $limit){
            $all_ent = array();
            $cols = implode(',', $columns);
            $cond =$this->construct_query_conditions($conditions, $values);

            if($limit !='many'){
                $cond.=' LIMIT 1';
            }

            //echo"<h1>".$this->host."</h1>";
            
            $result = $this->sql->query("SELECT  $cols FROM $table $cond");
            while($row=$result->fetch_array()){
                $group = array();
                for($i=0; $i<=sizeof($columns)-1; $i++){
                    $group[$columns[$i]] = $row[$columns[$i]];
                }
                array_push($all_ent, $group);
            }
            return $all_ent;
            // $ent = $this->db->get('admin', ['name','contact'], ['gender'],['Male'], 'many');
            //translates to " select name,contact from admin where gender='Male' "
            // foreach($ent as $e){
            //     echo $e['name']."<br />";
            // }
        }

        public function update($table, array $columns, array $values, array $conditions, array $cond_values){
            
            $ct2=0;
            $cond =$this->construct_query_conditions($conditions, $cond_values);
            $coll='';
            foreach($columns as $col){
                if($ct2==sizeof($columns)-1){
                    $coll.=' '.$col.'='."'$values[$ct2]' ";
               }else{
               $coll.=' '.$col.'='."'$values[$ct2]',";
               }
                $ct2+=1;
            }
            $this->sql->query("UPDATE $table SET $coll $cond");
            // $db->update('conducts', ['owner','session'], ['Adam', '15/09/2020'], ['session'],['corona season']);
            // Translates to "UPDATE conducts SET owner='Adam', session='15/09/2020' WHERE session='corona season' "
        }
        public function delete(){

        }

        public function file_upload(){
            $uploaddir = 'uploads/';
        }

        private function construct_query_conditions(array $conditions, array $values){
            $query_cond ='';
            $counter=0;
            foreach($conditions as $co){
                if($counter==0){
                    $query_cond.='WHERE '.$co.'='."'$values[$counter]'";
                }else{
                    $query_cond.=' AND '.$co.'='."'$values[$counter]'";
                }
                $counter+=1;
            }
            return $query_cond;
        }

        public function __destruct(){
            $this->sql->close();
        }
    }
?>
