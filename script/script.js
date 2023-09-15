$(document).ready(function () {
    // Function to update the activity list
    function updateActivityList() {
        // Clear the current list
        $('#activity-list').empty();

        // Retrieve and display activities from the database
        $.ajax({
            url: 'get_activities.php',
            method: 'GET',
            success: function (data) {
                data.forEach(function (activity, index) {
                    const formattedStartDateTime = new Date(activity.start_datetime).toLocaleString();
                    const formattedEndDateTime = new Date(activity.end_datetime).toLocaleString();
                    // Add a "Remove" button for each activity
                    $('#activity-list').append(`
                        <li class="list-group-item">
                            ${index + 1}. ${activity.activity_name} (Start: ${formattedStartDateTime}, End: ${formattedEndDateTime})
                            <button class="btn btn-danger btn-sm float-right remove-activity" data-id="${activity.ID}">Remove</button>
                        </li>
                    `);
                });
                // Attach click event handler to "Remove" buttons
                $('.remove-activity').on('click', function () {
                    const activityId = $(this).data('id');
                    removeActivity(activityId);
                });
            },
            error: function () {
                alert('Failed to fetch activities.');
            }
        });
    }

    // Handle form submission
    $('#activity-form').submit(function (event) {
        event.preventDefault();
        const activityName = $('#activity-name').val();
        const activityStartDateTime = $('#activity-start-date').val();
        const activityEndDateTime = $('#activity-end-date').val();

        if (activityName && activityStartDateTime && activityEndDateTime) {
            $.ajax({
                url: 'insert_activity.php',
                method: 'POST',
                data: {
                    'activity-name': activityName,
                    'activity-start-date': activityStartDateTime,
                    'activity-end-date': activityEndDateTime
                },
                success: function () {
                    $('#activity-name').val('');
                    $('#activity-start-date').val('');
                    $('#activity-end-date').val('');
                    updateActivityList();
                },
                error: function () {
                    alert('Failed to add the activity.');
                }
            });
        }
    });

    // Function to remove an activity
    function removeActivity(activityId) {
        $.ajax({
            url: 'remove_activity.php',
            method: 'POST',
            data: { 'activity-id': activityId },
            success: function () {
                updateActivityList();
            },
            error: function () {
                alert('Failed to remove the activity.');
            }
        });
    }

    // Initialize the activity list
    updateActivityList();
});
