<?php
require_once 'core/init.php';

$user = new User();
$user->checkCookie();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ));
        if($validation->passed()){
            try {
                $user->update(array(
                    'name' => escape(Input::get('name'))
                ));
                Session::put('success', 'Your profile has been updated successfully!');
                Redirect::to('dashboard.php');
            } catch (Exception $e){
                die($e->getMessage());
            }
        } else {
            foreach ($validation->errors() as $error){
                echo $error, '<br>';
            }
        }
    }
}
?>

<form action="" method="post">
    <div class="field">
        <label for="name">Name</label>
        <br>
        <input type="text" name="name" id="name" value="<?php echo escape($user->data()->name); ?>">
    </div>
    <div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <button type="submit" value="register">Update</button>
    </div>
</form>
