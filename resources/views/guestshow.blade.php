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
    </div>
</main><!-- /.container -->
@endsection

@section('js')

@endsection
