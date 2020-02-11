@extends('layouts.app')
@section('title','Facilities Report')
@section('style')
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
@endsection
@section('content')
    <div class="content">
        <div class="box box-default flat">
            <div class="box-header">
                <div class="col-md-4">
                    <img src="{{ asset('images/MINISANTE_ENG_FR_KINY_All_004.jpg') }}" class="img img-responsive"
                         style="height: 150px"
                         alt="">
                    <br>
                </div>
                <div class="col-md-4">
                    <p>
                        <strong>District:</strong>
                        {{ $district->name }}|
                        <strong>Category:</strong>
                        {{ $category->name }} | <strong>Service:</strong>
                        {{ $service->name }}
                        | <strong>Total:</strong> {{ $facilities->count() }}
                    </p>
                </div>

                <div class="box-tools pull-right">
                    <div class="no-print">
                        <a href="{{ route('summary') }}" class="bbtn btn-primary btn-sm pull-left">Go Back</a>
                        <button onclick="window.print();" class="btn btn-default btn-sm pull-right">
                            <i class="glyphicon glyphicon-print"></i>
                            Print
                        </button>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>

            </div>
            <div class="box-body">

                <table class="table table-bordered  table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Ref. Number</th>
                        <th>Facility Name</th>
                        <th>Manager</th>
                        <th>Phone Number</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;?>
                    @foreach($facilities as $facility)
                        <tr>
                            <td><?php print  $i?></td>
                            <td>
                                @if($facility->ref_number)
                                    <span>{{ $facility->ref_number }}</span>
                                @else
                                    <span class="label label-default">Not Given</span>
                                @endif
                            </td>
                            <td>{{ $facility->name }}</td>
                            <td>{{ $facility->manager_name }}</td>
                            <td>{{ $facility->phone }}</td>
                        </tr>
                        <?php $i++;?>
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>

    </div>

@endsection

@section('scripts')
    <script>
        $('.tr-reports').addClass('active');
        $('.mn-summary').addClass('active');
    </script>
@endsection

