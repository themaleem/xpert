<?php

    function start_session() {
        $id = session_id();
        if ($id === "") {
            session_start();
        }
    }
    function is_logged_in() {
        start_session();
        $user = $_SESSION['user'];

        if(!isset($user)){
            return header('location: login_form.php');
        }
    }

    function redirect_admin_or_user(){
        start_session();

        if(!isset($_SESSION['user'])){
            return;
        } else {
            $role = $_SESSION['role'];
            if ($role === 'admin'|| $role === 'accounts' ){
                return header('location: admin_page.php');
            }
            else {
                return header('location: user_page.php');
            }
        }  
    };

    function is_admin(){
        is_logged_in();
        $role = $_SESSION['role'];
        if ($role === 'admin'|| $role === 'accounts' )
            return;
        else 
            return header('location: user_page.php');
        
    }

?>
