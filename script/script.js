$(document).ready(function () {
  // Array to store scheduled activities
  let activities = [];

  // Function to add a new activity
  function addActivity(activityName, activityDateTime) {
      activities.push({ name: activityName, datetime: activityDateTime });
      updateActivityList();
  }

  // Function to update the activity list
  function updateActivityList() {
      // Clear the current list
      $('#activity-list').empty();

      // Sort activities by date and time
      activities.sort((a, b) => new Date(a.datetime) - new Date(b.datetime));

      // Display each activity
      activities.forEach((activity, index) => {
          const formattedDateTime = new Date(activity.datetime).toLocaleString();
          $('#activity-list').append(`<li class="list-group-item">${index + 1}. ${activity.name} (Scheduled for: ${formattedDateTime})</li>`);
      });
  }

  // Handle form submission
  $('#activity-form').submit(function (event) {
      event.preventDefault();
      const activityName = $('#activity-name').val();
      const activityDateTime = $('#activity-date').val();

      if (activityName && activityDateTime) {
          addActivity(activityName, activityDateTime);
          $('#activity-name').val('');
          $('#activity-date').val('');
      }
  });

  // Initialize the activity list
  updateActivityList();
});