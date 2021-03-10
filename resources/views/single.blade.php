@extends('layouts.layout')

@section('title')
    Add Single Rotator
@endsection

@section('content')
<main class="container">
    <div class="row mb-1">
        <div class="col-md-12">
            <h2 class="text-center">TAMBAH DATA LINK</h2>
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col-md-8 p-4 d-flex flex-column position-static">
                    <form action="{{ route('post.single') }}" method="post">
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
                            <label for="phone" class="form-label">Nomor HP</label>
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="ext : 081xxxxxxxx" value="{{ old('phone') }}" required autocomplete="phone">
                            @error('phone')
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
                        {{-- <div class="mb-3">
                            <label class="form-label" for="link_type">Tipe Pengurutan</label>
                            <select class="form-control" name="link_type" id="link_type" data-width="fit" data-style="form-control form-control-lg" data-title="Pilih Provinsi" required>
                                <option value="">Pilih Tipe</option>
                                <option value="0">Single</option>
                                <option value="1">Berurutan</option>
                                <option value="2">Acak</option>
                            </select>
                            <p class="text-danger">{{ $errors->first('link_type') }}</p>
                        </div> --}}
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
    function myFunction() {
      var copyText = document.getElementById("myInput");
      copyText.select();
      copyText.setSelectionRange(0, 99999)
      document.execCommand("copy");
      alert("Url Berhasil di copy : " + copyText.value);
    }
    </script>
@endsection
