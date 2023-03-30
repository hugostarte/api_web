<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="View/stylelist.css">
</head>

<body>
    <div class="postlist">
        <?php foreach ($posts as $post) { ?>
            <div class="user">
                <div class="firstname"><?= $post->firstname; ?></div>
                <div class="lastname"><?= $post->lastname; ?></div>
                <div class="date"><?= $post->postdate; ?></div>
                <div class="content"><?= $post->content; ?></div>    
            </div>
        <?php } ?>
    </div>
    <!-- Affichage des commentaires du post-->
    <div class="postlist">
        <?php foreach ($comments as $comment) { ?>
            <div class="user">
                <div class="firstname"><?= $comment->firstname; ?></div>
                <div class="lastname"><?= $comment->lastname; ?></div>
                <div class="date"><?= $comment->postdate; ?></div>
                <div class="content"><?= $comment->content; ?></div>    
            </div>
        <?php } ?>
    </div>
</body>
