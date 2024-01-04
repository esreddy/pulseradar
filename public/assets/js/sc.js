// custom.js file content
$(document).ready(function() {
    $('#states').change(function() {
        var stateId = $(this).val();
        // AJAX call to fetch constituencies based on the selected state
        $.ajax({
            url: '/get-constituencies/' + stateId,
            type: 'GET',
            success: function(data) {
                // Clear existing options
                $('#constituencies').empty();

                // Add an initial "Select Constituency" option
                $('#constituencies').append('<option value="">Select Constituency</option>');

                // Add fetched constituencies as options
                $.each(data, function(index, constituency) {
                    $('#constituencies').append('<option value="' + constituency.id + '">' + constituency.name + '</option>');
                });

            },
            error: function(xhr, status, error) {
                console.error(error); // Check the console for any error messages
            }
        });
    });
});
