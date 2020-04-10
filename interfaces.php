<?php
    interface DBaseInterface{

        //public function __construct();
        public function put($table, array $columns, array $values);
        public function get($table, array $columns, array $conditions, array $values, $limit);
        public function update($table, array $columns, array $values, array $conditions, array $cond_values);
        public function delete();
    }

    interface AuthInterface{

        public function authenticate($user, $password);
        public function register($columns, $values);
        public function login($user, $pass, $page);
        public function reset_password($username, $old, $new);

    }
?>