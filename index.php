<?php
//Autoloader   
function classCharger($addClass){
    require 'class' . '/' . $addClass . '.php';
}
spl_autoload_register('classCharger');

$title = 'Comments form';
$errors = null;
$success = false;
require 'elements/header.php';

//instantiating a class GuestBook
$guestbook = new GuestBook('data/messages.txt');

if(isset($_POST['username'], $_POST['message'])){
    //instantiating a class Message
    $message = new Message($_POST['username'], $_POST['message']);
    //Checking if user infomations are valid
    if($message->isValid()){
        //If Data are valid, user informations will be encoded and append in the json file. 
        $guestbook->addMesssage($message);
        $success = true;
    }else{
        //if !empty(getErrors), an assoc array is returned containing all errors. 
        $errors = $message->getErrors();
    }
}

//PullMessages will stock all users comments (array)
$pullMessages = $guestbook->getMessages();

?>
<div class="container">
    <h2>Comments Form</h2>
    <?php if (!empty($errors)){
    ?>
        <div class="alert alert-danger">
            Invalid form !
        </div>
    <?php    
    }
    if ($success){
    ?>
        <div class="alert alert-success">
            Thanks for your comment ! 
        </div>
    <?php
    }
    ?>
    <form action="" method="post">
        <div class="form-group">
            <input type="text" name="username" placeholder="Enter User Name"  class="form-control<?php if(isset($errors['errorUserName'])){ echo ' is-invalid'; } ;?>">
            <?php
                if(isset($errors['errorUserName'])){
            ?>           
                    <div class="invalid-feedback">
                        <?= $errors['errorUserName'];?>
                    </div>
            <?php        
                }
            ?>    
        </div>
        <div class="form-group">
            <textarea name="message" placeholder="Enter your comment" class="form-control<?php if(isset($errors['errorMessage'])){ echo ' is-invalid'; } ;?>"></textarea>
            <?php
                if(isset($errors['errorMessage'])){
            ?>           
                    <div class="invalid-feedback">
                        <?= $errors['errorMessage'];?>
                    </div>
            <?php        
                }
            ?>    
        </div>
        <button class="btn btn-primary">Send</button>
    </form>
    <h2>Comments :</h2>
    <?php
    //Iteration over pullMessages to display all users comments
    if(!empty($pullMessages)){
        foreach ($pullMessages as $lineMessage) {
            //static function toHTML will return html tags containing all users informations.
            echo Message::toHTML($lineMessage->username, $lineMessage->message, $lineMessage->date);
        }
    }
    ?>
    
</div>
<?php require 'elements/footer.php';?>
