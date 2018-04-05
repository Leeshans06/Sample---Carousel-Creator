<?php

class CarouselController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
       // Get All Active Slides + Active Layers
       $slides              = Slides::where('active', '=', 1)->get();
       $count               = 1;
       $listing             = "";
       $carousel_html       = "
                              ";
       $carousel_slides     = "";
       foreach($slides as $slide){
            $size             = ( file_exists(public_path()."/".$slide->file))
                                ? getimagesize(public_path()."/".$slide->file)
                                : array("1"=>"0","0" => "0");
            $attributes       = json_decode($slide->attributes);
            $speed            = $attributes->speed * 1000;
            $carousel_slides .= "<li
                                      data-transition='{$attributes->transition}'
                                      data-slotamount='{$attributes->slots}'
                                      data-masterspeed='{$speed}'
                                       style='background-color: {$attributes->bg_color}'>
                                      <!-- MAIN IMAGE -->
                                      <img src='/{$slide->file}'
                                           alt='slidebg1'
                                           data-bgfit='{$attributes->bg_fit}'
                                           data-bgrepeat='{$attributes->bg_repeat}'
                                      />

                                </li>";

            $listing         .= "<div class='row'>
                                    <div class='col-md-3 text-center'><br>
                                        <img alt='' class='img-responsive img-thumbnail' src='/{$slide->file}' /><br>
                                         <p>
                                            {$size[1]} x {$size[0]}
                                        </p>
                                    </div>
                                    <div class='col-md-9'>
                                         <h3><a
                                               href='carouselEditor/add-slide/{$slide->id}'>
                                               Slide #{$count}
                                             </a>
                                         </h3>
                                         <p>
                                          <span class='glyphicon glyphicon-cog'></span>
                                            <strong>Transition :</strong> {$attributes->transname}<br>
                                          <span class='glyphicon glyphicon-dashboard'></span>
                                            <strong>Transition Speed :</strong> {$attributes->speed}s<br>
                                          <span class='glyphicon glyphicon-stats' ></span>
                                            <strong>Slot Count :</strong> {$attributes->slots}<br>
                                          <span class='glyphicon glyphicon-fullscreen'></span>
                                            <strong>Size :</strong> ".ucfirst($attributes->bg_fit)."
                                            - {$attributes->bg_repeat}<br>
                                            </p>
                                        <p class='pull-right'>
                                        <a href='javascript:void(0)' onclick='confirm_delete({$slide->id})'>
                                          <span class='glyphicon glyphicon-trash' ></span>
                                        </a>
                                        </p>
                                    </div>
                                 </div><hr>";
            $count++;
       }
      return View::make('admin.carousel.carouselEditor',array('slide_listing'    => $listing,
                                                              'carousel_slides' => $carousel_slides));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAddSlide($id)
    {
         $defaults          = json_decode(json_encode(array("transition" => 'fade',
                                                             "slots"     => 10,
                                                             "speed"     => 0.7,
                                                             "bg_color"  => '#FFFFF',
                                                             "bg_fit"    => 'cover',
                                                             "bg_repeat" => 'no-repeat'
                                                            )
                                                     )
                                         );
         if($id > 0){
            $slide          = Slides::find($id);
            $attributes     = json_decode($slide->attributes);
            $bg_fit         = ($attributes->bg_repeat == 'repeat')? 'containr' : $attributes->bg_fit;
            $size           = $this->sizeDropdown($bg_fit);
         }
         else{
            $slide          = new Slides();
            $attributes     = $defaults;
            $size           = 0;
         }
        return View::make('admin.carousel.AddSlide',array('slide'      => $slide,
                                                          'attributes' => $attributes,
                                                          'size'       => $size
                                                         )
                         );
    }

    public function sizeDropdown($current = '')
    {
        $options           = array('contain'=>'Contain',
                                   'cover'  =>'Cover',
                                   'containr'=>'Contain + Repeat'
                                  );
        $values            = "";
        foreach($options  as $key => $value){
            if($current   == $key){
                $values   .= "<option selected value='{$key}'>$value</option>";
            }
            else{
                $values   .= "<option value='{$key}'>$value</option>";
            }
        }
        return "<select id='carousel_bgfit' class='selectpicker show-tick form-control'>
                    {$values}
                </select>";
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreateSlide()
    {
        $slide              = Input::get('id');//var_dump($slide);die;
        if($slide   != 0){
            // Store picture
            $slides         = Slides::find($slide);
        }
        else{
            # Create Slide
            $slides         = new Slides();
            $slides->active = 1;
            $slides->save();
        }

        return $slides->id;
    }
    public function postStoreImage()
    {
        $slide              = Input::get('slide_id');
        $files              = Input::file('file');
        $user_id            = Auth::id();

        # Store Uploaded Picture to Slide
        Log::info("Carousel Upload Image :".print_r($files));
        # Local
        $responce            = array();
        $slides              = Slides::find($slide);
        if($files) {
            $destinationPath = 'assets/images/carousel_images/';
            $filename        = str_replace(' ','',$files[0]->getClientOriginalName());
            $upload_success  = $files[0]->move(public_path()."/".$destinationPath,$filename);

            if ($upload_success) {
               // Image::make("public/".$destinationPath.$filename)->resize(1800,500)->save("public/".$destinationPath.$filename."test");
                // resizing an uploaded file
               // Image::make($destinationPath . $filename)->resize(1800, 500)->save("public/".$destinationPath . "100x100_" . $filename);

                // Store image Directory
                $slides->file                  = $destinationPath . $filename;
                $attributes['transition']      = 'fade';
                $attributes['slots']           = 10;
                $attributes['speed']           = 0.7;
                $attributes['bg_color']        = "#FFFFF";
                $attributes['transname']       = 'Fade';
                $attributes['bg_fit']          = 'cover';
                $attributes['bg_repeat']       = 'no-repeat';
                $attributes_serealized         = json_encode($attributes);
                $slides->attributes            = $attributes_serealized;
                $slides->created_by            = $user_id;
                // Add Created By + Updated BY
                $slides->save();
               return Response::json('success', 200);
            }
           else {
               return Response::json('error', 400);
            }
        }
    }
    public function postCarouselHtml()
    {
        $transition        = Input::get('transition');
        $speed             = Input::get('speed');
        $slots             = Input::get('slots');
        $bg_color          = Input::get('bg_color');
        $bg_fit            = Input::get('bg_fit');
        $bg_repeat         = Input::get('bg_repeat');
        $slide_id          = Input::get('slide_id');
        $slide             = Slides::find($slide_id);
        $speed             = $speed * 1000;

        $html              = " <div class='tp-banner-container'>
                                 <div class='tp-banner' style='background-color:{$bg_color}' >
                                        <ul>
                                        <!-- SLIDE  -->
                                            <li data-transition='{$transition}' data-slotamount='{$slots}' data-masterspeed='{$speed}' >
                                                <!-- MAIN IMAGE -->
                                                <img src='/{$slide->file}' alt='slidebg1' data-bgfit='{$bg_fit}' data-bgrepeat='{$bg_repeat}'>
                                                <div id='layers'>
                                                </div>
                                            </li>
                                        </ul>
                                            <div class='tp-bannertimer'></div>
                                    </div>
                                </div>";
        return $html;
    }
    public function postSlideUpdate()
    {
        $transition                    = Input::get('transition');
        $speed                         = Input::get('speed');
        $slots                         = Input::get('slots');
        $bg_color                      = Input::get('bg_color');
        $bg_fit                        = Input::get('bg_fit');
        $bg_repeat                     = Input::get('bg_repeat');
        $slide_id                      = Input::get('slide_id');
        $transname                     = Input::get('transname');
        $user_id                       = Auth::id();

        $attributes['transition']      = ($transition)? $transition :  'fade';
        $attributes['slots']           = ($slots) ? $slots : 10;
        $attributes['speed']           = ($speed) ? $speed * 0.001 : 0.7 ;
        $attributes['bg_color']        = ($bg_color) ? $bg_color : "#FFFFF";
        $attributes['transname']       = ($transname)? $transname : 'Fade';
        $attributes['bg_fit']          = ($bg_fit)? $bg_fit : 'cover';
        $attributes['bg_repeat']       = ($bg_repeat)? $bg_repeat : 'no-repeat';

        $attributes_serealized         = json_encode($attributes);
        //$unserealized                  = json_decode($attributes_serealized);
        //var_dump("unserealized : ".$unserealized->slots);die;
        $slide                         = Slides::find($slide_id);
        $slide->attributes             = $attributes_serealized;
        $slide->updated_by             = $user_id;
        $slide->save();

        return Response::json('success', 200);
    }
    public function postSlideDelete()
    {
        $slide_id                      = Input::get('slide_id');
        $slide                         = Slides::find($slide_id);

        # Log Entry
        Log::info("Deleting Slide #".$slide->id);
        Log::info("Removing Image : ".public_path()."/".$slide->file);

        # Remove Slide Image
        if (File::exists(public_path()."/".$slide->file)) {
            File::delete(public_path()."/".$slide->file);
        }

        # Remove record completely
        $slide->delete();

        return Response::json('success', 200);
    }
}
