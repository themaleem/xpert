<?php

    function start_session() {
        $id = session_id();
        if ($id === "") {
            session_start();
        }
    }
    function is_logged_in() {
        start_session();
        
        if(isset($_SESSION['user'])){
            return true;
        }
        return false;
    }

    function redirect_if_not_admin(){
        start_session();

        if(!isset($_SESSION['user'])){
            return;
        } else {
            $role = $_SESSION['role'];
            if ($role === 'admin' ){
               return;
            }
            else {
                return header('location: ../client/index.php');
            }
        }  
    };

    function redirect_if_logged_in(){
        start_session();

        if(!isset($_SESSION['user'])){
            return;
        } else {
            return header('location: ../../index.php'); 
        }  
    };

    function redirect_if_not_client(){
        start_session();

        if(!isset($_SESSION['user'])){
            return;
        } else {
            $role = $_SESSION['role'];
            if ($role === 'Client' ){
               return;
            }
            else {
                return header('location: ../staff/index.php');
            }
        }  
    };

    function is_admin(){
        is_logged_in();
        $role = $_SESSION['role'];

        if ($role === 'admin' || $role === 'sales' )
           return true;
        else if ($role === 'Client')
            return false; 
    }

?>
