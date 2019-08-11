<?php
    namespace App\Model\Table;
    use Cake\ORM\Table;

    class postsTable extends Table{
        public function initialize(array $config){
            $name = 'posts';

            $this->setTable('posts');
            $this->setPrimaryKey('post_id');

            $this->belongsTo('Users')
            ->setForeignKey('user_id')
            ->setClassName('users')
            ->setJoinType('left');
        }
    }
?>