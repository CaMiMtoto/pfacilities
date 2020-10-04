@extends('layouts.master')
@section('title',"License Letter for". $license->userApplication->facility->name  )
@section('content')
    <div class="py-3">
        <div class="container mt-3">
            <button
                onclick="window.print()"
                class="btn btn-primary mb-3 no-print">
                Print
            </button>
            <div class="row justify-content-center">

                <div class="col-md-12" style="border: 1px solid">
                    <div class="row">
                        <div class="col-md-8">
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

                        </div>
                        <div class="col-md-4">
                            <p>
                                Kigali,
                            </p>
                            <p>
                                <strong>
                                    {{ $license->ref_number }}
                                </strong>
                            </p>
                        </div>
                    </div>

                    <div class="bg-primary row my-4 p-3 d-flex justify-content-center">
                        <strong class="text-uppercase text-white"> {{ $license->reason }}</strong>
                    </div>
                    <div class="mt-3">

                        <p class="mb-0">
                            <strong>Name:{{ $license->userApplication->user->name }}</strong>
                        </p>
                        <p class="mb-0">
                            <strong>Province:{{ $license->userApplication->facility->sector->district->province->name }}</strong>
                        </p>
                        <p class="mb-0">
                            <strong>District:{{ $license->userApplication->facility->sector->district->name }}</strong>
                        </p>

                        <p class="mb-0">
                            <strong>Sector:{{ $license->userApplication->facility->sector->name }}</strong>
                        </p>

                        <p class="mb-0">
                            <strong>Cell:{{ $license->userApplication->facility->cell->name??'' }}</strong>
                        </p>
                        <p class="mb-0">
                            <strong>Plot Number:{{ $license->userApplication->facility->plot_number??'' }}</strong>
                        </p>

                    </div>
                    <div class="mt-3 mb-3">
                        <p>{{ $license->body }}</p>
                    </div>
                    <div class="mt-3 mb-3">
                        <p>
                            The holder of this certificate commits to abide by the rules and regulations for private
                            health
                            practice in Rwanda.
                        </p>
                    </div>
                    <div class="mt-5 mb-3">
                        <div class="row">
                            <div class="col-md-6"><p>
                                    Issued at Kigali</p></div>
                            <div class="col-md-6">
                                <p>
                                    On {{ $license->signed_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>

                    </div>
                    <div>
                        {{--<p class="mb-0">
                            Signature
                        </p>
                        <span>
                                <img src="{{ $license->user->signature->signature_url }}" alt="Signature"
                                     class="img-fluid ml-5"
                                     style="height: 50px">
                          </span>--}}

                        <div class="my-5">
                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->generate(route('facilities.checkValidity',encrypt($license->userApplication->facility->id))); !!}
                        </div>
                    </div>
                    <div>
                        <p>
                            <strong>{{ $license->user->name }}</strong>
                            <br>
                            <strong>
                                Minister of Health
                            </strong>
                        </p>


                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
