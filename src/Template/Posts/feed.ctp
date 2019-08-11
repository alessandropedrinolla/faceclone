<main>
<?php 
    foreach($posts as $post){
        echo "<div>";
        echo "<h3>" . $post['users']['username'] . "</h3>";
        echo "<p>" . $post['posts']['content'] . "</p>";
        echo "</div>";
    }
?>

<?php
    echo $this->Form->create('New-post',array(
        'id'=>'new-post-form',
        'action'=>'newPost'
    ));
    echo $this->Form->input('text');
    echo $this->Form->button('Post');
    echo $this->Form->end();
?>
</main>