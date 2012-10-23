
<h1>TigerKanBan<br><span>Come in and take your tasks</span></h1>

<?php if ($sf_user->isAuthenticated()): ?>

<div id="teamchooser">
    <?php echo $teamform['team_id']->render(); ?>
    <script type="text/javascript">
        $("#team_id").selectmenu();
    </script>
</div>


<div id="profilebar">Signed in as <strong><?php echo $sf_user->getGuardUser()->getUsername(); ?></strong>&nbsp;&nbsp;&nbsp;
    <button id="signout-btn">Signout</button>
</div>
<?php endif; ?>