@extends('layouts.layout')

@section('title')
    Add Multi Rotator
@endsection

@section('css')
<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
<style>
/* body
{
    font-family:Gill Sans MT;
    padding:10px;
} */
fieldset
{
    border: solid 1px #f27272;
    padding:10px;
    display:block;
    clear:both;
    margin:5px 0px;
}
legend
{
    padding:0px 10px;
    background:#f27272;
    color:#FFF;
}
input.add
{
    float:right;
}
input.fieldname
{
    float:left;
    clear:left;
    display:block;
    margin:5px;
}
select.fieldtype
{
    float:left;
    display:block;
    margin:5px;
}
input.remove
{
    float:left;
    display:block;
    margin:5px;
}
#yourform label
{
    float:left;
    clear:left;
    display:block;
    margin:5px;
}
#yourform input, #yourform textarea
{
    float:left;
    display:block;
    margin:5px;
}
</style>
@endsection

@section('content')
<main class="container">
    <div class="row mb-1">
        <div class="col-md-12">
            <h2 class="text-center">TAMBAH DATA LINK ROTATOR</h2>
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col-md-8 p-4 d-flex flex-column position-static">
                    <form action="{{ route('post.tambah') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <fieldset>
                            <legend>Tambahkan CS Disini!</legend>
                            <div class="input_fields_wrap mb-3">
                                <div>
                                    <input type="hidden" name="link_id" value="{{ $links->id }}">
                                    <label class="form-label" for="namecs">Nama CS</label>
                                    <input type="text" name="csname[]" class="form-control" id="namecs">
                                    <label class="form-label" for="phone">No HP</label>
                                    <input type="text" name="phone[]" class="form-control" id="phone">
                                    <input type="hidden" name="urutan[]" value="{{ $links->jumlah_rotator+1 }}">
                                </div>
                            </div>
                        </fieldset>

                        <div class="float-right">
                            <button class="add_field_button btn btn-success"><i class="fa fa-plus"></i> Tambah Field</button>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="col-md-4 p-4 bg-dark">
                    <div class="container text-white">
                        <h2 class="text-center">Result</h2>
                        <div class="text-justify">
                            @if (session('success'))
                            <input class="alert alert-success form-control disable" type="text" value="{{session('success')}}" id="myInput" readonly>
                                <div class="text-center">
                                    <button class="btn btn-success" onclick="myFunction()">Copy text</button>
                                </div>
                            @endif

                            @if (session('error'))
                            <div class="alert alert-error text-white disable">
                                {{session('error')}}
                            </div>
                                {{-- <div class="text-center">
                                    <button class="btn btn-success" onclick="myFunction()">Copy text</button>
                                </div> --}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main><!-- /.container -->
@endsection

@section('js')
<script>
$(document).ready(function() {
	var max_fields      = 10; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID

	var x = {{ $links->jumlah_rotator+1 }}; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div class="mb-3">' +
                                    '<hr>' +
                                    '<input type="hidden" name="link_id" value="{{ $links->id }}">' +
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
@endsection
