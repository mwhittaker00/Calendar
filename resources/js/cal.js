$(document).ready(function() {
  $('#calendar').fullCalendar({
    header: {
      left: ' title',
      right: 'prev,next month,agendaWeek,agendaDay today'
    },
    selectable: true,
    selectHelper: true,
    editable: true,
    eventLimit: true, // allow "more" link when too many events

    // SOURCE of events that populate calendar
    events: '/process/getcalendar.php',

    select: function(start, end) {
      $('#calendar-update')[0].reset();
      $('#event-start-date').val(start.format('MM/DD/YYYY'));
      end.subtract(1, 'days');
      $('#event-end-date').val(end.format('MM/DD/YYYY'));
        $('#events-toggle').trigger('click');
				$('#calendar').fullCalendar('unselect');
		},

    eventDrop : function(event, revertFunc){
      updateCalendarEvent(event, revertFunc);
    },

    eventResize : function(event, revertFunc){
      updateCalendarEvent(event, revertFunc);
    },

    // What happens when a day cell is clicked (not an event)
    dayClick: function(date,events){
      $('#calendar-update')[0].reset();
      var clickedDate = date.format('MM/DD/YYYY');
      $('#event-start-date').val(clickedDate);

    },

    // When an event div is clicked, get details and prefill form
    eventClick: function(events){
      var clickedDate = events.start.format("MM/DD/YYYY");
      $('#event-start-date').val(clickedDate);
      $('#event-title').val(events.title);
      $('#event-start-time').val(events.start.format("h:mm A"))
      if ( events.end ){
        $('#event-end-time').val(events.end.format("h:mm A"));
        $('#event-end-date').val(events.end.format("MM/DD/YYYY"));
      }
      else{
        $('#event-end-time').val('');
      }
      if ( events.end ){
        var eventEnd = events.end._i;
      }

    }
  });

  $('.fc-button').addClass('menu-btn');

  //bootstrap datepicker
  $('#events .input-group.date').datepicker({
  });

  // Generate timepicker
  $('.event-time').timepicker({
    showSeconds: false,
    showInputs: true
  });

  // Generates file upload preview
  $('.fileinput').fileinput();
  $('.avatarfile').fileinput();

  // When event start/end is clicked, uncheck 'all day event' box
  $('.event-time').on('click', function(){
    $('#event-all-day').attr('checked',false);
  });

  // Processing the main event form via ajax
  //
  $('#calendar-update').submit(function(e){
    var newTitle = $('#event-title').val();
    var newStartDate = $('#event-start-date').val();
    var newEndDate = $('#event-end-date').val();
    var newStartTime = $('#event-start-time').val();
    var newEndTime = $('#event-end-time').val();
    var fullStartTime = inputToTimestamp(newStartDate, newStartTime);
    var fullEndTime = '';
    if (newEndDate.length == 0 ){
      newEndDate = newStartDate;
    }
    fullEndTime = inputToTimestamp(newEndDate, newEndTime);

    var allDayEvent;
    if ( $('#event-all-day').prop('checked') == true ){
      allDayEvent = 1;
    } else{
      allDayEvent = 0;
    }

    var eventLocation = $('#event-location').val();
    var eventDepartment = $('#event-department').val();
    var eventDescription = $('#event-desc').val();
    //var eventImage = $('#event-picture').val();
    var eventImage = $('#event-picture').val();
    /* AJAX POST TO PROCESSING SCRIPT */

    /* Render new event to calendar view */

    var newEvent = {
          title: newTitle,
          start: fullStartTime,
          end: fullEndTime,
          allDay : allDayEvent,
          location: eventLocation,
          department: eventDepartment,
          description: eventDescription
        };
    $('#calendar').fullCalendar( 'renderEvent', newEvent, 'stick');

    $.post('/process/submitevent.php', {
      title: newTitle,
      start: fullStartTime,
      end: fullEndTime,
      allDay : allDayEvent,
      location: eventLocation,
      department: eventDepartment,
      description: eventDescription
    },
      function(data){
        if (data){
          $('#calendar-update')[0].reset();
        }
        else{}
    });

    e.preventDefault();
  });

// SUBMIT the ADD USER form via ajax
//
  $('#add-user-form').submit(function(e){
    var email = $('#add-user-email').val();
    var fname = $('#add-user-fname').val();
    var lname = $('#add-user-lname').val();
    var department = $('#add-user-department').val();
    var deptText = $('#add-user-department option:selected').text();
    var role = $('#add-user-role').val();
    var roleText = $('#add-user-role option:selected').text();
    var submit = $('#add-user-submit').val();

    var userData = {
      email: email,
      fname: fname,
      lname: lname,
      department: department,
      deptText: deptText,
      role: role,
      roleText: roleText,
      submit: submit
    };

    $.ajax({
      url: '/process/adduser.php',
      type: 'POST',
      data: userData,
      success: function(response){
        $('#add-user-form')[0].reset();
        $('#users-message').html("New user added.");
        $('#users-list').append(response);
      },
      error: function(){
        $('#users-message').html(response);
      }
    });

    e.preventDefault();
  });

// SUBMIT the ADD DEPARTMENT form via ajax
//
  $('#add-dept-form').submit(function(e){

    $.ajax({
      url: '/process/adddepartment.php',
      type: 'POST',
      data: $(this).serialize(),
      success: function(response){
        console.log(response);
        $('#add-dept-form')[0].reset();
        $('#dept-message').html("<br />New department added.");
        $('#add-user-department').append(response);
      },
      error: function(){
        $('#dept-message').html(response);
      }
    });

    e.preventDefault();
  });

// SUBMIT the ADD USER form via ajax
//
  $('#add-location-form').submit(function(e){

    $.ajax({
      url: '/process/addlocation.php',
      type: 'POST',
      data: $(this).serialize(),
      success: function(response){
        console.log(response);
        $('#add-location-form')[0].reset();
        $('#loc-message').html("<br />New location added.");
        $('#loc-list').append(response);
      },
      error: function(){
        $('#loc-message').html(response);
      }
    });

    e.preventDefault();
  });

  // Convert time from form to DB friendly timestamp format
  //
  function inputToTimestamp(formDate, formTime){
    var newDate = new Date(formDate).toISOString();
    var newTime = formTime;
    var amPM = newTime.slice(-2);
    var newMinutes = newTime.slice(-5,-3);
    var newHour = parseInt(newTime.slice(-8,-6));

    if ( amPM == "PM" && newHour != 12 ){
      newHour += 12;
    }
    else if ( amPM == "AM" && newHour != 12 ){
      newHour = "0"+newHour;
    }
    else if ( amPM == "AM" && newHour == 12 ){
      newHour = "00";
    }
    var fullTime = newDate.slice(-24,-13)+newHour+":"+newMinutes+":00";
    return fullTime;
  }

  // Update's event based on drag, drop, or resize
  // Takes FullCalendar's event and revertFunc objects
  //
  function updateCalendarEvent(event, revertFunc){
    var end = (event.end == null) ? start : event.end.format();
    var start = event.start.format();
    $.post('/process/updateevent.php', {
      id: event.id,
      title: event.title,
      start: start,
      end: end,
      allDay : event.allDay,
      location: event.location,
      department: event.department,
      description: event.description
    },
      function(data){
        if (data == 'success'){
        }
        else{
          revertFunc();
        }
    });
  }
});
