$(document).ready(function() {

  var taskdata = [];
  var areadata = [];
  var lanedata = []

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
    $('#tk_task_blocked').val(0);
    $('#tk_task_sf_guard_user_id').val('');
    $("select").selectmenu();
    $("select").selectmenu('refresh');
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
    var comment = $('#tk_task_comment');
    var blocked = $('#tk_task_blocked');
    var link = $('#tk_task_link');
    var effort = $('#tk_task_effort');
    var user = $('#tk_task_sf_guard_user_id');

    id.val(task.id);
    title.val(task.title);
    comment.val(task.comment);
    link.val(task.link);
    effort.val(task.effort);
    blocked.val(task.blocked ? 1 : 0);
    user.val(task.user ? task.user.id : '');

    var tips = $(".validateTips");
    tips.html("Please enter at least a title.");
    $("#task-frm").dialog("open");
    $("select").selectmenu();
    $("select").selectmenu('refresh');

  }

  function moveTask(area_id, lane_id, task_id, task_pos) {

    if(!area_id.match(/^[0-9]+$/)) {

      $('#dialog-archive').dialog("open");
      return;
    }


    $.ajax({
      url: baseurl + 'whiteboard/moveTaskJson',
      method: 'POST',
      data: {
        team_id: $('#team_id').val(),
        area_id: area_id,
        lane_id: lane_id,
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
      url: baseurl + 'whiteboard/getAreasJson',
      method: 'POST',
      data: {
        team_id: $('#team_id').val()
      },
      success: function(data, textStatus, jqxhr) {

        $('#main').html("");

        $('#main').append('<div class="areacol emptycol rowdesc areacol_x"></div>');

        areadata = data.areas;
        lanedata = data.lanes;

        $.each(data.areas, function(index, area) {
          $('#main').append('<div class="areacol coldesc areacol_x' +
            ((area.area_type === "2") ? ' finish_right' : (area.area_type === "1") ? ' finish_left' : '') + '"' +
            ' id="areacol_' + area.id + '">' +
            '<div class="areacoltitle">' +
            '<strong>' + ((area.area_type != "2") ? area.name : '&nbsp;') + '</strong>' +
            ((area.area_type === "2") ? 'Finished' : ((area.area_type === "1") ? 'Started' : '')) +
            (area.wip ? ' WIP: ' + area.wip : '') +
            '</div></div>');
        });

        $.each(data.lanes, function(lindex, lane) {
          $('#main').append('<div class="areacol rowdesc areacol_' + lane.id + '" id="lanecol_' + lane.id + '">' +
            '<div class="areacoltitle"><strong>' + lane.name + '</strong></div></div>');
          $.each(data.areas, function(aindex, area) {
            $('#main').append('<div class="areacol areacol_' + lane.id +
              ((area.area_type === "2") ? ' finish_right' : (area.area_type === "1") ? ' finish_left' : '') +
              '" id="areacol_' + area.id + '_' + lane.id + '">' +
              '<ul class="tasklist"></ul></div>');
          });
        });


        //TODO all
        $('#main').width($('.emptycol').first().outerWidth(true) + ((data.areas.length) * $('.areacol:not(.rowdesc)').first().outerWidth(true)));

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
      url: baseurl + 'whiteboard/getTasksJson',
      method: 'POST',
      data: {
        team_id: $('#team_id').val(),
        filter: $("#filter-radio :radio:checked").attr('value')
      },
      success: function(data, textStatus, jqxhr) {

        taskdata = data;

        $.each(data, function(index, task) {
          $('#areacol_' + task.area_id + '_' + task.lane_id + '  ul').append('<li class="ui-state-default' + (task.blocked ? ' blocked' : '') + '" id="task_' + task.id + '">' +
            '<div class="text"><strong>' + task.title + '</strong>' + (task.comment ? '<br>' + task.comment : '') +
            (task.link ? '<br><a href="' + task.link + '" target="_blank" title="' + task.link + '">Link</a>' : '') +
            '</div>' +
            '<div class="creator">' +
            (task.creatorname ? task.creatorname : '') +
            '</div>' +
            '<div class="user">' +
            (task.username ? '<strong>' + task.username + '</strong>' : '') + (task.effort ? ' | ' + task.effort + 'h' : '') +
            '</div>' +
            '<div class="createddate">' +
            (task.created_at ? task.created_at : '') +
            '</div>' +
            '<div class="readydate">' +
            (task.readydate ? task.readydate : '') +
            '</div>' +
            '</li>');
        });

        $('.tasklist').sortable({
          connectWith: ".tasklist",
          placeholder: "ui-state-highlight",
          stop: function(event, ui) {

            var task = $(ui.item[0]);
            var parentid = task.parent().parent().attr('id');

            return moveTask(
              parentid.substr(8, parentid.lastIndexOf('_') - 8),
              parentid.substr(parentid.lastIndexOf('_') + 1),
              task.attr('id').substr(5),
              task.index()
            );
          }
        }).disableSelection();

        $('#main').height(0);
        $.each($.merge([
          { id: 'x' }
        ], lanedata), function(index, value) {
          var height = 0;
          $('.areacol_' + value.id + ' ul').each(function() {
            $(this).height('auto');
            var myheight = $(this).height();
            if(myheight > height) {
              height = myheight;
            }
          });
          $('.areacol_' + value.id + ' ul').height(height + ((value.id === 'x') ? 0 : 60));

          height = 0;
          $('.areacol_' + value.id).each(function() {
            $(this).height('auto');
            var myheight = $(this).height();
            if(myheight > height) {
              height = myheight;
            }
          });
          $('.areacol_' + value.id).height(height);
          $('#main').height($('#main').height() + $('.areacol_' + value.id).first().outerHeight(true));
        });


        $('.tasklist a, .tasklist button').tooltip(getTooltipOptions());

        $('.tasklist li').dblclick(function(event) {
          editTask($(this).attr('id').substr(5));
        });
      }
    });
  }

  $("#dialog-archive").dialog({
    resizable: false,
    height: 140,
    modal: true,
    autoOpen: false,
    buttons: {
      "Archive this task": function() {
        $.ajax({
          url: baseurl + 'whiteboard/archiveTaskJson',
          method: 'POST',
          data: {
            task_id: $($('#archivetarget ul').children()[0]).attr('id').substr(5)
          },
          success: function(data, textStatus, jqxhr) {
            $('#archivetarget ul li').hide("drop", {}, 500, function() {
              $('#archivetarget ul').html("");
            });
            $("#dialog-archive").dialog("close");
          },
          error: function() {
            alert("Something went wrong. Sorry!");
            $("#dialog-archive").dialog("close");
          }
        });
      },
      Cancel: function() {
        loadTasks();
        $(this).dialog("close");
      }
    }
  });

  $("#task-frm").dialog({
    autoOpen: false,
    height: 530,
    width: 500,
    modal: true,
    buttons: {
      "Save": function() {
        var me = this;
        var bValid = true;
        var id = $('#tk_task_id');
        var title = $('#tk_task_title');
        var comment = $('#tk_task_comment');
        var link = $('#tk_task_link');
        var effort = $('#tk_task_effort');
        var blocked = $('#tk_task_blocked');
        var user = $('#tk_task_sf_guard_user_id');
        var csrftoken = $('#tk_task__csrf_token');
        var tips = $(".validateTips");

        $('#tk_task_sf_guard_user_id, #tk_task_title, #tk_task_link, #tk_task_effort').removeClass("ui-state-error");


        bValid = bValid && checkLength(title, "title", 3, 255);
        bValid = bValid && checkLength(link, "link", 0, 255);
        bValid = bValid && checkLength(effort, "effort", 0, 5);
        bValid = bValid && checkRegexp(link, /^https?:\/\/.*$|^$/i, "Link must be a valid url.");
        bValid = bValid && checkRegexp(effort, /^[0-9]+\.{0,1}[0-9]*$|^$/i, "Effort must be a float.");

        if(bValid) {
          $.ajax({
            url: baseurl + 'whiteboard/updateTaskJson',
            type: 'POST',
            data: {
              team_id: $('#team_id').val(),
              task: {
                id: id.val(),
                title: title.val(),
                comment: comment.val(),
                blocked: blocked.val(),
                link: link.val(),
                effort: effort.val(),
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
      $('#tk_task_sf_guard_user_id, #tk_task_title, #tk_task_link, #tk_task_effort, #tk_task_comment, #tk_task_blocked').val("").removeClass("ui-state-error");
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

  $("input[type=text], input[type=password], textarea").addClass("text ui-widget-content ui-corner-all");


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

  $("#filter-radio :radio").click(function() {
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