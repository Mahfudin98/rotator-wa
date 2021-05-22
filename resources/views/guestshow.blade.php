@extends('layouts.layout')

@section('title')
    Rotator
@endsection

@section('content')
<main class="container">
    <div class="row mb-1">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border" style="background-color: #f75858">
                    <h4 class="card-title text-white">
                        List CS
                    </h4>
                </div>

                <div class="card-body" style="background-color: #f27272">
                    <div class="table-responsive">
                        <table class="table table-danger table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Rotator</th>
                                    <th scope="col">Nomor Urut Rotator</th>
                                    <th scope="col">Nama CS</th>
                                    <th scope="col">No HP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rotator as $row)
                                <tr>
                                    <td>#</td>
                                    <th>{{$link->name}}</th>
                                    <td>{{$row->urutan}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{preg_replace("/^62/", "0", $row->phone)}}</td>
                                </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer" style="background-color: #f18484">

                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border" style="background-color: #f75858">
                    <div class="float-leaft text-white">
                        <h3>List Click</h3>
                    </div>
                    <div class="float-right">
                        <form action="{{ route('guest.show',$link->id) }}" method="get">
                            <div class="input-group float-right">
                                <!-- KEMUDIAN NAME-NYA ADALAH Q YANG AKAN MENAMPUNG DATA PENCARIAN -->
                                <input type="date" name="q" class="form-control">
                                <div class="input-group-append">
                                    <button type="input" class="btn btn-secondary" type="button">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body" style="background-color: #f27272">
                    <div class="table-responsive">
                        <table class="table table-danger table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th class="bg-danger text-light" scope="col">#</th>
                                    <th class="bg-primary" scope="col">Click Date</th>
                                    <th class="bg-warning text-dark" scope="col">Urut</th>
                                    <th class="bg-warning text-dark" scope="col">User Device</th>
                                    <th class="bg-warning text-dark" scope="col">IP Address</th>
                                    <th class="bg-success" scope="col">Clik Time </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @forelse ($click as $row)
                                    @foreach ($rotator->where('urutan', $row->urut) as $item)
                                    <tr>
                                        <td class="bg-danger text-light">{{ $i++ }}</td>
                                        <th class="bg-primary text-light">{{date("d/M/Y", strtotime($row->click_time))}}</th>
                                        <td class="bg-warning">{{ $item->name }}</td>
                                        <td class="bg-warning">{{ $row->user_device }}</td>
                                        <td class="bg-warning">
                                            <div class="alert alert-danger text-center" role="alert">
                                                {{ $row->ip_address }}
                                            </div>
                                        </td>
                                        <td class="bg-success text-light">Jam {{ date("H:i", strtotime($row->created_at))}} WIB</td>
                                    </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center"> Data Tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer" style="background-color: #f18484">
                        {{ $click->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main><!-- /.container -->
@endsection

@section('js')

@endsection
