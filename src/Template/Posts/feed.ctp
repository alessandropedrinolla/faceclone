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
        echo "<h3>" . $row['users']['username'] . "</h3>";  
        echo "<div>" . $row['posts']['created_at'] . "</div>";
        if($row['users']['user_id']==$user['user_id'])
            echo "<a href='posts/delete/" . $row['posts']['post_id'] . "'>Delete</a>";
        echo "<p>" . $row['posts']['content'] . "</p>";
        echo "<div>";
        echo "<div>";
        echo "<a>Like</a>";
        echo "</div>";
        echo "<div>";
        echo "<a>Share</a>";
        echo "</div>";
        echo "</div>";
    }
?>
</main>