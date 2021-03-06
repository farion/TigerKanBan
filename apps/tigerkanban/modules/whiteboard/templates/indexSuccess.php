<div id="task-frm" title="Task Form">
    <p class="validateTips"></p>
    <form>
        <fieldset>
            <?php echo $taskform->renderHiddenFields(); ?>
            <?php echo $taskform ?>
        </fieldset>
    </form>
</div>

<div id="task-dialog" title="Task">
    <h2 id="td_title"></h2>
    <input type="hidden" id="td_id">
    <strong>Assigned to:</strong> <span id="td_username"></span><br>
    <strong>Created from:</strong> <span id="td_creator"></span> (<span id="td_created_at"></span>)<br>
    <strong>Effort:</strong> <span id="td_effort"></span><br>
    <strong>Link:</strong> <a href="" id="td_link" target="_blank"></a><br>
    <div id="td_comment" class="comment"></div>
</div>


<div id="dialog-signout" title="Signout?">
    Do you really want to signout?
</div>

<div id="dialog-archive" title="Archive?">
    <p>Do you really want to archive this task? The task will disappear.</p>
</div>


<div id="toolbar">
    <button id="addtask-btn">Add Task</button>
    <button id="refresh-btn">Refresh</button>
    &nbsp;&nbsp;&nbsp;&nbsp;Filter:
    <div id="filter-radio">
        <input type="radio" id="filter_all" name="filter-radio" value="all" checked="true"><label
            for="filter_all">All</label>
        <input type="radio" id="filter_me" name="filter-radio" value="me"><label for="filter_me">Me</label>
    </div>
</div>
<br>
<div id="main"></div>
<div class="clearer"></div>
<div id="archivetarget">Drop tasks here to archive them
    <ul class="tasklist"></ul>
</div>