<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List Data CS '.$link->link) }}
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
                                <a href="#" data-toggle="modal" data-target="#add" class="btn btn-dark">Tambah Rotator CS</a>
                            </div>
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
                                            <th scope="col">Aksi</th>
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
                                            <td>
                                                <form action="{{ route('delete.cs',$row->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="btn btn-primary" data-toggle="modal" data-target="#rotator{{ $row->id }}">
                                                        <i class="fas fa-edit text-white"></i>
                                                    </a>
                                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
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
        </div>
    </div>

@foreach ($rotator as $row)
  <div class="modal fade" id="rotator{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Edit Rotator</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('update.rot', $row->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group mb-3">
                    <div>
                        <input type="hidden" name="link_id" value="{{ $link->id }}">
                        <label class="form-label" for="phone">Nomor Urut</label>
                        <input type="number" name="urutan" class="form-control" value="{{ $row->urutan }}">
                        <label class="form-label" for="namecs">Nama CS</label>
                        <input type="text" name="csname" class="form-control" value="{{ $row->name }}" id="namecs">
                        <label class="form-label" for="phone">No HP</label>
                        <input type="text" name="phone" class="form-control" value="{{preg_replace("/^62/", "0", $row->phone)}}" id="phone">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endforeach

  <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Rotator</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('post.tambah') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <fieldset>
                    <legend>Tambahkan CS Disini!</legend>
                    <div class="input_fields_wrap mb-3">
                        <div>
                            <input type="hidden" name="link_id" value="{{ $link->id }}">
                            <label class="form-label" for="namecs">Nama CS</label>
                            <input type="text" name="csname[]" class="form-control" id="namecs">
                            <label class="form-label" for="phone">No HP</label>
                            <input type="text" name="phone[]" class="form-control" id="phone">
                            <input type="hidden" name="urutan[]" value="{{ $link->jumlah_rotator+1 }}">
                        </div>
                    </div>
                </fieldset>
                <div class="float-right">
                    <button class="add_field_button btn btn-success"><i class="fa fa-plus"></i> Tambah Field</button>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID

        var x = {{ $link->jumlah_rotator+1 }}; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="mb-3">' +
                                        '<hr>' +
                                        '<input type="hidden" name="link_id" value="{{ $link->id }}">' +
                                        '<label class="form-label" for="namecs">Nama CS</label>' +
                                        '<input type="text" name="csname[]" class="form-control" id="namecs">' +
                                        '<label class="form-label" for="phone">No HP</label>' +
                                        '<input type="text" name="phone[]" class="form-control" id="phone">' +
                                        '<input type="hidden" name="urutan[]" value="'+x+'">' +
                                        '<br><a href="#" class="remove_field btn btn-danger float-right"><i class="fa fa-trash"></i> Hapus Field</a>'+
                                  '</div>'); //add input box
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });
    </script>
    <script>
        function myFunction() {
          var copyText = document.getElementById("myInput");
          copyText.select();
          copyText.setSelectionRange(0, 99999)
          document.execCommand("copy");
          alert("Url Berhasil di copy : " + copyText.value);
        }
    </script>
</x-app-layout>


