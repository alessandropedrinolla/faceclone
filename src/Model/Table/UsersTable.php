<?php
    namespace App\Model\Table;
    use Cake\ORM\Table;

    class usersTable extends Table{
        public function initialize(array $config){
            $name = 'users';
            
            $this->setTable('users');
            $this->setPrimaryKey('user_id');

            $this->hasMany('posts');
        }    
    }
?>