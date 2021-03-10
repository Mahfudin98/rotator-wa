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
                    <form action="{{ route('post.rotator') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Rotator</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukan nama rotator" value="{{ old('name') }}" required autocomplete="name">
                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="type_pixel">Tipe Pixel</label>
                            <select class="form-control" name="type_pixel" id="type_pixel" data-width="fit">
                                <option value="">Pilih Tipe</option>
                                <option value="Lead">Lead</option>
                                <option value="AddToCart">Add To Cart</option>
                            </select>
                            <p class="text-danger">{{ $errors->first('type_pixel') }}</p>
                        </div>
                        <div class="mb-3">
                            <label for="pixel" class="form-label">Pixel</label>
                            <input type="text" class="form-control @error('pixel') is-invalid @enderror" name="pixel" id="pixel" placeholder="Masukan pixel jika ada" value="{{ old('pixel') }}" autocomplete="pixel">
                            @error('pixel')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan</label>
                            <textarea class="form-control @error('pesan') is-invalid @enderror" name="pesan" id="pesan" cols="30" rows="10" placeholder="Masukan isi pesan." value="{{ old('pesan') }}" required autocomplete="pesan">{{ old('pesan') }}</textarea>
                            @error('pesan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="link_type">Tipe Pengurutan</label>
                            <select class="form-control" name="link_type" id="link_type" data-width="fit" required>
                                <option value="">Pilih Tipe</option>
                                <option value="1">Berurutan</option>
                                <option value="2">Acak</option>
                            </select>
                            <p class="text-danger">{{ $errors->first('link_type') }}</p>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Link</label>
                            <input type="text" class="form-control  @error('link') is-invalid @enderror" name="link" id="link" placeholder="Masukan link untuk rotator" value="{{ old('link') }}" required autocomplete="link">
                            @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukan email" value="{{ old('email') }}" required autocomplete="link">
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <fieldset id="buildyourform">
                            <legend>Tambahkan CS Disini!</legend>
                        </fieldset>
                        <div class="float-right">
                            <button type="button" class="btn btn-success" value="Add a field" id="add"><i class="fa fa-plus"></i> Tambah Data CS</button>
                        </div>

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
        $("#add").click(function() {
            var lastField = $("#buildyourform div:last");
            var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
            var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
            fieldWrapper.data("idx", intId);
            var fName = $("<input id=\"csname\" type=\"hidden\" class=\"form-control\" name=\"csname\" />");
            var fLabelName = $("<label for=\"csname\" class=\"form-label\">Nama CS</label>");
            var fName = $("<input id=\"csname\" type=\"text\" class=\"form-control\" name=\"csname\" placeholder=\"Nama CS\" />");
            var fLabelPhone = $("<label for=\"phone\" class=\"form-label\">Nomor HP CS</label>");
            var fPhone = $("<input id=\"phone\" type=\"tel\" class=\"form-control\" name=\"phone\" placeholder=\"Nomor HP CS\" />");
            // var fPhone = $("<select class=\"fieldtype\"><option value=\"checkbox\">Checked</option><option value=\"textbox\">Text</option><option value=\"textarea\">Paragraph</option></select>");
            // var removeButton = $("<input type=\"button\" class=\"btn btn-danger remove\" value=\"fa fa-trash\" /> <br>");
            var removeButton = $("<br><button type=\"button\" class=\"btn btn-danger\"><i class=\"fa fa-trash\"></i></button><br>")
            removeButton.click(function() {
                $(this).parent().remove();
            });
            fieldWrapper.append(fLabelName);
            fieldWrapper.append(fName);
            fieldWrapper.append(fLabelPhone);
            fieldWrapper.append(fPhone);
            fieldWrapper.append(removeButton);
            $("#buildyourform").append(fieldWrapper);
        });
        $("#preview").click(function() {
            $("#yourform").remove();
            var fieldSet = $("<fieldset id=\"yourform\"><legend>Your Form</legend></fieldset>");
            $("#buildyourform div").each(function() {
                var id = "input" + $(this).attr("id").replace("field","");
                var label = $("<label for=\"" + id + "\">" + $(this).find("input.fieldname").first().val() + "</label>");
                var input;
                switch ($(this).find("select.fieldtype").first().val()) {
                    case "checkbox":
                        input = $("<input type=\"checkbox\" id=\"" + id + "\" name=\"" + id + "\" />");
                        break;
                    case "textbox":
                        input = $("<input type=\"text\" id=\"" + id + "\" name=\"" + id + "\" />");
                        break;
                    case "textarea":
                        input = $("<textarea id=\"" + id + "\" name=\"" + id + "\" ></textarea>");
                        break;
                }
                fieldSet.append(label);
                fieldSet.append(input);
            });
            $("body").append(fieldSet);
        });
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
