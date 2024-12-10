<?php 

require 'config.php';

$username = $password = "";
$error = [];

if ( isset($_POST['login']) ) {
    if ( isset($_POST['username']) && !empty($_POST['username']) ) {
        $username = $conn->real_escape_string($_POST['username']);
    }

    if ( isset($_POST['password']) && !empty($_POST['password']) ) {
        $password = md5($_POST['password']);
    }

    if ( !empty($username) && !empty($password) ) {
        $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ( isset($row['ID'], $row['username'], $row['password']) ) {
                setcookie('id_of_website', $row['username'], strtotime("+1 year")); 
                setcookie('key_of_website', $row['password'], strtotime("+1 year")); 
            
                header("Location: dashboard/index.php");
                exit();
            }
        } else {
            $error[] = 'Invalid username or password given';
        }
    } else {
        $error[] = 'Enter your username & password';
    }
}

?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flat management system</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>
    <body class="bg-light">
        <div class="container">
            <main>
                <h1 class="text-center">Login</h1>
                
                <?php if( is_array($error) && !empty($error) ) {
                    foreach($error as $err) {
                        echo '<div class="alert alert-danger" role="alert">' . $err . '</div>';
                    }
                } ?>
                <form action="" method="POST" class="row g-3">
                    <h4>Welcome Back</h4>
                    <div class="col-12">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>">
                    </div>
                    <div class="col-12">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="col-12">
                        <button type="submit" name="login" class="btn btn-dark float-end">Login</button>
                    </div>
                    <script>if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href ); }</script>
                </form>
            </main>
        </div>
    </body>
</html>
