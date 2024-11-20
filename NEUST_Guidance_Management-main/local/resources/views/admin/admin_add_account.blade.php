@extends('layouts.app')
@section('content')

<div class="student-list-container shadow-lg">
      <div class="mb-3 d-flex justify-content-between">
        <h3>Counselor Information</h3>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_modal">Add Counselor</button>
      </div>

      <table id="counselorList" class="display">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
      </table>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="add_modal" tabindex="-1" aria-labelledby="add_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="add_modalLabel">Add Counselor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.counselor.add') }}">
                    @csrf
                    <div class="col-md-6">
                        <label for="add_firstname" class="form-label">First Name</label>
                        <input type="text" id="add_firstname" class="form-control" name="add_firstname" placeholder="(Enter credentials)" required>
                    </div>
                    <div class="col-md-6">
                        <label for="add_surname" class="form-label">Last Name</label>
                        <input type="text" id="add_surname" class="form-control" name="add_surname" placeholder="(Enter credentials)" required>
                    </div>
                    <div class="col-md-6">
                        <label for="add_email" class="form-label">Email</label>
                        <input type="email" id="add_email" class="form-control" name="add_email" placeholder="(Enter credentials)" required>
                    </div>
                    <div class="col-md-6">
                        <label for="add_password" class="form-label">Password</label>
                        <input type="password" id="add_password" class="form-control" name="add_password" placeholder="(Enter password)" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Counselor</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    {{-- <!-- Editor Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="edit_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="edit_modalLabel">Edit Counselor Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.counselor.edit') }}">
                    @csrf
                    <input type="text" name="counselor_id" id="counselor_id" hidden>
                    <input type="text" name="counselor_user_id" id="counselor_user_id" hidden>
                    <div class="col-md-6">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" id="firstname" class="form-control" name="firstname" placeholder="(Need to update)" required>
                    </div>
                    <div class="col-md-6">
                        <label for="surname" class="form-label">Last Name</label>
                        <input type="text" id="surname" class="form-control" name="surname" placeholder="(Need to update)" required>
                    </div>
                    <div class="col-md-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" class="form-control" name="email" placeholder="(Need to update)" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div> --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            var table = $('#counselorList').DataTable({
                processing: true,
                serverSide: true,
                scrollY: '50vh',
                ajax: {
                    method: 'get',
                    url: "{{ route('fetch.counselor.counselorList') }}",
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: false },
                    {data: 'full_name', name: 'full_name'},
                    {data: 'email', name: 'email'},
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function(){
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}'
            });
        @elseif(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}'
            });
        @endif
        });
    </script>

@endsection
