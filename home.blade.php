 @extends('layouts.master')
@section('title')
    <title>{{ $settings->company_name }} | Home</title>
@show
@section('content')
        <!-- WRAPPER -->
        <div id="wrapper">
        @if(!$slides == 0)
            <div class='fullwidthbanner-container'>
                <div class='fullwidthbanner'>
                    <ul>
                        <!-- SLIDES  -->
                          {{$slides}}
                    </ul>
                    <div class='tp-bannertimer'></div>
                </div>
            </div>

        @else
            <!-- REVOLUTION SLIDER -->
            <div class='fullwidthbanner-container roundedcorners'>
                <div class='fullwidthbanner'>
                       <ul>
                        <!-- SLIDE  -->
                        <li data-transition='3dcurtain-vertical' data-slotamount='15' data-masterspeed='300' data-delay='9400'>

                            <!-- COVER IMAGE -->
                            <img src='assets/images/demo/revolution_slider/sliderbg.jpg' alt='' data-bgfit='cover' data-bgposition='left top' data-bgrepeat='no-repeat'>

                            <div class='tp-caption large_bold_grey lfl stl'
                                data-x='18'
                                data-y='233'
                                data-speed='300'
                                data-start='500'
                                data-easing='easeOutExpo' data-end='8800' data-endspeed='300' data-endeasing='easeInSine'>STOCK POP SHOP
                            </div>
                        </li>
                    </ul>
                    <div class='tp-bannertimer'></div>
                </div>
            </div>
            <!-- /REVOLUTION SLIDER -->
        @endif
            <section class="container text-center">
                <h1 class="text-center">
                    <strong>Welcome</strong> to {{ $settings->company_name }}
                </h1>
            </section>
            <section class='container'>
                <h2>
                   <strong>Latest</strong> Products
                </h2>
            </section>


            <div id="shop">

                <section class="container">


                    <div class="row">


                        <div class="row">
                            <div class="owl-carousel" data-plugin-options='{"autoPlay":3500,"items": 3,
                                                                            "singleItem": false, "navigation": false,
                                                                            "pagination": true,
                                                                            "stopOnHover":true
                                                                            }' >

                             @foreach($products as $product)
                                <?php

                                    $file = ImgProxy::link($product[0]->file, 640, 480,100,2);

                                ?>

                                <!-- item -->
                                <div class="item-box">
                                    <figure>
                                        <a class="item-hover" href="products/profile/{{$product[0]->id}}">
                                            <span class="overlay color2"></span>
                                            <span class="inner">
                                                <span class="block fa fa-plus fsize20"></span>
                                                <strong>PRODUCT</strong> DETAIL
                                            </span>
                                        </a>
                                        <img class="img_small" src="{{$file}}" alt="">
                                    </figure>
                                    <div class="item-box-desc" style='height:70px' align='center'>
                                        <h4>{{$product[0]->name}}</h4>
                                    </div>


                                </div>


                             @endforeach

                            </div>
                        </div>
                    </div>

                </section>

            </div>


        </div>
        <!-- /WRAPPER -->


@stop
