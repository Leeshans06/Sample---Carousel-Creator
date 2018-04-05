<?php

class HomeController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |    Route::get('/', 'HomeController@showWelcome');
    |
    */

    public function __construct()
    {
        $this->beforeFilter(function()
        {

        });
    }

    public function getIndex()
    {
       # Get Carousel - All Active Slides + Active Layers
       $slides                = Slides::where('active', '=', 1)->get();
       $carousel_slides       = "";
       $carousel_html         = "";
       if(!is_null($slides)){
            Log::info("Slides Found Not Using Default");
            foreach($slides as $slide){
                $attributes       = json_decode($slide->attributes);
                $speed            = $attributes->speed * 1000;
                $carousel_slides .= "<li
                                          data-transition='{$attributes->transition}'
                                          data-slotamount='{$attributes->slots}'
                                          data-masterspeed='{$speed}'>
                                          <!-- MAIN IMAGE -->
                                          <img src='/{$slide->file}'
                                               alt='slidebg1'
                                               data-bgfit='{$attributes->bg_fit}'
                                               data-bgrepeat='{$attributes->bg_repeat}'
                                               style='background-color: {$attributes->bg_color}'
                                          />
                                    </li>";
            }
       }
       else{
            $carousel_slides        = 0;
            Log::info("Using Default Carousel");
       }
        # Get all Product Categories
        $categories  = DB::select( DB::raw('SELECT
                                                DISTINCT `id`
                                           FROM
                                                `categories`'
                                        )
                                  );
        $product_listing     = array();
        foreach($categories as $category){

          # Get lastest Product Added To Product + Image
          $product_query       = DB::select( DB::raw("SELECT
                                                      `products`.*,
                                                      (
                                                       SELECT
                                                          `file`
                                                       FROM
                                                          `product_images`
                                                       WHERE
                                                          `product_images`.`product_id` = `products`.`id`
                                                       ORDER BY
                                                          `order` ASC
                                                       LIMIT
                                                          1
                                                       ) as file
                                                   FROM
                                                      `products`
                                                   WHERE
                                                      `products`.`category_id` = '{$category->id}'
                                                   ORDER BY
                                                      `products`.`created_at` DESC
                                                   LIMIT
                                                        1"
                                              )
                                      );
          $product_listing[]   = $product_query;
        }

        # Convert Array to Object
        $product_data   = (object)$product_listing;

        if(!is_null($product_data))
        {
            return View::make('home')->with('products',$product_data)->with("slides",$carousel_slides);
        }
        else
        {
            $product_data = array();
            return View::make('home')->with('products',$product_data)->with("slides",$carousel_slides);
        }
      }
}
