<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <div class="text-center">
                            @if (session('success'))
                            <div class="alert alert-success">
                                {{session('success')}}
                            </div>
                            @endif

                            @if (session('error'))
                            <div class="alert alert-error text-white disable">
                                {{session('error')}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header with-border" style="background-color: #f75858">
                            <h4 class="card-title text-white">
                                List Rotator
                            </h4>
                            <div class="float-right">
                                <a href="{{ route('single') }}" class="btn btn-dark">Tamabah Single Rotator</a>
                                <a href="{{ route('rotator') }}" class="btn btn-dark">Tambah Multi Rotator</a>
                            </div>
                        </div>

                        <div class="card-body" style="background-color: #f27272">
                            <form action="{{ route('dashboard') }}" method="get">
                                <div class="input-group mb-3 col-md-3 float-right">
                                    <!-- KEMUDIAN NAME-NYA ADALAH Q YANG AKAN MENAMPUNG DATA PENCARIAN -->
                                    <input type="text" name="q" class="form-control" placeholder="Cari Pixel" value="{{ request()->q }}">
                                    <div class="input-group-append">
                                        <button type="input" class="btn btn-secondary" type="button">Cari</button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-danger table-hover table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">No Hp</th>
                                            <th scope="col">Pixel</th>
                                            <th scope="col">Pesan</th>
                                            <th scope="col">Link</th>
                                            <th scope="col">Tipe Pengurutan</th>
                                            <th scope="col">Jumlah CS/Rotator</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($link as $row)
                                        <tr>
                                            <td>#</td>
                                            <th>
                                                @if ($row->phone == null)
                                                <a href="{{url('/rotator/view/' . $row->id)}}">{{$row->name}}</a>
                                                @else
                                                {{$row->name}}
                                                @endif
                                            </th>
                                            <td>
                                                @if ($row->phone != null)
                                                {{preg_replace("/^62/", "0", $row->phone)}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->pixel != null)
                                                {{$row->pixel}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{$row->pesan}}</td>
                                            <td>{{$row->link}}</td>
                                            <td>
                                                @if ($row->link_type == 0)
                                                    <span class="badge badge-secondary">Single</span>
                                                @elseif ($row->link_type == 1)
                                                    <span class="badge badge-info">Berurutan</span>
                                                @elseif ($row->link_type == 2)
                                                    <span class="badge badge-success">Random</span>
                                                @endif
                                            </td>
                                            <td>{{$row->jumlah_rotator}}</td>
                                            <td>
                                                @if ($row->status == 0)
                                                    <span class="badge badge-secondary">Draf</span>
                                                @else
                                                    <span class="badge badge-success">Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('edit', $row->id) }}">
                                                    <i class="btn btn-danger fa fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer" style="background-color: #f18484">
                           {{  $link->links('pagination::simple-tailwind')  }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
