@extends('layout')
@section('title','Surveys List Page')
<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')

<div class="container">
<!-- Dropdown for selecting rows per page -->
<select id="rowsPerPage">
    <option value="10">10</option>
    <option value="25">25</option>
    <option value="50">50</option>
    <option value="100">100</option>
    <!-- Add other options as needed -->
</select>
<p>Total Records: {{ $records->total() }}</p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Area Type</th>
      <th scope="col">Status</th>
      <th scope="col">Created Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
<?php
$statusNames = [
    0 => 'Deleted',
    1 => 'Complete',
    2 => '',
    4 => 'Hide'
];
?>
@php $i = ($records->currentPage() - 1) * $records->perPage() + 1; @endphp
@foreach ($records as $record)

    <tr>
        <th scope="row">{{ $i++ }}</th>
        <td>{{ $record->id }}</td>
        <td>{{ $record->name }}</td>
        <td>{{ $record->areaType }}</td>
        <td>
        @if (array_key_exists($record->status, $statusNames))
                {{ $statusNames[$record->status] }}
            @else
                -
        @endif
        </td>
        <td>{{ $record->createdDate }}</td>
        <td>
        
        @if($record->status == 1)
            <a href="survey/{{ $record->id }}" ><button class="btn btn-primary btn-sm">Completed</button></a>
            <a href="edit_record/{{ $record->id }}" ><button class="btn btn-secondary btn-sm">Edit</button></a>
        @else

            <!-- If status is not 1, disable or hide the buttons -->
            <button id="completedButton" class="btn btn-primary btn-sm" disabled>Completed</button>
            <button id="editButton" class="btn btn-secondary btn-sm" disabled>Edit</button>

        @endif
            <a href="survey-delete/{{ $record->id }}" ><button class="btn btn-danger btn-sm">Delete</button></a>
            <a href="survey/{{ $record->id }}" class="btn btn-sm btn-{{ $record->status == 4 ? 'success' : 'danger'   }}" onclick="return confirmAndUpdate()">
                {{ $record->status == 4 ? 'View' : 'Hide' }}
            </a>

        </td>
    </tr>
@endforeach

  </tbody>
</table>
{{ $records->links('pagination::bootstrap-5') }}
</div>
@endsection

<script>
    function confirmAndUpdate1(recordId) {
        if (confirm('Are you sure you want to update the status?')) {
            // AJAX request to update status
            $.ajax({
                url: '/update_status/' + recordId, // Replace with your Laravel route URL
                type: 'POST', // Use the appropriate HTTP method (PUT, POST, etc.)
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                success: function(response) {
                    alert(response);
                    // Handle success response if needed
                    console.log('Status updated successfully');
                },
                error: function(xhr, status, error) {
                    // Handle error if the request fails
                    console.error(error);
                }
            });
        }
    }

</script>



<script>
    function confirmAndUpdate() {
        return confirm('Are you sure you want to proceed?'); // Display confirmation dialog
    }
</script>
