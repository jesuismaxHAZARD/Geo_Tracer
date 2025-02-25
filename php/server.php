<?php
session_start();

//initializing variables
$username = "";
$name = "";
$email = "";
$pseudo = "";
$errors= array();

//Register User
if(isset($_POST['reg_user']))
{
    //receive all input values from the form
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $pseudo = mysqli_real_escape_string($db, $_POST['pseudo']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    //form validation: ensure that the form is correctly filled
    //by adding(array_push()) corresponding error unto $errors array
    if(empty($username))
    {
        array_push($errors, "Nom d'utilisateur est nécessaire");
    }

    if(empty($name))
    {
        array_push($errors, "Nom d'utilisateur est nécessaire");
    }

    if(empty($email))
    {
        array_push($errors, "Email est nécessaire");
    }

    if(empty($pseudo))
    {
        array_push($errors, "Pseudo est nécessaire");
    }

    if(empty($password))
    {
        array_push($errors, "Mot de passe est nécessaire");
    }

    //First check the database to make sure
    //A suer does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if($user)
    {
        //if user exists
        if($user['username'] === $username)
        {
            array_push($errors, "Username existe déjà");
        }

        if($user['email'] === $email)
        {
            array_push($errors, "Email existe déjà");
        }
    }

    //Finally, register user if there are no errors in the form
    if(count($errors) == 0)
    {
        //encrypt the password before saving in the database
        $password = md5($password);

        $query = "INSERT INTO users(username, email, password)
                  VALUES('$username', '$name', '$email', '$password')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "Vous êtes maintenant connecté";
        header('location: quiz.html');

    }
}