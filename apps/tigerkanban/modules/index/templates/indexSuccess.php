<div id="addtask-frm" title="Add New Task">
    <form>
        <fieldset>
            <?php echo $taskform->renderHiddenFields(); ?>
            <?php echo $taskform ?>
        </fieldset>
    </form>
    <p class="validateTips"></p>
</div>


<h1>TigerKanBan</h1>
<div id="toolbar"><button id="addtask-btn">Add Task</button></div>
<div id="main"></div>