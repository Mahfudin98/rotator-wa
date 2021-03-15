<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    @if ($links->link_type == 1)
    <title>Menghubungi {{ $nomor[0]->name }}</title>
    @else
    <title>Menghubungi {{ $links->name }}</title>
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function startTimer(duration, display) {
            var start = Date.now(),
                diff,
                minutes,
                seconds;
            function timer() {
                // get the number of seconds that have elapsed since
                // startTimer() was called
                diff = duration - (((Date.now() - start) / 1000) | 0);

                // does the same job as parseInt truncates the float
                minutes = (diff / 60) | 0;
                seconds = (diff % 60) | 0;

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (diff <= 0) {
                    // add one second so that the count down starts at the full duration
                    // example 05:00 not 04:59
                    start = Date.now() + 1000;
                }
            };
            // we don't want to wait a full second before the timer starts
            timer();
            setInterval(timer, 1000);
        }

        window.onload = function () {
            var fiveMinutes = 3,
                display = document.querySelector('#time');
            startTimer(fiveMinutes, display);
        };
    </script>

    <style>
        .tengah {
          padding: 100px 0;
          text-align: center;
        }
    </style>
  </head>
  <body style="background-color: #ffb19d">
    @if ($links->link_type == 1)
    <div class="tengah">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <div class="shadow-sm p-3 mb-5 bg-body rounded">
                    <div class="text-center">
                        <img src="{{ asset('img/logo-ls.png') }}" class="img-thumbnail" alt="...">
                    </div>
                    <h3 class="text-uppercase">{{$nomor[0]->name}}</h3>
                    <h4><strong>{{preg_replace("/^62/", "0", $nomor[0]->phone)}}</strong></h4>
                    <a href="https://api.whatsapp.com/send?phone={{ $nomor[0]->phone }}&text={{ urlencode(strtolower($links->pesan)) }}"><button class="btn btn-success"><i class="fab fa-whatsapp"></i> Whataspp</button></a>
                    <div>Akan dialihkan dalam <span id="time"></span> detik!</div>
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
    <script>
        var phone = '{{ $nomor[0]->phone }}'
        var pesan = '{{ urlencode(strtolower($links->pesan)) }}'
        setTimeout(function () {
            window.location.href = 'https://api.whatsapp.com/send?phone='+phone+'&text='+pesan+''; //will redirect to your blog page (an ex: blog.html)
        }, 3000);
    </script>
    @else
    <div class="tengah">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <div class="shadow-sm p-3 mb-5 bg-body rounded">
                    <div class="text-center">
                        <img src="{{ asset('img/logo-ls.png') }}" class="img-thumbnail" alt="...">
                    </div>
                    <h3 class="text-uppercase">{{$links->name}}</h3>
                    <h4><strong>{{$links->phone}}</strong></h4>
                    <a href="https://api.whatsapp.com/send?phone={{ $links->phone }}&text={{ urlencode(strtolower($links->pesan)) }}"><button class="btn btn-success"><i class="fab fa-whatsapp"></i> Whataspp</button></a>
                    <div>Akan dialihkan dalam <span id="time"></span> detik!</div>
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
        <script>
            var phone = '{{ $links->phone }}'
            var pesan = '{{ urlencode(strtolower($links->pesan)) }}'
            setTimeout(function () {
                window.location.href = 'https://api.whatsapp.com/send?phone='+phone+'&text='+pesan+''; //will redirect to your blog page (an ex: blog.html)
            }, 3000);
        </script>
    @endif
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->
  </body>
</html>
