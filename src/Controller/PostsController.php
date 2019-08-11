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
            $query = $posts->find('all', [
                'fields'=>['users.user_id','users.username','posts.post_id','posts.created_at','posts.content'],
                'order'=>['posts.created_at'=>'DESC']
            ])
            ->contain(['Users']);
            
            $this->set('user',$this->Auth->user());
            $this->set('results',$query);
        }
    }

    public function delete() {
        $post_id = $this->request->getParam('post_id');
        if($this->request->is('get')){
            $posts = TableRegistry::getTableLocator()->get('Posts');
            $post = $posts->get($post_id);

            if($post->user_id != $this->Auth->user('user_id'))
            {
                $this->Flash->error("You can't delete other users posts");
                return $this->redirect('/feed');
            }

            try
            {
                $this->Posts->delete($post);
            }
            catch(Exception $e){
                $this->Flash->error("Cannot delete post, " . $e);
                return $this->redirect('/feed');
            }
            
            $this->Flash->success('Post deleted');
            return $this->redirect('/feed');
        }
    }
}
?>