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
                        List Rotator
                    </h4>
                </div>

                <div class="card-body" style="background-color: #f27272">
                    <form action="{{ route('rotator.list') }}" method="get">
                        <div class="input-group mb-3 col-md-3 float-right">
                            <!-- KEMUDIAN NAME-NYA ADALAH Q YANG AKAN MENAMPUNG DATA PENCARIAN -->
                            <input type="text" name="q" class="form-control" placeholder="Cari Pixel..." value="{{ request()->q }}">
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
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($link as $row)
                                <tr>
                                    <td>#</td>
                                    <th>
                                        @if ($row->phone == null)
                                        <a href="{{url('/guest/show/' . $row->id)}}">{{$row->name}}</a>
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
                                            <span class="badge badge-success">Draf</span>
                                        @else
                                            <span class="badge badge-success">Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer" style="background-color: #f18484">
                    {!! $link->links('pagination::default') !!}
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

@endsection
