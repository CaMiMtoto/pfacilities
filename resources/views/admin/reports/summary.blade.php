@extends('layouts.app')
@section('title','Summary Report')
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
        <form action="{{ route('summary.facilities') }}" method="get" class="form-inline no-print">
            <div class="form-group form-group-sm">
                <label for="district">District</label> <br>
                <select required class="form-control" name="district" id="district">
                    <option value=""></option>
                    @foreach($districts as $dist)
                        <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group form-group-sm">
                <label for="category">Category</label><br>
                <select required class="form-control" name="category" id="category">
                    <option value=""></option>
                    @foreach($categories as $dist)
                        <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group form-group-sm">
                <label for="service">Service</label><br>
                <select required class="form-control" name="service" id="service">
                    <option value=""></option>
                    @foreach($services as $dist)
                        <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group form-group-sm">
                <label for="district"><br></label><br>
              <button class="btn btn-primary btn-sm">
                  <i class="fa fa-search"></i>
                  Go
              </button>
            </div>
        </form>
        <div class="box box-default flat">
            <div class="box-header">
          {{--      <img src="{{ asset('images/MINISANTE_ENG_FR_KINY_All_004.jpg') }}" class="img img-responsive"
                     style="height: 150px"
                     alt="">
                <br>--}}

                <div class="box-tools pull-right">
                    <div class="no-print">
                        {{--            <a href="{{ route('adminFacilities') }}" class="bbtn btn-primary btn-sm pull-left">Go Back</a>--}}
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
                        <th>District Name</th>
                        @foreach($categories as $category)
                            <th>{{ $category->name }}</th>
                        @endforeach
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $total = 0;?>
                    @foreach($districts as $dist)
                        <tr>
                            <?php $totalCategories = 0;?>
                            <td>{{ $dist->name }}</td>
                            @foreach($categories as $category)
                                <td>
                                    <?php
                                    $count = \App\Report::count($dist->id, $category->id);
                                    $totalCategories += $count;
                                    $total += $count;
                                    ?>
                                    {{ $count }}
                                </td>
                            @endforeach
                            <td>{{ $totalCategories }}</td>
                        </tr>
                    @endforeach
                    <tfooot>
                        <th>Total</th>
                        @foreach($categories as $category)
                            <th>{{ \App\Facility::where('category_id',$category->id)->count() }}</th>
                        @endforeach
                        <th>{{ $total }}</th>
                    </tfooot>
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

