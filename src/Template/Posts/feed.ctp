<?php $this->set('title','Feed'); ?>
<main>
    <div class='right'><a href="logout">Logout</a></div>
<?php
    
    echo $this->Form->create('New-post',array(
        'id'=>'new-post-form',
        'action'=>'newPost'
    ));
    echo $this->Form->input('text');
    echo $this->Form->button('Post');
    echo $this->Form->end();

    foreach($results as $row){
        echo "<div>";
        echo "<h3>" . $row['username'] . "</h3>";  
        echo "<div>" . $row['created_at'] . "</div>";
        if($row['user_id']==$user['user_id'])
            echo "<a href='posts/delete/" . $row['post_id'] . "'>Delete</a>";
        echo "<p>" . $row['content'] . "</p>";
        echo "<div>";
        echo "<div>";
        if($row['post_liked']==0)
            echo "Likes: " . $row['likes'] . " <a href='posts/like/" . $row['post_id'] . "'>Like</a>";
        else
            echo "Likes: " . $row['likes'] . " <a href='posts/dislike/" . $row['post_id'] . "'>Dislike</a>";
        echo "</div>";
        echo "<div>";        
        echo "<a>Share</a>";
        echo "</div>";
        echo "</div>";
    }
?>
</main>