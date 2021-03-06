<?php
class User{
    private $_db,
            $_data,
            $_sessionName,
            $_isLoggedIn,
            $_cookieName;

    public function __construct($user = null){
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');
        if(!$user){
            if(Session::exist($this->_sessionName)){
                $user = Session::get($this->_sessionName);
                if($this->find($user)){
                    $this->_isLoggedIn = true;
                } else {
                   Redirect::to(404);
                }
            }
        } else {
            $this->find($user);
        }
    }
    public function data(){
        return $this->_data;
    }
    public function create($fields = array()){
        if(!$this->_db->insert('users', $fields)){
            throw new Exception('There was a problem creating the account');
        }
    }
    public function find($user = null){
        if($user){
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));
            if($data->count()){
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }
    public function update($fields = array(), $id = null ){
        if(!$id && $this->_isLoggedIn){
            $id = $this->data()->id;
        }
        if(!$this->_db->update('users',array('id', '=', $id) ,$fields)){
            throw new Exception('There was a problem updating');
        }
    }
    public function login($username = null, $password = null, $remember = false){
        if(!$username && !$password && $this->exists()){
            Session::put($this->_sessionName, $this->data()->id);
            $this->_isLoggedIn = true;
        } else {
            $user = $this->find($username);
            if($user){
                if(password_verify($password, $this->data()->password)){
                    Session::put($this->_sessionName, $this->data()->id);
                    $this->_isLoggedIn = true;
                    if($remember){
                        $hashCheck = $this->_db->get('users_session', array('user_id', "=", $this->data()->id));
                        if(!$hashCheck->count()){
                            $hash = Hash::makeRand();
                            $this->_db->insert('users_session',array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash,
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }
                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }
                    return true;
                }
            }
        }
        return false;
    }
    public function exists(): bool
    {
        return (!empty($this->_data));
    }
    public function checkCookie(){
        if(Cookie::exists($this->_cookieName)){
            $hash = Cookie::get($this->_cookieName);
            $hashCheck = $this->_db->get('users_session', array('hash', '=', $hash));
            if($hashCheck->count()){
                $user_id = $hashCheck->first()->user_id;
                if($this->find($user_id)){
                    $this->login();
                }
                return true;
            }
        }
        return false;
    }
    public function hasPermission($key){
        if($this->exists()){
            $group = $this->_db->get('groups', array('id', '=', $this->data()->group));
            if($group->count()){
                $permissions = json_decode($group->first()->permissions, true);
                if(isset($permissions)){
                    if($permissions[$key]){
                        return true;
                    }
                }
            }
        } else{
            return false;
        }
    }
    public function getType(){
        if($this->exists()){
            $group = $this->_db->get('groups', array('id', '=', $this->data()->group));
            if($group->count()){
                return $group->first()->name;
            }
        }
        return false;
    }
    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }
    public function logout(){
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
        $this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
    }
}