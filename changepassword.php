<?php
require_once 'core/init.php';
$user = new User();
$user->checkCookie();
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
if(Input::exists()){
    if (Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new_repeat' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'password_new'
            )
        ));
        if($validation->passed()){
            if(!Hash::check(Input::get('password'), $user->data()->password)){
                echo 'Your current password is entered incorrectly';
            } else {
                $user->update(array(
                    'password' => Hash::make(Input::get('password_new'))
            ));
                Session::put('success', 'Your password was changed successfully');
                Redirect::to('dashboard.php');
            }

        } else {
            foreach ($validation->errors() as $error){
                echo escape($error), '<br>';
            }
        }
    }
}
?>
<form action="" method="post">
    <div class="field">
        <label for="password">Password</label>
        <br>
        <input type="password" name="password" id="password">
    </div>
    <div class="field">
        <label for="password_new">New password</label>
        <br>
        <input type="password" name="password_new" id="password_new">
    </div>
    <div class="field">
        <label for="password_new_repeat">Repeat new password</label>
        <br>
        <input type="password" name="password_new_repeat" id="password_new_repeat">
    </div>
    <div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <button type="submit" value="register">Change</button>
    </div>
</form>
