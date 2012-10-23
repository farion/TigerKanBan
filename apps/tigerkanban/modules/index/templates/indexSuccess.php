<div id="task-frm" title="Add New Task">
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
    &nbsp;&nbsp;&nbsp;&nbsp;Filter:
    <div id="filter-radio">
        <input type="radio" id="filter_all" name="filter-radio" value="all" checked="true" /><label for="filter_all">All</label>
        <input type="radio" id="filter_me" name="filter-radio" value="me"><label for="filter_me">Me</label>
    </div>
</div>
<div id="main"></div>