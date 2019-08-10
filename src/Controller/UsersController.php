<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;

class UsersController extends AppController
{
    public function login() {
        if($this->request->is('post')){
            $user = $this->Auth->identify();
            if($user){
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }

            $this->Flash->error('Your username or password is incorrect');
        }
    }

    public function registration() {
        if($this->request->is('post')){            
            $pswdHasher = new DefaultPasswordHasher;

            $users_table = TableRegistry::get('users');
            $new_user = $users_table->newEntity();
            $new_user->username = $this->request->data('username');
            $new_user->password = $pswdHasher->hash($this->request->data('password'));
            
            if($users_table->save($new_user))
                $this->Flash->success("Registration successful");
            else
                $this->Flash->error("Your username or password is incorrect");
            
            $this->redirect("/");
        }
    }

    function beforeFilter(Event $event) 
    {
        parent::beforeFilter($event);
        $this->Auth->allow('registration');
    }
}
?>