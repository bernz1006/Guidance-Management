@extends('layouts.app')
@section('content')
    <div class="sardo-container">
      <div class="d-flex justify-content-between mb-5">
        <h3>SARDO - Student at Risk of Dropping-Out</h3>
        <a href="#" id="download_btn" class="btn btn-primary" title="Download SARDO List">Download</a>
      </div>

      <table id="sardoRecords" class="display">
        <thead>
            <tr>
                <th>Grade Level</th>
                <th>No. of Under SARDO</th>
            </tr>
        </thead>
      </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
          $('#sardoRecords').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                method: 'get',
                url: "{{ route('fetch.counselor.sardo') }}",
            },
            columns: [
                {data: 'grade_level', name: 'grade_level'},
                {data: 'sardo', name: 'sardo'},
            ]
        });
      });

      $(document).on('click', '#download_btn',function() {
            Swal.fire({
                title: 'Download',
                text: 'Download Sardo Record?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#rrr',
                cancelButtonColor: '#ddd',
                confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.isConfirmed) {
                    var token = $('meta[name="csrf-token"]').attr('content');
                    var url = `{{ route('admin.sardo.download') }}?&_token=${token}`;
                    window.open(url, '_blank');
                }
            });
        });
    </script>

@endsection
