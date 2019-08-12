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
            $db = ConnectionManager::get('default');
            $result = $db->execute("
            SELECT users.user_id, users.username, posts.post_id, posts.content, posts.created_at, count(likes.user_id) as likes, SUM(case when likes.user_id =" . $this->Auth->user('user_id') . " then 1 else 0 end) as post_liked 
            FROM posts 
            INNER JOIN users on posts.user_id = users.user_id 
            LEFT JOIN likes on posts.post_id = likes.post_id
            GROUP BY posts.post_id
            ORDER BY posts.post_id DESC");

            $this->set('user',$this->Auth->user());
            $this->set('results',$result);
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

    public function like() {
        $post_id = $this->request->getParam('post_id');
        if($this->request->is('get')){
            $likes = TableRegistry::getTableLocator()->get('Likes');
            $like = $likes->newEntity();
            $like->user_id = $this->Auth->user('user_id');
            $like->post_id = $post_id;

            $likes->save($like);

            return $this->redirect('/feed');
        }
    }

    public function dislike() {
        if($this->request->is('get')){
            $post_id = $this->request->getParam('post_id');

            $likes = TableRegistry::get('Likes');

            $like = $likes->get([$this->Auth->user('user_id'),$post_id]);

            try
            {
                $likes->delete($like);
            }
            catch(Exception $e){}

            return $this->redirect('/feed');
        }
    }
}
?>