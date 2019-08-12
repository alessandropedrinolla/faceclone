<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Auth\BlowFishPasswordHasher;
use Cake\Event\Event;
use Controller\Security;

class UsersController extends AppController
{
    public function login() {
        if($this->request->is('post')){
            $user = $this->Auth->identify();
            var_dump($user);
            if($user){
                $this->Auth->setUser($user);
                return $this->redirect('/feed');
            }

            $this->Flash->error('Your username or password is incorrect');
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function registration() {
        if($this->request->is('post')){
            if($this->request->data('new_username') == "")
            {
                $this->Flash->error("Username cannot be empty");
                $this->redirect("/");
                return;
            }

            if($this->request->data('new_password') == "")
            {
                $this->Flash->error("Password must be at least 8 character long");
                $this->redirect("/");
                return;
            }

            $pswdHasher = new DefaultPasswordHasher;
            $users_table = TableRegistry::get('users');
            $new_user = $users_table->newEntity();
            $new_user->username = $this->request->data('new_username');
            $new_user->password = $pswdHasher->hash($this->request->data('new_password'));
            
            try{
                if($users_table->save($new_user))
                    $this->Flash->success("Registration successful");
                else
                    $this->Flash->error("Your username or password is incorrect");
            }
            catch (\PDOException $e){
                $this->Flash->error($e);
            }
            
            $this->redirect("/");
        }
    }
}
?>