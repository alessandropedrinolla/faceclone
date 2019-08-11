<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;

class PostsController extends AppController
{
    public function newPost() {
        if($this->request->is('post')){
            $posts = TableRegistry::get('posts');
            $post = $posts->newEntity();
            $post->content = $this->request->data('text');
            $post->user_id = $this->Auth->user('user_id');
            echo var_dump($this->Auth->user());

            $posts->save($post);

            return $this->redirect('/feed');
        }
    }

    public function feed() {
        if($this->request->is('get')){
            $posts = TableRegistry::getTableLocator()->get('Posts');
            $query = $posts->find('all', ['fields'=>['users.username','posts.content']])->contain(['Users']);
            
            $this->set('posts',$query);
        }
    }
}
?>