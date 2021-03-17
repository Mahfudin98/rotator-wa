@extends('layouts.layout')

@section('title')
    Home
@endsection

@section('content')
<main class="container">
    <div class="row mb-1">
      <div class="col-md-12">
          <h2 class="text-center">CEK ONGKIR</h2>
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col-md-8 p-4 d-flex flex-column position-static">
                <form method="POST">
                    <div class="mb-3">
                      <label for="harga" class="form-label">Harga Produk</label>
                      <input type="text" class="form-control" id="harga" name="harga" placeholder="Masukan Harga Produk" required>
                    </div>
                    <div class="mb-3">
                      <label for="berat" class="form-label">Berat (Kg)</label>
                      <input type="number" class="form-control" name="weight" id="weight" placeholder="Masukkan Berat (Kg)" placeholder="cont : 1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="province_id">Provinsi</label>
                        <select class="form-control" name="province_id" id="province_id" data-width="fit" data-style="form-control form-control-lg" data-title="Pilih Provinsi" required>
                          <option value="">Pilih Propinsi</option>
                          @foreach ($provinces as $row)
                          <option value="{{ $row->id }}">{{ $row->name }}</option>
                          @endforeach
                        </select>
                        <p class="text-danger">{{ $errors->first('province_id') }}</p>
                      </div>
                    <div class="mb-3">
                        <label class="form-label" for="city_id">Kabupaten</label>
                        <select class="form-control" name="city_id" id="city_id" data-width="fit" data-style="form-control form-control-lg" data-title="Pilih Kabupaten" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                        <p class="text-danger">{{ $errors->first('city_id') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="district_id">Kecamatan</label>
                        <select class="form-control" name="district_id" id="district_id" data-width="fit" data-style="form-control form-control-lg" data-title="Pilih Kecamatan" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                        <p class="text-danger">{{ $errors->first('district_id') }}</p>
                    </div>
                    <div class="mb-3">
                        <label for="metode" class="form-label">Metode Pembayaran</label>
                        <select class="form-control" name="metode" id="metode" required>
                            <option>Pilih Kecamatan Dulu</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="courier" class="form-label">Kurir</label>
                        <select class="form-control" name="courier" id="courier" required>
                            <option>Pilih Metode Dulu</option>
                        </select>
                        {{-- <input type="text" name="ongkos" id="ongkos" disabled> --}}
                    </div>


                    {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                </form>
            </div>
            <div class="col-md-4 p-4 bg-dark">
                <div class="container text-white">
                    <h2 class="text-center">Result</h2>
                    <div class="text-justify">
                        <p>Harga Produk : <strong id="outharga">Rp. 0</strong></p>
                        <p>Berat Produk : <strong id="berat">0 Kg</strong></p>
                        <p>Harga Ongkir : <strong id="ongkir">Rp. 0</strong></p>
                        <hr>
                        <strong id="biaya"></strong>
                        <p>Total pembayaran : <strong id="total">Rp. 0</strong></p>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

    {{-- <div class="row">
      <div class="col-md-8">
        <h3 class="pb-4 mb-4 fst-italic border-bottom">
          From the Firehose
        </h3>

        <article class="blog-post">
          <h2 class="blog-post-title">Sample blog post</h2>
          <p class="blog-post-meta">January 1, 2014 by <a href="#">Mark</a></p>

          <p>This blog post shows a few different types of content that’s supported and styled with Bootstrap. Basic typography, images, and code are all supported.</p>
          <hr>
          <p>Yeah, she dances to her own beat. Oh, no. You could've been the greatest. 'Cause, baby, <a href="#">you're a firework</a>. Maybe a reason why all the doors are closed. Open up your heart and just let it begin. So très chic, yeah, she's a classic.</p>
          <blockquote>
            <p>Bikinis, zucchinis, Martinis, no weenies. I know there will be sacrifice but that's the price. <strong>This is how we do it</strong>. I'm not sticking around to watch you go down. You think you're so rock and roll, but you're really just a joke. I know one spark will shock the world, yeah yeah. Can't replace you with a million rings.</p>
          </blockquote>
          <p>Trying to connect the dots, don't know what to tell my boss. Before you met me I was alright but things were kinda heavy. You just gotta ignite the light and let it shine. Glitter all over the room <em>pink flamingos</em> in the pool. </p>
          <h2>Heading</h2>
          <p>Suiting up for my crowning battle. If you only knew what the future holds. Bring the beat back. Peach-pink lips, yeah, everybody stares.</p>
          <h3>Sub-heading</h3>
          <p>You give a hundred reasons why, and you say you're really gonna try. Straight stuntin' yeah we do it like that. Calling out my name. ‘Cause I, I’m capable of anything.</p>
          <pre><code>Example code block</code></pre>
          <p>Before you met me I was alright but things were kinda heavy. You just gotta ignite the light and let it shine.</p>
          <h3>Sub-heading</h3>
          <p>You got the finest architecture. Passport stamps, she's cosmopolitan. Fine, fresh, fierce, we got it on lock. Never planned that one day I'd be losing you. She eats your heart out.</p>
          <ul>
            <li>Got a motel and built a fort out of sheets.</li>
            <li>Your kiss is cosmic, every move is magic.</li>
            <li>Suiting up for my crowning battle.</li>
          </ul>
          <p>Takes you miles high, so high, 'cause she’s got that one international smile.</p>
          <ol>
            <li>Scared to rock the boat and make a mess.</li>
            <li>I could have rewrite your addiction.</li>
            <li>I know you get me so I let my walls come down.</li>
          </ol>
          <p>After a hurricane comes a rainbow.</p>
        </article><!-- /.blog-post -->

        <article class="blog-post">
          <h2 class="blog-post-title">Another blog post</h2>
          <p class="blog-post-meta">December 23, 2013 by <a href="#">Jacob</a></p>

          <p>I am ready for the road less traveled. Already <a href="#">brushing off the dust</a>. Yeah, you're lucky if you're on her plane. I used to bite my tongue and hold my breath. Uh, She’s a beast. I call her Karma (come back). Black ray-bans, you know she's with the band. I can't sleep let's run away and don't ever look back, don't ever look back.</p>
          <blockquote>
            <p>Growing fast into a <strong>bolt of lightning</strong>. Be careful Try not to lead her on</p>
          </blockquote>
          <p>I'm intrigued, for a peek, heard it's fascinating. Oh oh! Wanna be a victim ready for abduction. She's got that international smile, oh yeah, she's got that one international smile. Do you ever feel, feel so paper thin. I’m gon’ put her in a coma. Sun-kissed skin so hot we'll melt your popsicle.</p>
          <p>This is transcendental, on another level, boy, you're my lucky star.</p>
        </article><!-- /.blog-post -->

        <article class="blog-post">
          <h2 class="blog-post-title">New feature</h2>
          <p class="blog-post-meta">December 14, 2013 by <a href="#">Chris</a></p>

          <p>From Tokyo to Mexico, to Rio. Yeah, you take me to utopia. I'm walking on air. We'd make out in your Mustang to Radiohead. I mean the ones, I mean like she's the one. Sun-kissed skin so hot we'll melt your popsicle. Slow cooking pancakes for my boy, still up, still fresh as a Daisy.</p>
          <ul>
            <li>I hope you got a healthy appetite.</li>
            <li>You're never gonna be unsatisfied.</li>
            <li>Got a motel and built a fort out of sheets.</li>
          </ul>
          <p>Don't need apologies. Boy, you're an alien your touch so foreign, it's <em>supernatural</em>, extraterrestrial. Talk about our future like we had a clue. I can feel a phoenix inside of me.</p>
        </article><!-- /.blog-post -->

        <nav class="blog-pagination" aria-label="Pagination">
          <a class="btn btn-outline-primary" href="#">Older</a>
          <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Newer</a>
        </nav>

      </div>

      <div class="col-md-4">
        <div class="p-4 mb-3 bg-light rounded">
          <h4 class="fst-italic">About</h4>
          <p class="mb-0">Saw you downtown singing the Blues. Watch you circle the drain. Why don't you let me stop by? Heavy is the head that <em>wears the crown</em>. Yes, we make angels cry, raining down on earth from up above.</p>
        </div>

        <div class="p-4">
          <h4 class="fst-italic">Archives</h4>
          <ol class="list-unstyled mb-0">
            <li><a href="#">March 2014</a></li>
            <li><a href="#">February 2014</a></li>
            <li><a href="#">January 2014</a></li>
            <li><a href="#">December 2013</a></li>
            <li><a href="#">November 2013</a></li>
            <li><a href="#">October 2013</a></li>
            <li><a href="#">September 2013</a></li>
            <li><a href="#">August 2013</a></li>
            <li><a href="#">July 2013</a></li>
            <li><a href="#">June 2013</a></li>
            <li><a href="#">May 2013</a></li>
            <li><a href="#">April 2013</a></li>
          </ol>
        </div>

        <div class="p-4">
          <h4 class="fst-italic">Elsewhere</h4>
          <ol class="list-unstyled">
            <li><a href="#">GitHub</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Facebook</a></li>
          </ol>
        </div>
      </div>

    </div>
    <!-- /.row --> --}}

</main><!-- /.container -->
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script type="text/javascript">
    $('#province_id').on('change', function() {
        $.ajax({
            url: "{{ url('/api/city') }}",
            type: "GET",
            data: { province_id: $(this).val() },
            success: function(html){

                $('#city_id').empty()
                $('#city_id').append('<option value="">Pilih Kabupaten/Kota</option>')
                $.each(html.data, function(key, item) {
                    $('#city_id').append('<option value="'+item.id+'">'+item.name+'</option>')
                })
            }
        });
    })
    $('#city_id').on('change', function() {
        $.ajax({
            url: "{{ url('/api/district') }}",
            type: "GET",
            data: { city_id: $(this).val() },
            success: function(html){
                $('#district_id').empty()
                $('#district_id').append('<option value="">Pilih Kecamatan</option>')
                $.each(html.data, function(key, item) {
                    $('#district_id').append('<option value="'+item.id+'">'+item.name+'</option>')
                })
            }
        });
    })
    $('#city_id').on('change', function() {
        $.ajax({
            url: "{{ url('/api/district') }}",
            type: "GET",
            data: { city_id: $(this).val() },
            success: function(html){
                $('#district_id').empty()
                $('#district_id').append('<option value="">Pilih Kecamatan</option>')
                $.each(html.data, function(key, item) {
                    $('#district_id').append('<option value="'+item.id+'">'+item.name+'</option>')
                })
            }
        });
    })

    $('#district_id').on('change', function() {
        $('#metode').empty()
        $('#metode').append('<option value="">Loading...</option>')
        $.ajax({
            success: function(html){
                $('#metode').empty()
                $('#metode').append('<option value="">Pilih Metode</option>')
                $('#metode').append(`
                        <option value="tf">Transfer</option>
                        <option value="cod">COD</option>
                    `)
            }
        });
    })

    $('#metode').on('change', function() {
        $('#courier').empty()
        $('#courier').append('<option value="">Loading...</option>')
        $.ajax({
            success: function(html){
                var metode = $('select[name=metode]').val()
                $('#courier').empty()
                $('#courier').append('<option value="">Pilih Kurir</option>')
                if (metode == 'tf') {
                    $('#courier').append(`
                        <option value="jne">JNE</option>
                        <option value="jnt">JNT</option>
                        <option value="anteraja">Anter Aja</option>
                    `)
                } else {
                    $('#courier').append(`
                        <option value="jnt">JNT</option>
                    `)
                }
            }
        });
    })

    $('#courier').on('change', function() {
            $('#ongkir').empty()
            $('#ongkir').append('Loading...')
            $('#outharga').empty()
            $('#outharga').append('Loading...')
            $('#berat').empty()
            $('#berat').append('Loading...')
            $('#total').empty()
            $('#total').append('Loading...')
            let berat = $('#weight').val();
            var weight = parseInt(berat) * 1000;
            $.ajax({
                url:"{{ url('/api/cost') }}",
                type: "POST",
                data: {
                        destination:         $('select[name=district_id]').val(),
                        courier:             $('select[name=courier]').val(),
                        weight:              weight,
                    },
                success: function (response) {
                    if (response) {
                        $('#ongkos').val(response[0].value)
                        var ongkir = numeral(response[0]['value']).format('0,0');
                        let harga = $('#harga').val()
                        var metode = $('select[name=metode]').val()
                        if (metode == 'cod') {
                            var biaya = (3/100)*parseInt(harga)
                            $('#ongkir').text('Rp. ' + ongkir);
                            let total = parseInt(harga) + parseInt(response[0]['value']) + parseInt(biaya)
                            var hasil = numeral(total).format('0,0');
                            var numharga = numeral(harga).format('0,0');
                            var beratjs = $('#weight').val()
                            $('#berat').text(beratjs + ' Kg')
                            $('#outharga').text('Rp. ' + numharga)
                            $('#total').text('Rp. ' + hasil)
                            var outbiaya = numeral(biaya).format('0,0');
                            $('#biaya').text('Biaya COD 3% : Rp. ' + outbiaya)
                        } else {
                            var biaya = 0
                            $('#ongkir').text('Rp. ' + ongkir);
                            let total = parseInt(harga) + parseInt(response[0]['value']) + parseInt(biaya)
                            var hasil = numeral(total).format('0,0');
                            var numharga = numeral(harga).format('0,0');
                            var beratjs = $('#weight').val()
                            $('#berat').text(beratjs + ' Kg')
                            $('#outharga').text('Rp. ' + numharga)
                            $('#total').text('Rp. ' + hasil)
                            $('#biaya').text('-')
                        }

                    }
                },
                error: function (response) {
                    console.log('Error:', response);
                }
            });
        })


</script>
@endsection
