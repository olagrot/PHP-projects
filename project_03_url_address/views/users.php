<?php
include "menu.php";
$users = $example_users;
?>

<p>Users:</p>
<ol>
    <?php foreach ($users as $user_id => $user) { ?>
        <li><a href="user/<?= $user_id ?>"><?= $user['name'] ?></a></li>
    <?php } ?>
</ol>
