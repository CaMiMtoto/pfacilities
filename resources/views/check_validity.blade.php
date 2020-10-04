@extends('layouts.master')
@section('title',"License Letter for ". $facility->name  )
@section('content')

    <div class="row justify-content-center align-items-center">
        <div class="col-md-6 m-1 m-md-5">

            <div class="pt-3">
                <p>
                    <strong class="text-uppercase">
                        Republic of rwanda
                    </strong>
                </p>
                <img src="{{ asset('dist/img/moh.jpg') }}" class="img-fluid rounded border-white"
                     style="height: 80px; object-fit: cover" alt="">
                <br>
                <strong>
                    MINISTRY OF HEALTH
                </strong>
                <p class="mt-0 mb-0">
                    <strong>
                        P.O BOX 84 Kigali
                    </strong>
                </p>
                <p class="mt-0">
                    <a href="http://www.moh.gov.rw" class="border-bottom border-dark text-dark">
                        www.moh.gov.rw
                    </a>
                </p>
            </div>
            <div class="card shadow-sm rounded-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Facility validity</h4>
                    @if(now()>$facility->license_expires_at)
                        <span class="badge badge-danger rounded-pill px-3">Expired</span>
                    @else
                        <span class="badge badge-success rounded-pill px-3">Active</span>
                    @endif
                </div>
                <div class="card-body">
                    <p>
                        Facility Name:
                        <strong>{{$facility->name}}</strong>
                    </p>
                    <p>
                        Issued At:
                        <strong>{{optional($facility->license_issued_at)->format('d M Y')??'N/A'}}</strong>
                    </p>
                    <p>
                        Expiring At:
                        <strong>{{optional($facility->license_expires_at)->format('d M Y')??'N/A'}}</strong>
                    </p>
                    <p>
                        Remain:
                        <strong>{{  optional($facility->license_expires_at)->diffForHumans() ??'N/A'}}</strong>

                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
