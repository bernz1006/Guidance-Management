@extends('layouts.app')
@section('content')
<div class="create-container">
    <div class="d-flex justify-content-between mb-3">
        <h3>List of Modules</h3>
        <a href="#" id="upload_module" class="btn btn-primary" title="Upload Module">Upload</a>
      </div>

      <table id="modules" class="display">
        <thead>
            <tr>
                <th>Module</th>
                <th>Action</th>
            </tr>
        </thead>
      </table>
</div>

<div class="modal fade" id="viewPDF" tabindex="-1" aria-labelledby="viewPDF" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="viewPDF">View Module</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h3 id="file-status-note" class="text-center text-bg-danger"></h3>
            <iframe id="pdf-iframe" src="" width="100%" height="600px"></iframe>
        </div>
        </div>
    </div>
</div>

@include('layouts.loading')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#modules').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                method: 'get',
                url: "{{ route('fetch.counselor.modules') }}",
            },
            columns: [
                {data: 'title', name: 'title'},
                {data: 'action', name: 'action'},
            ]
        });

        $(document).on('click', '#delete_btn', function (){
            var id = $(this).data('id');

            console.log(id)

            Swal.fire({
                title: 'Delete?',
                text: 'You will not be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#ddd',
                confirmButtonText: 'Confirm'
                }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({
                    url: '{{ route("admin.delete.module") }}',
                    type: 'POST',
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response,
                            icon: 'success'
                        }).then(() => {
                            table.ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'There was an error processing your request.';
                        Swal.fire(
                            'Error!',
                            errorMessage,
                            'error'
                        );
                    },
                    complete: function() {
                        hideLoading();
                    }
                    });
                }
            });
        });

        $('#upload_module').on('click', async function() {
            const { value: file } = await Swal.fire({
                title: "Upload Module",
                input: "file",
                inputLabel: "",
                inputPlaceholder: "",
                confirmButtonText: "Upload",
            });

            if (file) {
                const formData = new FormData();
                formData.append('module_pdf', file);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                showLoading();
                $.ajax({
                    url: '{{ route("admin.upload.module") }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success'
                        }).then(() => {
                            table.ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'There was an error processing your request.';
                        Swal.fire(
                            'Error!',
                            errorMessage,
                            'error'
                        );
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            }
        });

        $('#viewPDF').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var pdfFilePath = button.data('pdf');

            if(pdfFilePath == '' || pdfFilePath == null){
                $('#file-status-note').html('No file exist on this item.')
                $('#pdf-iframe').css('height', '10px');
            }else{
                var url = '{{ route("pdf.view", ["filename" => ":pdfFilePath"]) }}';
                url = url.replace(':pdfFilePath', pdfFilePath);
                $('#pdf-iframe').attr('src', url);
            }
        });

        $('#viewPDF').on('hidden.bs.modal', function () {
            $('#pdf-iframe').attr('src', '');
            $('#file-status-note').html('')
            $('#pdf-iframe').css('height', '600px');
        });
    });
</script>
@endsection

