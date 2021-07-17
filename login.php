<?php
include_once ('core/init.php');
if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'field' => "Vardas",
                'required' => true,
            ),
            'password' => array(
                'field' => "Slaptazodis",
                'required' => true,
            )
        ));
        if($validation->passed()){
            $user = new User();
            $login = $user->login(Input::get('username'), Input::get('password'));
            if($login) {
                echo 'logged in';
            } else {
                echo 'something went wrong';
            }
        } else {
            foreach($validation->errors() as $error){
                echo $error, '<br>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/login.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <div>
            <form action="" method="post">
                <div class="field">
                    <label for="username">UserName</label>
                    <br>
                    <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>">
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <br>
                    <input type="password" name="password" id="password">
                </div>
                <div class="field">
                    <input type="checkbox" name="remember" id="remember" value="remember">
                    <label for="remember">Remember me</label>
                </div>
                <div>
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    <button type="submit" value="register">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
