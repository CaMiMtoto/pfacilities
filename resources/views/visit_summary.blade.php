@extends('layouts.app')
@section('title','Facility visit summary')
@section('styles')
    <style>
        pre {
             background-color: inherit;
             border: 1px solid transparent;
             border-radius: 0;
        }
    </style>
@endsection
@section('content')
    <section class="content">
        <div class="container">
            <div class="col-md-12">

            </div>
        </div>
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header with-border">
                       <h4 class="box-title">
                           <i class="fa fa-heart-o"></i>
                           {{ $facilityVisit->facility->name }}
                       </h4>
                        <div class="box-tools">
                            <button onclick="printDoc();" class="no-print btn btn-default">Print</button>
                        </div>
                    </div>
                    <p>
                        <strong>Date:</strong>
                        <span>{{ $facilityVisit->date }}</span>
                    </p>
                    <p>
                        <strong>Visited By:</strong>
                        <span>{{ $facilityVisit->visitor }}</span>
                    </p>
                    <p>
                        <strong>Visit purpose:</strong>
                        <span>{{ $facilityVisit->purpose }}</span>
                    </p>
                    <br>
                    <br>
                    <br>
                    <p>
                        <strong>Findings:</strong>
                        <span>{{ $facilityVisit->comment }}</span>
                    </p>
                    <p>
                        <strong>Recommendations:</strong>
                        <span>{!! $facilityVisit->recommendations !!}</span>
                    </p>
                    <br>
                    <br>
                    <p>
                        <strong>Done By:</strong>
                        <span>{{ $facilityVisit->user->name }}</span>
                    </p>
                </div>
                <!-- /.col -->
            </div>

        </section>

    </section>


@endsection

@section('scripts')

    <script>
        printDoc();
    </script>

@endsection
