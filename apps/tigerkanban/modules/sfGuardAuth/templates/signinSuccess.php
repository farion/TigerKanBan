<?php use_helper('I18N') ?>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" id="loginbox">
    <h2>Login</h2>

        <?php echo $form->renderGlobalErrors(); ?>
        <?php echo $form->renderHiddenFields(); ?>
        <label for="username">Username</label>
        <?php echo $form['username']->render(array("class" => "text ui-widget-content ui-corner-all")) ?>
        <label for="password">Username</label>
        <?php echo $form['password']->render(array("class" => "text ui-widget-content ui-corner-all")) ?>

        Remember me: <?php echo $form['remember']->render() ?><br><br>

        <input type="submit" value="<?php echo __('Login') ?>">
</form>

<script>
    $('input[type=submit]').button().click(function(){
        $('body').addClass("loading");
    });
</script>
