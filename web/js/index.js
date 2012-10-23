$(document).ready(function() {

  var taskdata = [];

  function triggerHeartBeat() {
    setTimeout(function() {
      loadAreas();
      triggerHeartBeat();
    }, 300000); //reload after 5Minutes
  }

  function getTooltipOptions() {
    return {
      delay: 0,
      show: {
        duration: 10
      },
      hide: {
        duration: 10
      }
    }
  }

  function signout() {
    $("#dialog-signout").dialog("open");
  }

  function addTask() {
    var tips = $(".validateTips");
    tips.html("Please enter at least a title.");
    $("#task-frm").dialog("open");
    $("select").selectmenu();
  }

  function editTask(task_id) {
    var task = null;
    $.each(taskdata, function(index, mytask) {
      if(mytask.id == task_id) {
        task = mytask;
        return false;
      }
    });
    if(!task) {
      alert("Something went wrong. Sorry!");
    }

    var id = $('#tk_task_id');
    var title = $('#tk_task_title');
    var link = $('#tk_task_link');
    var effort = $('#tk_task_effort');
    var progress = $('#tk_task_progress');
    var user = $('#tk_task_sf_guard_user_id');

    id.val(task.id);
    title.val(task.title);
    link.val(task.link);
    effort.val(task.effort);
    progress.val(task.progress);
    user.val(task.user ? task.user.id : '');

    var tips = $(".validateTips");
    tips.html("Please enter at least a title.");
    $("#task-frm").dialog("open");
    $("select").selectmenu();
    $("select").selectmenu('refresh');

  }

  function moveTask(area_id, task_id, task_pos) {

    if(!area_id.match(/^[0-9]+$/)){

      $('#dialog-archive').dialog("open");
      return;
    }


    $.ajax({
      url: baseurl + 'index/moveTaskJson',
      method: 'POST',
      data: {
        team_id: $('#team_id').val(),
        area_id: area_id,
        task_id: task_id,
        task_pos: task_pos
      },
      success: function() {
        loadAreas();
      },
      error: function() {
        alert("Something went wrong. Sorry!");
      }
    });
  }

  function updateTips(t) {
    $(".validateTips")
      .text(t)
      .addClass("ui-state-highlight");
    setTimeout(function() {
      $(".validateTips").removeClass("ui-state-highlight", 1500);
    }, 500);
  }

  function checkLength(o, n, min, max) {
    if(o.val().length > max || o.val().length < min) {
      o.addClass("ui-state-error");
      updateTips("Length of " + n + " must be between " +
        min + " and " + max + ".");
      return false;
    } else {
      return true;
    }
  }

  function checkRegexp(o, regexp, n) {
    if(!( regexp.test(o.val()) )) {
      o.addClass("ui-state-error");
      updateTips(n);
      return false;
    } else {
      return true;
    }
  }

  function loadAreas() {
    $.ajax({
      url: baseurl + 'index/getAreasJson',
      method: 'POST',
      data: {
        team_id: $('#team_id').val()
      },
      success: function(data, textStatus, jqxhr) {

        $('#main').html("");

        $.each(data, function(index, elem) {
          $('#main').append('<div class="areacol" id="areacol_' + elem.id + '"><div class="areacoltitle">' + elem.name + '</div><ul class="tasklist"></ul></div>');
        });

        $('#main').width(data.length * $('.areacol').first().outerWidth(true));

        loadTasks();


      },
      error: function() {
        alert("Something went wrong. Sorry!");
      }
    });
  }

  function loadTasks() {

    //cleanup
    $('.tasklist').html('');

    $.ajax({
      url: baseurl + 'index/getTasksJson',
      method: 'POST',
      data: {
        team_id: $('#team_id').val(),
        filter: $("#filter-radio :radio:checked").attr('value')
      },
      success: function(data, textStatus, jqxhr) {

        taskdata = data;

        $.each(data, function(index, task) {
          $('#areacol_' + task.area_id + ' ul').append('<li class="ui-state-default" id="task_' + task.id + '">' +
            '<div class="text"><strong>' + task.title + '</strong>' +
            (task.link ? ' <a href="' + task.link + '" target="_blank" title="' + task.link + '">Link</a>' : '') +
            '<span class="user">' +
            (task.username ? '@' + task.username + '' : '@N/A') +
            (task.effort ? ' | ' + task.effort + 'h' : '') +
            (task.progress ? ' | ' + task.progress + '%' : ' | 0%') +
            '</span></div>' +
            '<button>Edit</button>' +
            '</li>');
        });

        $('.tasklist').sortable({
          connectWith: ".tasklist",
          placeholder: "ui-state-highlight",
          stop: function(event, ui) {

            var task = $(ui.item[0]);
            return moveTask(
              task.parent().parent().attr('id').substr(8),
              task.attr('id').substr(5),
              task.index()
            );
          }
        }).disableSelection();

        var height = 0;
        $('.tasklist').each(function() {
          $(this).height('auto');
          var myheight = $(this).height();
          if(myheight > height) {
            height = myheight;
          }
        });
        $('.tasklist').height(height + 60);

        $('.tasklist a, .tasklist button').tooltip(getTooltipOptions());

        $('.tasklist li').dblclick(function(event) {
          editTask($(this).attr('id').substr(5));
        });

        $('.tasklist button').button({
          icons: {
            primary: "ui-icon-pencil"
          },
          text: false
        }).click(function(event) {
            editTask($(this).parent().attr('id').substr(5));
            event.preventDefault();
          });
      }
    });
  }

  $( "#dialog-archive" ).dialog({
    resizable: false,
    height:140,
    modal: true,
    autoOpen: false,
    buttons: {
      "Archive this task": function() {
        $.ajax({
          url: baseurl + 'index/archiveTaskJson',
          method: 'POST',
          data: {
            task_id: $($('#archivetarget ul').children()[0]).attr('id').substr(5)
          },
          success: function(data, textStatus, jqxhr) {
            $('#archivetarget ul li').hide("drop",{},500,function(){
              $('#archivetarget ul').html("");
            });
            $( "#dialog-archive" ).dialog( "close" );
          },
          error: function(){
            alert("Something went wrong. Sorry!");
            $( "#dialog-archive" ).dialog( "close" );
          }
        });
      },
      Cancel: function() {
        loadTasks();
        $( this ).dialog( "close" );
      }
    }
  });

  $("#task-frm").dialog({
    autoOpen: false,
    height: 430,
    width: 500,
    modal: true,
    buttons: {
      "Save": function() {
        var me = this;
        var bValid = true;
        var id = $('#tk_task_id');
        var title = $('#tk_task_title');
        var link = $('#tk_task_link');
        var effort = $('#tk_task_effort');
        var progress = $('#tk_task_progress');
        var user = $('#tk_task_sf_guard_user_id');
        var csrftoken = $('#tk_task__csrf_token');
        var tips = $(".validateTips");

        $('#tk_task_sf_guard_user_id, #tk_task_title, #tk_task_link, #tk_task_effort').removeClass("ui-state-error");


        bValid = bValid && checkLength(title, "title", 3, 255);
        bValid = bValid && checkLength(link, "link", 3, 255);
        bValid = bValid && checkLength(effort, "effort", 1, 5);
        bValid = bValid && checkRegexp(link, /^https?:\/\/.*$/i, "Link must be a valid url.");
        bValid = bValid && checkRegexp(effort, /^[0-9]+\.{0,1}[0-9]*$/i, "Effort must be a float.");
        bValid = bValid && checkRegexp(progress, /^100$|^[0-9]{1,2}$/i, "Progress must be between 0 and 100.");

        if(bValid) {
          $.ajax({
            url: baseurl + 'index/updateTaskJson',
            type: 'POST',
            data: {
              team_id: $('#team_id').val(),
              task: {
                id: id.val(),
                title: title.val(),
                link: link.val(),
                effort: effort.val(),
                progress: progress.val(),
                sf_guard_user_id: user.val()
              }
            },
            success: function() {
              $(me).dialog("close");
              loadAreas();
            },
            error: function() {
              alert("Something went wrong. Sorry!");
              $(me).dialog("close");
            }
          });
        }
      },
      Cancel: function() {
        $(this).dialog("close");
      }
    },
    close: function() {
      $('#tk_task_sf_guard_user_id, #tk_task_title, #tk_task_link, #tk_task_effort, #tk_task_progress').val("").removeClass("ui-state-error");
    }
  });

  $("#dialog-signout").dialog({
    autoOpen: false,
    resizable: false,
    height: 140,
    modal: true,
    buttons: {
      "Signout": function() {
        $('body').addClass("loading");
        $(this).dialog("close");
        document.location.href = baseurl + 'logout';
      },
      Cancel: function() {
        $(this).dialog("close");
      }
    }
  });

  $("#signout-btn").button().click(function(event) {
    signout();
    event.preventDefault();
  });

  $("#loading-overlay").dialog({
    height: 140,
    modal: true
  });

  $("body").on({
    ajaxStart: function() {
      $(this).addClass("loading");
    },
    ajaxStop: function() {
      $(this).removeClass("loading");
    }
  });

  $("input[type=text], input[type=password]").addClass("text ui-widget-content ui-corner-all");


  $("#addtask-btn").button({
    icons: {
      primary: "ui-icon-plusthick"
    },
    text: false
  }).click(function(event) {
      addTask();
      event.preventDefault();
    });

  $("#refresh-btn").button({
    icons: {
      primary: "ui-icon-arrowrefresh-1-s"
    },
    text: false
  }).click(function(event) {
      loadAreas();
      event.preventDefault();
    });

  $('button').tooltip(getTooltipOptions());

  $('#filter-radio').buttonset();

  $("#filter-radio :radio").click(function(){
    loadAreas();
  });

  $('#team_id').selectmenu({
    select: function() {
      loadAreas();
    }
  });


  loadAreas();
  triggerHeartBeat();
});