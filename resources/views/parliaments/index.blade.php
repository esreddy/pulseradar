<!-- resources/views/assemblies/index.blade.php -->
@extends('layout')
@section('title','List of Parliaments')
@section('content')
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).off("click", ".edit_assembly").on("click", ".edit_assembly", function() {

        if ($(this).closest(".assembly-name").attr("key") != "") {
            var assemblyId = $(this).closest(".assembly-icons").attr("key");
            $.ajax({
                type: "POST",
                url: "{{ route('getAssemblyInfo') }}",
                data: { "assemblyId": assemblyId },
                dataType: 'json',
                success: function(data) {
                    $('#addAssemblyModal').find(".modal-header").find("h5").text("Edit Assembly");
                    $("#assemblyId").val(data.id);
                    $("#assemblyName").val(data.name);
                    $('#addAssemblyModal').modal('show');
                    //alert("Assembly");
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error('Error fetching assembly data:', error);

                }
            });
        }
    });

    $(document).off("click", "#saveAssemblyChanges").on("click", "#saveAssemblyChanges", function() {
    var assemblyId = $("#assemblyId").val();
    var assemblyName = $("#assemblyName").val();
    $.ajax({
        type: "POST",
        url: "{{ route('updateAssemblyInfo') }}",
        data: {
            "assemblyId": assemblyId,
            "assemblyName": assemblyName,
            "_token": "{{ csrf_token() }}"
        },
        dataType: 'json',
        success: function(response) {
            $('#addAssemblyModal').modal('hide'); // Hide the modal
            // Display success message (you can customize this)
            alert(response.message); // Display the success message
            location.reload(); // Reload the page
        },
        error: function(xhr, status, error) {
            // Handle error if necessary
            console.error(xhr.responseText);
        }
    });
});

</script>


<!-- Add Assembly Modal -->
<div class="modal" id="addAssemblyModal" tabindex="-1" role="dialog" aria-labelledby="addAssemblyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="updateAssemblyForm" action="{{ route('updateAssemblyInfo') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addAssemblyModalLabel">Add Assembly</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="assemblyId" id="assemblyId"/>
                        <label for="assemblyName">Assembly Name:</label>
                        <input type="text" class="form-control" id="assemblyName" name="assemblyName" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" name="saveAssemblyChanges" id="saveAssemblyChanges">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Add Assembly Modal -->




<style>
    /* Custom styles for the assemblies */
    .assembly-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .assembly-box {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
        background-color: #f9f9f9;
        width: 150px;
        flex: 0 0 auto;
    }

    .assembly-name {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .assembly-icons {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Additional styling for the entire page */
    .container {
        margin-top: 20px;
    }

    .parliament {
        border: 1px solid #ccc;
        border-radius: 8px;
        margin-bottom: 20px;
        background-color: #fff;
        padding: 15px;
    }

    .parliament .accordion_head {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .parliament .act_icons {
        display: flex;
        align-items: center;
    }

    .parliament .act_icons a,
    .parliament .act_icons span {
        margin-right: 10px;
        color: #333;
        text-decoration: none;
    }

    .parliament .act_icons a:hover {
        color: #007bff;
    }

    .parliament .del_parlia_assem:hover {
        color: #dc3545;
    }

    .add-assembly-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed #ccc;
        border-radius: 8px;
        width: 100px; /* Adjust the width as needed */
        height: 100px; /* Adjust the height as needed */
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .add-assembly-icon:hover {
        background-color: #f0f0f0;
    }

    .add-assembly-icon i {
        font-size: 36px; /* Adjust the icon size as needed */
        color: #999;
    }
</style>

<div class="container">
    <h1>List of Parliaments</h1>
    <a href="{{ route('parliaments.create') }}" class="btn btn-primary mb-3">Add Parliament</a>

    @if ($parliaments->isEmpty())
        <p>No Parliaments found</p>
    @else
        @foreach ($parliaments as $parliament)
            <div class="parliament parliament_{{ $parliament->id }}" key="{{ $parliament->id }}">
                <div class="accordion_head">{{ $parliament->name }}
                    <span class="act_icons">
                        <a href="{{ route('parliaments.edit', $parliament->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <span class="del_parlia_assem" key="p" del="{{ $parliament->id }}"><i class="fa fa-trash-o delete-parliament" aria-hidden="true"></i></span>
                    </span>
                </div>
                <div class="accordion_body">
                    <div class="assembly-container">
                        @if ($parliament->assemblies->isEmpty())
                            <p>No Assemblies found</p>
                        @else
                            @foreach ($parliament->assemblies as $assembly)
                                <div class="assembly-box">
                                    <div class="assembly-content">
                                        <div class="assembly-name" >{{ $assembly->name }}</div>
                                        <div class="assembly-icons" key="{{ $assembly->id }}">
                                            <a href="{{ route('assemblies.edit', $assembly->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <span class="edit_assembly"><i class="fa fa-pencil" aria-hidden="true"></i></span>
                                            <span class="del_parlia_assem" key="a" del="{{ $assembly->id }}"><i class="fa fa-trash-o delete-assembly" aria-hidden="true"></i></span>
                                            <span title="Mandals" class="madals_list"><i class="fa fa-list" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <a href="#" class="edit-link" data-bs-toggle="modal" data-bs-target="#addAssemblyModal" data-assembly-id="1" data-assembly-name="Assembly 1">
                            Edit Assembly
                        </a>
                        <!-- Anchor tag to trigger the modal -->
                        <div class="add-assembly-icon">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#addAssemblyModal">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </a>
                        </div>


                        <!-- End of Add Assembly Icon -->

                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteParliamentIcons = document.querySelectorAll('.delete-parliament');
        deleteParliamentIcons.forEach(icon => {
            icon.addEventListener('click', function(e) {
                if (confirm('Are you sure you want to delete this parliament?')) {
                    // You can write your delete logic here for the parliament
                    // Example: Make an AJAX request or redirect to a delete route
                    // Use 'this' to access the clicked element, and 'getAttribute' to get the parliament ID
                    const parliamentId = this.getAttribute('del');
                    console.log('Delete Parliament with ID: ', parliamentId);
                    // Perform delete action here...
                }
            });
        });

        const deleteAssemblyIcons = document.querySelectorAll('.delete-assembly');
        deleteAssemblyIcons.forEach(icon => {
            icon.addEventListener('click', function(e) {
                if (confirm('Are you sure you want to delete this assembly?')) {
                    // You can write your delete logic here for the assembly
                    // Example: Make an AJAX request or redirect to a delete route
                    // Use 'this' to access the clicked element, and 'getAttribute' to get the assembly ID
                    const assemblyId = this.getAttribute('del');
                    console.log('Delete Assembly with ID: ', assemblyId);
                    // Perform delete action here...
                }
            });
        });
    });
</script>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#addAssemblyModal').on('show.bs.modal', function (event) {
            // Clear the input field when modal is shown
            $('#assemblyName').val('');
        });
    });
</script>






@endsection


