<?php
    session_start();
    // if logout, clear session variable and set cookie expired
    if (isset($_GET['login'])){
        $logout = $_GET['login'];
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        session_destroy();
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="signin.png">
    
        <title>Sign in</title>
    
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- Custom styles for this template -->
        <link href="signin.css" rel="stylesheet">
    </head>

    <body class="text-center">
        <form class="form-signin" method="post" action="login.php">
            <img class="mb-4" src="signin.png" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <label class="sr-only">User Name</label>
            <input id="inputEmail" class="form-control" placeholder="User Name" name="username" required autofocus>
            <label class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
            <div class="checkbox mb-3"></div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy Zhepu Zhao; 2017-2018</p>
        </form>
    </body>
</html>

<?php
    try {
        // connect database
        $h = "pearl.ils.unc.edu";
        $u = "webdb_zhepu";
        $d = "webdb_zhepu";
        $p = "ZZP2017@unc";
        $dbh = new PDO("mysql:host=$h;dbname=$d",$u,$p);
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $dbh->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);

        // if
        if ((isset($_POST['username']) && isset($_POST['password']))) {
            
            // set username and password
            $username = $_POST['username'];
            $sha1_pass = sha1($_POST['password']);
            
            // prepare the statements
            $user_query = "select * from UserAccount WHERE UserName = (:username) and Password = (:password)";
            $stmt = $dbh->prepare($user_query);
            $params = array('username'=>$username, 'password'=>$sha1_pass);
            $stmt->execute($params);
            
            $num_rows = $stmt->rowCount();
            if ($num_rows > 0) {
                // data returned and set the session variable
                $_SESSION['valid_user'] = $username;
                // go to results.php
                echo '<script type="text/javascript">location.href = "results.php";</script>';
            } else {
                // no data returned, stay on this site and log in again
                echo '<script type="text/javascript">location.href = "login.php";</script>';
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    
?>