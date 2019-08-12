<?php
    namespace App\Model\Table;
    use Cake\ORM\Table;

    class likesTable extends Table{
        public function initialize(array $config){
            $name = 'likes';

            $this->primaryKey(['user_id','post_id']);

            $this->setTable('likes');

            $this->belongsTo('Users')
            ->setForeignKey('user_id')
            ->setClassName('users')
            ->setJoinType('left');

            $this->belongsTo('Posts')
            ->setForeignKey('post_id')
            ->setClassName('posts')
            ->setJoinType('left');
        }
    }
?>