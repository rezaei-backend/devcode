

@extends('app.layouts.master')

@section('title','تیم  ما خوب است')

@section('content')
    <main>


        <section>
            <div class="container">
                <!-- Title -->
                <div class="row mb-4">
                    <h2 class="mb-0 fs-4">تیم ما</h2>
                </div>

                <!-- Slider START -->
                <div class="tiny-slider arrow-round arrow-creative arrow-blur arrow-hover">
                    <div class="tiny-slider-inner" data-autoplay="false" data-arrow="true" data-dots="false" data-items="4" data-items-lg="3" data-items-md="2" data-items-xs="1">
                        @foreach($teams as $team)
                        <div class="card bg-transparent">
                            <div class="position-relative">

                                <!-- Image -->
                                <a href="moeid.html">
                                    <img src="{{asset('images/team/'.$team->image)}}" class="card-img" alt="&#x634;&#x633;&#x6CC;" loading="lazy" decoding="async">
                                </a>

                                <!-- Overlay -->

                                    <div class="card-img-overlay d-flex flex-column p-3">
                                        <div class="w-100 mt-auto text-end"></div>
                                    </div>

                            </div>

                            <div class="card-body text-center">
                                <h5 class="card-title">
                                    {{$team->fullname}}
                                </h5>
                                <p class="mb-2">{{$team->Expertise}}</p>


                            </div>

                            <div class="card-body text-center">
                                <!-- Social media button -->


                                  {!!
                       $team->phone!="" ?       <<<HTML
                                    <li class="list-inline-item">
                                        <a class="btn px-2 btn-sm bg-instagram-gradient" href="tel:$team->phone" target="_blank" rel="noopener nofollow" aria-label="Instagram">
                                            <i class="fab fa-fw fa-instagram"></i>
                                        </a>
                                    </li>
                                    HTML
                                    :""
                  !!}
                                {!!
$team->resume ?
                                  <<<HTML
                                    <li class="list-inline-item">
                                        <a class="btn px-2 btn-sm bg-linkedin" href="$team->resume" target="_blank" rel="noopener nofollow" aria-label="LinkedIn">
                                            <i class="fab fa-fw fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    HTML
                                    :
                                    ""
                                !!}



                                  {!!
$team->github ?
<<<HTML
<li class="list-inline-item">
    <a class="btn px-2 btn-sm bg-linkedin" href="$team->github" target="_blank" rel="noopener nofollow" aria-label="LinkedIn">
        <i class="fab fa-fw fa-linkedin-in"></i>
    </a>
</li>
HTML
:
""
!!}

                                  {!!
$team->telegram ?
<<<HTML
<li class="list-inline-item">
    <a class="btn px-2 btn-sm bg-linkedin" href="$team->telegram" target="_blank" rel="noopener nofollow" aria-label="LinkedIn">
        <i class="fab fa-fw fa-linkedin-in"></i>
    </a>
</li>
HTML
:
""
!!}




                                </ul>
                            </div>
                        </div>
                        @endforeach
                                  </div>
                </div>
                <!-- Slider END -->

            </div>
        </section>

    </main>
@endsection
