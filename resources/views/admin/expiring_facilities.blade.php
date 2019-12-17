@extends('layouts.app')
@section('title','Expiring Facilities')
@section('content')
    <section class="content">
        <div class="box box-primary flat">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-heartbeat"></i>
                   Expiring Health Facility { {{count($facilities)}} }
                </h3>

                <div class="box-tools pull-right">
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Ref Number</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Service</th>
                        <th scope="col">Manager</th>
                        <th scope="col">Phone</th>
                        <th scope="col">L.Issued</th>
                        <th scope="col">L.Expire</th>
                        <th scope="col">Rem Days</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($facilities as $fac)
                        <tr>
                            <td>{{ $fac->ref_number }}</td>
                            <td>{{ $fac->name }}</td>
                            <td>{{ $fac->category->name }}</td>
                            <td>{{ $fac->service->name }}</td>
                            <td>{{ $fac->manager_name }}</td>
                            <td>{{ $fac->phone }}</td>
                            <td>{{ $fac->license_issued_at!=null? $fac->license_issued_at->format('d/m/Y'):'Not set' }}</td>
                            <td>{{ $fac->license_expires_at!=null?$fac->license_expires_at->format('d/m/Y'):'Unknown' }}</td>
                            <td>
                                <span style="color: red">{{ $fac->DaysRem }}</span>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $('.tr-reports').addClass('active');
        $('.mn-expiring').addClass('active');
    </script>
@endsection
