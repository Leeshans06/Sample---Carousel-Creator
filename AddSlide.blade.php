@extends('layouts.admin')
@section('content')
        <!-- WRAPPER -->
    <div id="wrapper">

            <!-- PAGE TITLE -->
            <header id="page-title">

                  @if(!$slide->id)
                      <h1>Carousel Editor
                        <small>New Slide</small>
                      </h1>
                      <ol class="breadcrumb">
                          <li><a href="/admin/dashboard"><i class="fa fa-home"></i> Home</a></li>
                          <li><a href="/admin/carouselEditor">Carousel Editor</a></li>
                          <li class="active">New Slide</li>
                      </ol>
                  @else
                      <h1>Carousel Editor
                        <small>Edit Slide</small>
                      </h1>
                      <ol class="breadcrumb">
                          <li><a href="/admin/dashboard"><i class="fa fa-home"></i> Home</a></li>
                          <li><a href="/admin/carouselEditor">Carousel Editor</a></li>
                          <li class="active">Edit Slide</li>
                      </ol>
                  @endif

            </header>
            <div class='row'>
                <div class='col-md-12'>
                    @if(!$slide->file)
                     <div class='well'>
                        <strong><font color='red'>*</font> Only 1 Image Allowed Per Slide</strong>
                       <form action="/admin/carouselEditor/store-image"
                            method="POST"
                            id="carouselDropzone"
                            class="dropzone"
                            accept-charset="UTF-8"
                            enctype="multipart/form-data"
                            style='min-height:300px'
                            dzmessage='drop a file'>
                        @if($slide->id > 0)<input type='hidden' id='slide_id' name='slide_id' value='{{$slide->id}}'>
                        @else<input type='hidden' id='slide_id' name='slide_id' value='0'>
                        @endif
                        <div class="fallback">
                                <input name="file" type="file"/>
                        </div>
                      </form>
                    </div>
                    @else
                    <div id='carousel_div'>
                     <div class="tp-banner-container">
                       <div class="tp-banner">
                              <ul>
                              <!-- SLIDE  -->
                                  <li data-transition="{{$attributes->transition}}"
                                      data-slotamount="{{$attributes->slots}}"
                                      data-masterspeed="{{$attributes->speed * 1000}}"
                                      style='background-color: {{$attributes->bg_color}}'>
                                      <!-- MAIN IMAGE -->
                                      <img src="/{{$slide->file}}"
                                           alt="slidebg1"
                                           data-bgfit="{{$attributes->bg_fit}}"
                                           data-bgrepeat="{{$attributes->bg_repeat}}"
                                           style='background-color:{{$attributes->bg_color}}'
                                      />
                                      <div id='layers'>
                                          <!-- Use LAYERS For adding Custom text to carousel -->
                                      </div>
                                  </li>
                              </ul>
                                  <div class="tp-bannertimer"></div>
                        </div>
                    </div>
                  </div>
              </div>
           </div><br>
                      <div class="panel panel-primary">
                        <div class="panel-heading">
                          <h3 class="panel-title">Slide Setting</h3>
                        </div>
                        <div class="panel-body">
                            <input type='hidden' name='slide_id' value='{{$slide->id}}' id='slide_id'>
                            <article class="toolpad">
                              <!--<section class="tryme"></section>-->
                              <section class="tool first"
                                       id="transitselector"
                                       value='{{$attributes->transition}}'>
                                  <input type='hidden' id='transname' value="{{$attributes->transname}}" />
                                  <div class="tooltext norightcorner long"
                                       id="mranim"
                                       style="cursor:pointer">{{ucfirst($attributes->transition)}}</div>
                                  <div class="toolcontrols short">
                                    <div class="toolcontroll noleftcorner"><div class="glyphicon glyphicon-chevron-up centertop"></div><div class="icon-down-dir-1 centerbottom"></div></div>
                                  </div>
                                  <div class="transition-selectbox-holder">
                                    <div class="transition-selectbox">
                                    <ul style='padding-left:0px'>
                                      <li class="animchanger" data-anim="">Flat Fade Transitions</li>
                                      <li class="animchanger" data-anim="fade">Fade</li>
                                      <li class="animchanger" data-anim="boxfade">Fade Boxes</li>
                                      <li class="animchanger" data-anim="slotfade-horizontal">Fade Slots Horizontal</li>
                                      <li class="animchanger" data-anim="slotfade-vertical">Fade Slots Vertical</li>
                                      <li class="animchanger" data-anim="fadefromright">Fade and Slide from Right</li>
                                      <li class="animchanger" data-anim="fadefromleft">Fade and Slide from Left</li>
                                      <li class="animchanger" data-anim="fadefromtop">Fade and Slide from Top</li>
                                      <li class="animchanger" data-anim="fadefrombottom">Fade and Slide from Bottom</li>
                                      <li class="animchanger" data-anim="fadetoleftfadefromright">Fade To Left and Fade From Right</li>
                                      <li class="animchanger" data-anim="fadetorightfadetoleft">Fade To Right and Fade From Left</li>
                                      <li class="animchanger" data-anim="fadetobottomfadefromtop">Fade To Top and Fade From Bottom</li>
                                      <li class="animchanger" data-anim="fadetotopfadefrombottom">Fade To Bottom and Fade From Top</li>
                                    </ul>

                                    <ul style='padding-left:0px'>
                                      <li class="animchanger" data-anim="">Flat Zoom Transitions</li>
                                      <li class="animchanger" data-anim="scaledownfromright">Zoom Out and Fade From Right</li>
                                      <li class="animchanger" data-anim="scaledownfromleft">Zoom Out and Fade From Left</li>
                                      <li class="animchanger" data-anim="scaledownfromtop">Zoom Out and Fade From Top</li>
                                      <li class="animchanger" data-anim="scaledownfrombottom">Zoom Out and Fade From Bottom</li>
                                      <li class="animchanger" data-anim="zoomout">ZoomOut</li>
                                      <li class="animchanger" data-anim="zoomin">ZoomIn</li>
                                      <li class="animchanger" data-anim="slotzoom-horizontal">Zoom Slots Horizontal</li>
                                      <li class="animchanger" data-anim="slotzoom-vertical">Zoom Slots Vertical</li>
                                    </ul>

                                    <ul style='padding-left:0px'>
                                      <li class="animchanger" data-anim="">Flat Parallax Transitions</li>
                                      <li class="animchanger" data-anim="parallaxtoright">Parallax to Right</li>
                                      <li class="animchanger" data-anim="parallaxtoleft">Parallax to Left</li>
                                      <li class="animchanger" data-anim="parallaxtotop">Parallax to Top</li>
                                      <li class="animchanger" data-anim="parallaxtobottom">Parallax to Bottom</li>
                                    </ul>

                                    <ul style='padding-left:0px'>
                                      <li class="animchanger" data-anim="">Flat Slide Transitions</li>
                                      <li class="animchanger" data-anim="slideup">Slide To Top</li>
                                      <li class="animchanger" data-anim="slidedown">Slide To Bottom</li>
                                      <li class="animchanger" data-anim="slideright">Slide To Right</li>
                                      <li class="animchanger" data-anim="slideleft">Slide To Left</li>
                                      <li class="animchanger" data-anim="slidehorizontal">Slide Horizontal (depending on Next/Previous)</li>
                                      <li class="animchanger" data-anim="slidevertical">Slide Vertical (depending on Next/Previous)</li>
                                      <li class="animchanger" data-anim="boxslide">Slide Boxes</li>
                                      <li class="animchanger" data-anim="slotslide-horizontal">Slide Slots Horizontal</li>
                                      <li class="animchanger" data-anim="slotslide-vertical">Slide Slots Vertical</li>
                                      <li class="animchanger" data-anim="curtain-1">Curtain from Left</li>
                                      <li class="animchanger" data-anim="curtain-2">Curtain from Right</li>
                                      <li class="animchanger" data-anim="curtain-3">Curtain from Middle</li>
                                    </ul>

                                    <ul style='padding-left:0px'>
                                      <li class="animchanger" data-anim="">Premium Transitions</li>
                                      <li class="animchanger" data-anim="3dcurtain-horizontal">3D Curtain Horizontal</li>
                                      <li class="animchanger" data-anim="3dcurtain-vertical">3D Curtain Vertical</li>
                                      <li class="animchanger" data-anim="cubic">Cube Vertical</li>
                                      <li class="animchanger" data-anim="cubic-horizontal">Cube Horizontal</li>
                                      <li class="animchanger" data-anim="incube">In Cube Vertical</li>
                                      <li class="animchanger" data-anim="incube-horizontal">In Cube Horizontal</li>
                                      <li class="animchanger" data-anim="turnoff">TurnOff Horizontal</li>
                                      <li class="animchanger" data-anim="turnoff-vertical">TurnOff Vertical</li>
                                      <li class="animchanger" data-anim="papercut">Paper Cut</li>
                                      <li class="animchanger" data-anim="flyin">Fly In</li>
                                      <li class="animchanger" data-anim="random-static">Random Premium</li>
                                      <li class="animchanger" data-anim="random">Random Flat and Premium</li>
                                    </ul>
                                    </div>
                                  </div>
                                  <div class="clear"></div>
                              </section>
                             <section class="tool">
                                <div data-val="{{$attributes->speed * 1000}}" id="mrtime" class="tooltext">Time: {{$attributes->speed}}s</div>
                                <div class="toolcontrols">
                                  <div id="dectime" class="toolcontroll withspace"><i class="glyphicon glyphicon-minus"></i></div>
                                  <div id="inctime" class="toolcontroll withspace2"><i class="glyphicon glyphicon-plus"></i></div>
                                </div>
                                <div class="clear"></div>
                            </section>
                              <section class="tool last">
                                  <div data-val="{{$attributes->slots}}" class="tooltext" id="mrslot">Slots: {{$attributes->slots}}</div>
                                  <div class="toolcontrols">
                                    <div id="decslot" class="toolcontroll withspace"><i class="glyphicon glyphicon-minus"></i></div>
                                    <div id="incslot" class="toolcontroll withspace2"><i class="glyphicon glyphicon-plus"></i></div>
                                  </div>
                                  <div class="clear"></div>
                              </section>
                              <div class="clear"></div>
                              <!-- Color Picker -->
                              <div class="form-group">
                                  <label>BackGround Color</label>
                                      <!-- /.input group -->
                                  <div class="input-group demo2"  style='width:20%'>
                                      <input type="text" id='carousel_bgcolor' value='{{$attributes->bg_color}}' class="form-control" />
                                      <span class="input-group-addon"><i></i></span>
                                  </div>
                              </div>
                               <div class='row'>
                                  <div class='col-md-3'>
                                        {{$size}}
                                  </div>
                               </div><br>
                              <p class='pull-right'>
                                <input type='button' class='btn btn-default' value='Preview' onclick='updateCarousel()'>
                                <input type='button' class='btn btn-primary' value='Save' onclick='saveSlideSettings()'>
                              </p><br>
                            </article>
                        </div>
                      </div>

              @endif
    </div>
@stop
