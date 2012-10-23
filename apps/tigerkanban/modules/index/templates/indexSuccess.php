<div id="addtask-frm" title="Add New Task">
    <form>
        <fieldset>
            <?php echo $taskform->renderHiddenFields(); ?>
            <?php echo $taskform ?>
        </fieldset>
    </form>
    <p class="validateTips"></p>
</div>

<div id="dialog-signout" title="Signout?">
    Do you really want to signout?
</div>

<div id="toolbar">
    <button id="addtask-btn">Add Task</button>
    <button id="refresh-btn">Refresh</button>
</div>
<div id="main"></div>