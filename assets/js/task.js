var selected_users = [];
$(document).ready(function() {
  $('body').on('click', '#assignTask', assignTask);
  $('body').on('click', '#assign_task', assign_task);
  $('body').on('change', '#file', upload_file);
  $('body').on('click', '.assign-users', function() {
    selected_users = [];
    $('#users .user').prop('checked', false);
    var task_id = $(this)
      .parent()
      .find('.task_id')
      .val();
    var group_ref =
      $(this)
        .parent()
        .find('.group_ref')
        .val() || 0;
    $('.assign_task').modal();
    $('#task_id').val(task_id);
    $('#group_ref').val(group_ref);
  });
  $('body').on('click', '.assign_task #users .user', function() {
    var user_id = $(this).val();
    var index;
    if ($(this).is(':checked')) {
      selected_users.push(user_id);
    } else {
      index = selected_users.indexOf(user_id);
      if (index > -1) {
        selected_users.splice(index, 1);
      }
    }
    console.log(selected_users);
  });
  $('body').on('click', '#assigned-users .remove-item', function() {
    $(this)
      .closest('.assign_users')
      .remove();
    $('#number-of-assigned-persons').val($('.assign_users').length);
  });
  $('body').on('click', '#assign-users', function() {
    var task_id = $('#task_id').val();
    var group_ref = $('#group_ref').val() || 0;

    $('#assigned-users').html('');
    $('#users .user:checked').each(function() {
      // $('#assigned-users').append('<input type="hidden" name="users[]" value="' + $(this).val() + '">');
      var element = $(
        "<div class='assign_users row'>" +
          "<p class='pull-left'>" +
          $(this)
            .closest('tr')
            .children()
            .eq(1)
            .text() +
          '</p>' +
          "<input type='hidden' name='users[]' value='" +
          $(this).val() +
          "'>" +
          "<input type='hidden' name='user_name[]' value='" +
          $(this)
            .closest('tr')
            .children()
            .eq(1)
            .text() +
          "'>" +
          "<span class='pull-right'><a  class='remove-item'>X</a></span></div>"
      );
      $('#assigned-users').append(element);
    });

    $('#number-of-assigned-persons').val($('#users .user:checked').length);
    $('.assign_task').modal('hide');

    if ((task_id == 0) & (task_id == '')) {
      $.ajax({
        url: base_url + 'task/assign_users',
        data: {
          task_id: task_id,
          group_ref: group_ref,
          users: selected_users
        },
        method: 'POST'
      }).success(function(response) {
        $('#task_details .assigned_persons').html(response);
        $('.assign_task').modal('toggle');
      });
    }
  });

  $('body').on('click', '#assigned-users .remove-item', function() {
    $(this)
      .closest('.assign_users_for_projects')
      .remove();
    $('#number-of-assigned-persons').val(
      $('.assign_users_for_projects').length
    );
  });
  $('body').on('click', '#assign-users', function() {
    var project_id = $('#project_id').val();
    // var group_ref = $('#group_ref').val() || 0;

    $('#assigned-users').html('');
    $('#users .user:checked').each(function() {
      // $('#assigned-users').append('<input type="hidden" name="users[]" value="' + $(this).val() + '">');
      var element = $(
        "<div class='assign_users_for_projects row'>" +
          "<p class='pull-left'>" +
          $(this)
            .closest('tr')
            .children()
            .eq(1)
            .text() +
          '</p>' +
          "<input type='hidden' name='users[]' value='" +
          $(this).val() +
          "'>" +
          "<input type='hidden' name='user_name[]' value='" +
          $(this)
            .closest('tr')
            .children()
            .eq(1)
            .text() +
          "'>" +
          "<span class='pull-right'><a  class='remove-item'>X</a></span></div>"
      );
      $('#assigned-users').append(element);
    });

    $('#number-of-assigned-persons').val($('#users .user:checked').length);
    $('.assign_task').modal('hide');

    if ((project_id == 0) & (project_id == '')) {
      $.ajax({
        url: base_url + 'task/assign_users_for_projects',
        data: {
          project_id: project_id,
          //  'group_ref': group_ref,
          users: selected_users
        },
        method: 'POST'
      }).success(function(response) {
        $('#task_details .assigned_persons').html(response);
        $('.assign_task').modal('toggle');
      });
    }
  });

  $('body').on('click', '#is-done', function() {
    var task_id = $('#task-id').val();
    var group_ref = $('#group-ref').val();
    var is_done = $('#is-done').is(':checked') ? 1 : 0;
    $.ajax({
      url: base_url + 'task/complete_task/',
      data: {
        task_id: task_id,
        group_ref: group_ref,
        is_done: is_done
      },
      dataType: 'json',
      method: 'POST'
    }).success(function(response) {
      $('#task_details .comments').html(response.html);
      $('#comment').val('');
      $('#percentage').prop('selectedIndex', 0);
      if (response.is_done == 1) {
        $('#is-done').prop('checked', true);
      } else {
        $('#is-done').prop('checked', false);
      }
    });
  });
  $('body').on('click', '#submit-comment', function() {
    var task_id = $('.task-id').val();
    var group_ref = $('.group-ref').val();
    var percentage = $('#percentage').val();
    var comment = $('#comment').val();
    var attachment_id = [];
    $('#attachments input').each(function() {
      attachment_id.push($(this).val());
    });

    $.ajax({
      url: base_url + 'task/add_comment/',
      data: {
        task_id: task_id,
        group_ref: group_ref,
        perc_of_completion: percentage,
        comment: comment,
        attachment_id: attachment_id
      },
      dataType: 'json',
      method: 'POST'
    }).success(function(response) {
      $('#task_details .comments').html(response.html);
      $('#comment').val('');
      $('#percentage').prop('selectedIndex', 0);
      if (response.is_done == 1) {
        $('#is-done').prop('checked', true);
        $('#attachments').remove();
      } else {
        $('#is-done').prop('checked', false);
      }
    });
    $('#attachments').html('');
    alert('Successfully Submitted....');
  });
  $('body').on('click', '#approve', function() {
    var task_id = $('.task-id').val();
    var group_ref = $('.group-ref').val();
    var rating = $('#rating').val();

    $.ajax({
      url: base_url + 'task/approve_task_completion/',
      data: {
        task_id: task_id,
        group_ref: group_ref,
        rating: rating
      },
      dataType: 'json',
      method: 'POST'
    }).success(function(response) {
      $('#task_details .comments').html(response.html);
      if (response.is_done == 1) {
        $('#is-done').prop('checked', true);
      } else {
        $('#is-done').prop('checked', false);
      }
    });
  });
  $('body').on('click', '#reject', function() {
    var task_id = $('.task-id').val();
    var group_ref = $('.group-ref').val();
    var rating = $('#rating').val();
    $.ajax({
      url: base_url + 'task/reject_task_completion/',
      data: {
        task_id: task_id,
        group_ref: group_ref,
        rating: rating
      },
      dataType: 'json',
      method: 'POST'
    }).success(function(response) {
      $('#task_details .comments').html(response.html);
      if (response.is_done == 1) {
        $('#is-done').prop('checked', true);
      } else {
        $('#is-done').prop('checked', false);
      }
    });
  });
  $('body').on('click', '.remove-assigned-user', function() {
    var task_id = $(this)
      .closest('.assigned')
      .data('task-id');
    var group_ref = $(this)
      .closest('.assigned')
      .data('group-ref');
    var user_id = $(this)
      .closest('.assigned')
      .data('user-id');
    var remove = $(this).closest('.assigned');
    $.ajax({
      url: base_url + 'task/remove_user',
      data: {
        task_id: task_id,
        group_ref: group_ref,
        assigned_user_id: user_id
      },
      method: 'POST'
    }).success(function(response) {
      $(remove).remove();
    });
  });
  $('body').on('click', '.tasks td:not(":last-child") ', function() {
    var task_id = $(this)
      .closest('tr')
      .find('.task_id')
      .val();
    var group_ref =
      $(this)
        .closest('tr')
        .find('.group_ref')
        .val() || 0;
    $.ajax({
      url: base_url + 'task/get_task_details/' + task_id + '/' + group_ref,
      data: {
        task_id: task_id,
        group_ref: group_ref
      },
      method: 'POST'
    }).success(function(response) {
      $('#task_details .details').html(response);
      $('#task_details').modal();
    });
  });
  $('body').on('click', '#tasks td:not(":last-child") ', function() {
    var task_id = $(this)
      .closest('tr')
      .find('.task_id')
      .val();
    var group_ref =
      $(this)
        .closest('tr')
        .find('.group_ref')
        .val() || 0;
    $.ajax({
      url: base_url + 'task/get_task_details/' + task_id + '/' + group_ref,
      data: {
        task_id: task_id,
        group_ref: group_ref
      },
      method: 'POST'
    }).success(function(response) {
      $('#task_details .details').html(response);
      $('#task_details').modal();
    });
  });

  $('body').on('click', '#task_report td:not(":last-child")', function() {
    var task_id = $(this)
      .closest('tr')
      .find('#task-id')
      .val();
    var group_ref =
      $(this)
        .closest('tr')
        .find('#group-ref')
        .val() || 0;
    //  console.log(task_id);
    $.ajax({
      url: base_url + 'task/get_task_details/' + task_id + '/' + group_ref,
      data: {
        task_id: task_id,
        group_ref: group_ref
      },
      method: 'POST'
    }).success(function(response) {
      $('#task_details .details').html(response);
      $('#task_details').modal();
      //$('#submit-comment').hide();
    });
  });

  $('body').on('click', '#attachments .remove-item', function() {
    $(this)
      .closest('.attachment')
      .remove();
  });
});
function assignTask() {
  var id = $(this)
    .parents('td')
    .find('#task_id')
    .val();
  $.ajax({
    url: base_url + 'task/select_user',
    method: 'POST',
    dataType: 'html',
    data: { id: id }
  }).success(function(response) {
    $('.assign_task .modal-content').html(response);
    $('.assign_task').modal();
    $('#assigned_task_date').datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'yy-mm-dd'
    });
  });
}
function assign_task() {
  var assigned_user_id = $('select[name=selected_user] option:selected').val();
  var assigned_date = $('input[name=date]').val();
  var task_id = $('input[name=task_id]').val();
  $.ajax({
    url: base_url + 'task/assign_task',
    method: 'POST',
    dataType: 'html',
    data: {
      task_id: task_id,
      assigned_user_id: assigned_user_id,
      assigned_date: assigned_date
    }
  }).success(function(response) {
    $('.assign_task').modal('toggle');
  });
}

function upload_file() {
  let data = new FormData();
  data.append('file', this.files[0]);
  $.ajax({
    url: 'fileupload/do_upload/',
    data: data,
    type: 'post',
    dataType: 'json',
    cache: false,
    processData: false,
    contentType: false,
    success: function(response) {
      if (response.status == 'success') {
        var element = $(
          "<div class='attachment row'>" +
            "<p class='pull-left'>" +
            response.file_name +
            '</p>' +
            "<input type='hidden' name='attachment_id[]' value = '" +
            response.id +
            "'/>" +
            "<span class='pull-right'><a  class='remove-item'>X</a></span></div>"
        );
        $('#attachments').append(element);
        // });
      }
    }
  });
}
