@extends('layouts.app')
@section('content')

<div class="container">
    <h3 class="mb-5">Generate Forms</h3>
    <div style="display: grid; gap: 1rem; grid-template-columns: auto auto auto auto;">
        <div class="card text-center" style="width: 18rem;">
            <img src="{{ asset('img/good_moral_certificate.png') }}" class="card-img-top" alt="Document Picture">
            <div class="card-body">
              <h5 class="card-title fw-bold">Good Moral Certificate</h5>
              <a data-document="good moral certificate" id="customize_btn" href="{{ route('admin.viewGoodMoralCert') }}" class="btn btn-secondary">Customize</i></a>
              <a data-id="2" data-document="good moral certificate" id="download_btn" href="#" class="btn btn-primary">Download</i></a>
            </div>
        </div>
        <div class="card text-center" style="width: 18rem;">
            <img src="{{ asset('img/home_visitation.png') }}" class="card-img-top" alt="Document Picture">
            <div class="card-body">
              <h5 class="card-title fw-bold">Home Visitation Form</h5>
              <a data-document="home visitation form" id="customize_btn" href="{{ route('admin.viewHomeVisitationForm') }}" class="btn btn-secondary">Customize</i></a>
              <a data-id="3" data-document="home visitation form" id="download_btn" href="#" class="btn btn-primary">Download</i></a>
            </div>
        </div>
        <div class="card text-center" style="width: 18rem;">
            <img src="{{ asset('img/travel_form.png') }}" class="card-img-top" alt="Document Picture">
            <div class="card-body">
              <h5 class="card-title fw-bold">Travel Order Form</h5>
              <a data-document="travel order form" id="customize_btn" href="{{ route('admin.viewTravelForm') }}" class="btn btn-secondary">Customize</i></a>
              <a data-id="4" data-document="travel order form" id="download_btn" href="#" class="btn btn-primary">Download</i></a>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function(){
        $(document).on('click', '#download_btn',function() {
            var id = $(this).data('id');
            var document = $(this).data('document');

            Swal.fire({
                title: 'Download',
                text: 'Download ' + document + '.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#rrr',
                cancelButtonColor: '#ddd',
                confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.isConfirmed) {
                    var token = $('meta[name="csrf-token"]').attr('content');
                    var url = `{{ route('admin.forms.download') }}?id=${id}&_token=${token}`;
                    window.open(url, '_blank');
                }
            });
        });
    });
</script>

@endsection
