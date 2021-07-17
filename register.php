<?php
require_once 'core/init.php';
if(Token::check(Input::get("token"))){
    if (Input::exists()) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'field' => 'Vardas',
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users/username'
            ),
            'password' => array(
                'field' => 'slaptazodis',
                'required' => true,
                'min' => 6,
            ),
            'password_repeat' => array(
                'field' => 'pakartokite slaptazodi',
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'field' => 'vardas pavarde',
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ));
        if ($validation->passed()) {
            $user = new User();
            try {
                $user->create(array(
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password')),
                    'name' => Input::get('username'),
                    'group' => 1
                ));
            } catch(Exception $e){
                die($e->getMessage());
            }
            Session::put('success', 'you registered successfully');
            Redirect::to("login.php");
        } else {
            foreach ($validation->errors() as $error){
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
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    <button type="submit" value="register">Register</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>