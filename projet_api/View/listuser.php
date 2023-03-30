<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="View/listuser.css">
</head>

<body>
    <div class="userlist">
        <?php foreach ($users as $user) { ?>
            <div class="user">
                <div class="firstname"><?= $user->firstname; ?></div>
                <div class="lastname"><?= $user->lastname; ?></div>
                <div class="birthday"><?= $user->birthday; ?></div>
            </div>
        <?php } ?>
    </div>
</body>

</html>