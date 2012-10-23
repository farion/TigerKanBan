$(document).ready(function() {

  function triggerHeartBeat() {
    setTimeout(function() {
      loadTasks();
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
    $("#addtask-frm").dialog("open");
    $("select").selectmenu();
  }

  function moveTask(area_id, task_id, task_pos) {
    $.ajax({
      url: baseurl + 'index/moveTaskJson',
      method: 'POST',
      data: {
        area_id: area_id,
        task_id: task_id,
        task_pos: task_pos
      },
      success: function() {
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
      success: function(data, textStatus, jqxhr) {
        $.each(data, function(index, task) {
          $('#areacol_' + task.area_id + ' ul').append('<li class="ui-state-default" id="task_' + task.id + '">' +
            '<div class="text">' + task.title +
            (task.link ? ' <a href="' + task.link + '" target="_blank" title="' + task.link + '">Link</a>' : '') +
            (task.username ? '<span class="user">Assigned to: <strong>' + task.username + '</strong></span>' : '') +
            '</div>' +
            '<button>Edit</button>' +
            '</li>');
        });

        $('.tasklist').sortable({
          connectWith: ".tasklist",
          stop: function(event, ui) {
            var task = $(ui.item[0]);
            moveTask(
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

        $('.tasklist button').button({
          icons: {
            primary: "ui-icon-pencil"
          },
          text: false
        }).click(function(event) {
            alert("not implemented yet");
            event.preventDefault();
          });
      }
    });
  }

  $("#addtask-frm").dialog({
    autoOpen: false,
    height: 370,
    width: 500,
    modal: true,
    buttons: {
      "Add Task": function() {
        var me = this;
        var bValid = true;
        var title = $('#tk_task_title');
        var link = $('#tk_task_link');
        var effort = $('#tk_task_effort');
        var user = $('#tk_task_sf_guard_user_id');
        var csrftoken = $('#tk_task__csrf_token');
        var tips = $(".validateTips");

        $('#tk_task_sf_guard_user_id, #tk_task_title, #tk_task_link, #tk_task_effort').removeClass("ui-state-error");

        //TODO

        /*
         bValid = bValid && checkLength(name, "username", 3, 16);
         bValid = bValid && checkLength(email, "email", 6, 80);
         bValid = bValid && checkLength(password, "password", 5, 16);

         bValid = bValid && checkRegexp(name, /^[a-z]([0-9a-z_])+$/i, "Username may consist of a-z, 0-9, underscores, begin with a letter.");
         // From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
         bValid = bValid && checkRegexp(email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. ui@jquery.com");
         bValid = bValid && checkRegexp(password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9");
         */
        if(bValid) {

          $.ajax({
            url: baseurl + 'index/addTaskJson',
            type: 'POST',
            data: {
              task: {
                _csrf_token: csrftoken.val(),
                title: title.val(),
                link: link.val(),
                effort: effort.val(),
                sf_guard_user_id: user.val()
              }
            },
            success: function() {
              loadTasks();
              $(me).dialog("close");
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
      $('#tk_task_sf_guard_user_id, #tk_task_title, #tk_task_link, #tk_task_effort').val("").removeClass("ui-state-error");
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

  $.ajax({
    url: baseurl + 'index/getAreasJson',
    success: function(data, textStatus, jqxhr) {

      $.each(data, function(index, elem) {
        $('#main').append('<div class="areacol" id="areacol_' + elem.id + '"><div class="areacoltitle">' + elem.name + '</div><ul class="tasklist"></ul></div>');
      });

      $('#main').width(data.length * $('.areacol').first().outerWidth(true));

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
          loadTasks();
          event.preventDefault();
        });

      $('button').tooltip(getTooltipOptions());

      loadTasks();
      triggerHeartBeat();
    },
    error: function() {
      alert("Something went wrong. Sorry!");
    }
  });
});