@extends('layouts.admin')
@section('content')
        <!-- WRAPPER -->
    <div id="wrapper">
        <div id='shop'>
            <!-- PAGE TITLE -->
          <header id="page-title">
          <h1>Carousel Editor
            <small>Listing</small>
          </h1>
          <ol class="breadcrumb">
              <li><a href="/admin/dashboard"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Carousel Editor</li>
          </ol>
          </header>
          <div class='row'>
             <div class='col-md-12  col-lg-12'>
               <div class='tp-banner-container'>
                    <div class='tp-banner'>
                        <ul>
                            <!-- SLIDES  -->
                            {{$carousel_slides}}
                        </ul>
                        <div class='tp-bannertimer'></div>
                    </div>
              </div>
            </div>
          </div>
          <hr>
          <section class="container">
                      <a href='/admin/carouselEditor/add-slide/0' class='btn btn-primary'>
                          <span class='glyphicon glyphicon-plus'></span>
                          Add Slide
                      </a><br><hr>
                      <table class="table table-hover">
                          {{$slide_listing}}
                      </table>
          </section>
        </div>
    </div>

     <!--Delete Price Modal -->
        <div class="modal fade" id='remove_slide'>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Remove Slide</h4>
              </div>
              <div class="modal-body">
                    <input  type="hidden" value="0" id='remove_slide_id'>
                    <br><strong>Are You Sure You Want To Remove This Slide And All Elements Attached?</strong>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick='delete_slide()'>Yes</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
@stop
