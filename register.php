<?php
require_once 'core/init.php';
if(Input::exists()){
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'username' => array(
            'name' => 'Vardas',
            'required' => true,
            'min' => 2,
            'max' => 20,
            'unique' => 'users/username'
        ),
        'password' => array(
            'name' => 'slaptazodis',
            'required' => true,
            'min' => 6,
        ),
        'password_repeat' => array(
            'name' => 'pakartokite slaptazodi',
            'required' => true,
            'matches' => 'password'
        ),
        'name' => array(
            'name' => 'vardas pavarde',
            'required' => true,
            'min' => 2,
            'max' => 50
        )
    ));
    if($validation->passed()){
        echo 'submitted';
    } else {
        print_r($validate->errors());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/register.css" type="text/css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
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
                    <label for="password_repeat">Repeat password</label>
                    <br>
                    <input type="password" name="password_repeat" id="password_repeat">
                </div>
                <div class="field">
                    <label for="name">Name</label>
                    <br>
                    <input type="text" name="name" id="name" value="<?php echo escape(Input::get('username')); ?>">
                </div>
                <div>
                    <button type="submit" value="register">Register</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>