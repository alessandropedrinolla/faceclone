<?php
    $this->set('title','Login');
    
    echo $this->Form->create('User',array(
        'id'=>'login-form'
    ));
    echo $this->Form->input('username');
    echo $this->Form->input('password');
    echo $this->Form->button('Login');
    echo $this->Form->end();

    echo $this->Form->create('Registration',array(
        'id'=>'registration-form',
        'action'=>'registration'
    ));
    echo $this->Form->input('new_username',[
        'label'=>'Username'
    ]);
    echo $this->Form->input('new_password',[
        'label'=>'Password'
    ]);
    echo $this->Form->button('Register');
    echo $this->Form->end();
?>