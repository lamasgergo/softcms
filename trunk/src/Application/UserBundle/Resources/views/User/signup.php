<?php $view->extend('HelloBundle::layout.php') ?>

<form action="#" method="post">
    <?php echo $view['form']->render($form) ?>

    <input type="submit" value="Send!" />
</form>