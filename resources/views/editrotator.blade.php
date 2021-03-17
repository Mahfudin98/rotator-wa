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
            <h2 class="text-center">EDIT DATA LINK ROTATOR</h2>
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col-md-8 p-4 d-flex flex-column position-static">
                    <form action="{{ route('update.rotate', $link->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Rotator</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $link->name }}" id="name" name="name" placeholder="Masukan nama rotator" value="{{ old('name') }}" required autocomplete="name">
                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        @if ($link->phone != null)
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Masukan phone jika ada" value="{{preg_replace("/^62/", "0", $link->phone)}}" autocomplete="phone">
                            @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label" for="type_pixel">Tipe Pixel</label>
                            <select class="form-control" name="type_pixel" id="type_pixel" data-width="fit">
                                <option value="">Pilih Tipe</option>
                                <option value="Lead" {{ $link->type_pixel == 'Lead' ? 'selected':'' }}>Lead</option>
                                <option value="AddToCart" {{ $link->type_pixel == 'AddToCart' ? 'selected':'' }}>Add To Cart</option>
                            </select>
                            <p class="text-danger">{{ $errors->first('type_pixel') }}</p>
                        </div>
                        <div class="mb-3">
                            <label for="pixel" class="form-label">Pixel</label>
                            <input type="text" class="form-control @error('pixel') is-invalid @enderror" name="pixel" id="pixel" placeholder="Masukan pixel jika ada" value="{{ $link->pixel }}" autocomplete="pixel">
                            @error('pixel')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan</label>
                            <textarea class="form-control @error('pesan') is-invalid @enderror" name="pesan" id="pesan" cols="30" rows="10" placeholder="Masukan isi pesan." value="{{ old('pesan') }}" required autocomplete="pesan">{{ $link->pesan }}</textarea>
                            @error('pesan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        @if ($link->link_type != 0)
                        <input type="hidden" name="link_type" value="1">
                        @else
                        <input type="hidden" name="link_type" value="0">
                        @endif
                        <div class="mb-3">
                            <label for="link" class="form-label">Link</label>
                            <input type="text" class="form-control  @error('link') is-invalid @enderror" name="link" id="link" placeholder="Masukan link untuk rotator" value="{{ $link->link }}" required autocomplete="link">
                            @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukan email" value="{{ $link->email }}" required autocomplete="link">
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="status">Tipe Pengurutan</label>
                            <select class="form-control" name="status" id="status" data-width="fit" required>
                                <option value="">Pilih Tipe</option>
                                <option value="1" {{ $link->status == '1' ? 'selected':'' }}>Aktif</option>
                                <option value="0" {{ $link->status == '0' ? 'selected':'' }}>Draf</option>
                            </select>
                            <p class="text-danger">{{ $errors->first('status') }}</p>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="col-md-4 p-4 bg-dark">
                    <div class="container text-white">
                        <h2 class="text-center">Result</h2>
                        <div class="text-center">
                            @if (session('success'))
                            <div class="alert alert-error text-white disable">
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
                </div>
            </div>
        </div>
    </div>
</main><!-- /.container -->


@endsection

@section('js')

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
