<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserRoles;
use App\Models\User;
use App\Models\Menu\Menu;
use App\Models\Menu\Category;
use App\Models\Menu\Modifier;
use App\Models\Menu\ModifierGroup;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Models\Location\OrderTypes;
use App\Models\Pos\Order;


class PosController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public $tabList;

    function __construct() {
        $this->middleware('auth');
        $this->tabList['tab'] = Helper::$menutab;
        $this->tabList['selected'] = 'item';
    }


    public function getIndex(Request $request) {

        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('menu_view', $request)) !== true) {
              return redirect()->action($return);
        }
        /* end permission code */
        
       // dd($request->session()->get('order_type'));
       // dd($request->session()->get('store'));
       $customer=$request->session()->get('customer');
        $ordTypes=OrderTypes::getOrderTypesByStoreId($customer['store_id']);
        $return = view('pos.pos', ['tabList' => $this->tabList,'orderTypes'=>$ordTypes]);
        
        return $return;
    }
    
    public function getPosData($id){
        return response()->json(["response" => 200, 'status' => 'success', "data" => Order::getPosDatafromStoreId($id)]);
    }
    
    public static function getData($id){
        $data='{"brands":[{"_id":"5b74d60071add83ce935a242","name":"NKDPizza","logo":"brand-nkd_5b753644c541b.png"},{"_id":"5b75367d71add848e5534dd2","name":"Right Bite","logo":"brand-right-bite_5b75367d1d782.png"},{"_id":"5b75369471add848c85d5f72","name":"Tawook","logo":"brand-tawook_5b7536946343a.png"},{"_id":"5b7536a371add848de4db302","name":"Bunfire","logo":"brand-bunfire_5b7536a3a7230.png"},{"_id":"5b7536c171add848e5534dd3","name":"Jack\'s Place","logo":"brand-jacks_5b7536c133c2c.png"}],"category":{"5b74d60071add83ce935a242":[{"_id":"5b6b088871add84de815bc52","parent":[],"name":"Pizzas","description":"Pizzas"},{"_id":"5b6b08ac71add87f42707f92","parent":[],"name":"Salads","description":"Salads"},{"_id":"5b6bc50271add8223609e892","parent":[],"name":"Sides","description":"Sides"},{"_id":"5b73e17c71add827443a5db2","parent":[],"name":"Deserts","description":"Deserts"},{"_id":"5b73e18f71add825f4758342","parent":[],"name":"Beverages","description":"Beverages"},{"_id":"5b73e1a771add8295a315442","parent":[{"_id":"5b6b088871add84de815bc52","name":"Pizzas"}],"name":"From the Farm","description":"From the Farm"},{"_id":"5b73e1b871add829f65f2cb2","parent":[{"_id":"5b6b088871add84de815bc52","name":"Pizzas"}],"name":"From the Field","description":"From the Field"}],"5b75367d71add848e5534dd2":[{"_id":"5b6b088871add84de815bc52","parent":[],"name":"Pizzas","description":"Pizzas"},{"_id":"5b6b08ac71add87f42707f92","parent":[],"name":"Salads","description":"Salads"},{"_id":"5b73e17c71add827443a5db2","parent":[],"name":"Deserts","description":"Deserts"},{"_id":"5b73e18f71add825f4758342","parent":[],"name":"Beverages","description":"Beverages"},{"_id":"5b758db371add855d7360792","parent":[],"name":"Soups","description":"Soups"},{"_id":"5b758dcb71add8561723de62","parent":[],"name":"Starters & sides","description":"Starters & sides"},{"_id":"5b758ddb71add8564d08a7e2","parent":[],"name":"Protein pots","description":"Protein pots"},{"_id":"5b758de971add856501616e2","parent":[],"name":"Sandwiches & wraps","description":"Sandwiches & wraps"},{"_id":"5b758dfe71add8561723de63","parent":[],"name":"Burgers","description":"Burgers"},{"_id":"5b758e1171add855d7360793","parent":[],"name":"Mains","description":"Mains"},{"_id":"5b758e2071add8564d08a7e3","parent":[],"name":"Skinny Delites (Desserts)","description":"Skinny Delites (Desserts)"},{"_id":"5b758e2b71add855db57e3f2","parent":[],"name":"Fresh Juices & Smoothies","description":"Fresh Juices & Smoothies"}],"5b75369471add848c85d5f72":[{"_id":"5b6b08ac71add87f42707f92","parent":[],"name":"Salads","description":"Salads"},{"_id":"5b73e17c71add827443a5db2","parent":[],"name":"Deserts","description":"Deserts"},{"_id":"5b73e18f71add825f4758342","parent":[],"name":"Beverages","description":"Beverages"}],"5b7536a371add848de4db302":[{"_id":"5b73e17c71add827443a5db2","parent":[],"name":"Deserts","description":"Deserts"},{"_id":"5b73e18f71add825f4758342","parent":[],"name":"Beverages","description":"Beverages"}],"5b7536c171add848e5534dd3":[{"_id":"5b6bc50271add8223609e892","parent":[],"name":"Sides","description":"Sides"},{"_id":"5b73e17c71add827443a5db2","parent":[],"name":"Deserts","description":"Deserts"},{"_id":"5b73e18f71add825f4758342","parent":[],"name":"Beverages","description":"Beverages"}]},"items":{"5b6b088871add84de815bc52":[{"_id":"5b74f46d71add83e9c3e9ce5","image":"dubai-pizza-large-asada_5b74f46d31f5c.png","thumb_image":"dubai-pizza-thumb-asado_5b74f46d31fde.png","name":"Asado Beef","plu_code":"300","price_title":"54","price":"54","tax":"Inclusive","groups":["Protein","Vegan","Hot","Gluten-Free"],"seo_title":"Asado Beef","short_description":"bbq sauce, red onion, beef bacon, red bell pepper","category":[{"_id":"5b6b088871add84de815bc52","name":"Pizzas"}],"sub_category":[{"_id":"5b73e1b871add829f65f2cb2","name":"From the Field"}],"included_modifier_groups":[{"_id":"5b74f02771add83f7102dc44","name":"select your size"},{"_id":"5b74ede871add83ea46ab223","name":"choose your crust"},{"_id":"5b74f2a071add83fe4382ea2","name":"topping from the field"},{"_id":"5b74f24d71add83fbe3bf282","name":"topping from the farm"}],"included_modifiers":[{"_id":"5b74ecae71add83e9c3e9ce4","name":"Large"}],"modifier_groups":[{"_id":"5b74ede871add83ea46ab223","name":"choose your crust"}],"modifiers":[{"_id":"5b74ed4271add83ef8030ee2","name":"Original Crust"}],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:17:40","created_at":"2018-08-16 03:50:05"}],"5b6b08ac71add87f42707f92":[{"_id":"5b7597f571add856b8155d72","image":"arugula-salad_5b7597f502c47.jpg","thumb_image":"arugula-salad_5b7597f502cc9.jpg","name":"Arugula Salad","plu_code":"234","price_title":"AED32.00","price":"32","tax":"Inclusive","groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b6b08ac71add87f42707f92","name":"Salads"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:35:50","created_at":"2018-08-16 15:27:49"},{"_id":"5b75982b71add856a5036bb3","image":"peri-peri-chicken-salad_5b75982ba6a54.jpg","thumb_image":"peri-peri-chicken-salad_5b75982ba6adc.jpg","name":"Peri-Peri Chicken Salad","plu_code":"123","price_title":"AED36.00","price":"36","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b6b08ac71add87f42707f92","name":"Salads"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:35:49","created_at":"2018-08-16 15:28:43"}],"5b758db371add855d7360792":[{"_id":"5b758f0e71add8564d08a7e4","image":"lentil_5b758f0e05bd8.png","thumb_image":"lentil_5b758f0e05c5b.png","name":"Lentil Soup","plu_code":"1020","price_title":"AED17.00","price":"17","tax":"Inclusive","groups":["Vegan","Hot","Gluten-Free"],"seo_title":null,"short_description":"Lightly spiced red lentils simmered with carrots and leeks","category":[{"_id":"5b758db371add855d7360792","name":"Soups"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:17:44","created_at":"2018-08-16 14:49:50"},{"_id":"5b758f6971add855665a27f2","image":"mushroom-soup_5b758f69e3d1e.png","thumb_image":"mushroom-soup_5b758f69e3da8.png","name":"Creamy mushroom soup","plu_code":"2020","price_title":"AED17.00","price":"17","tax":"Inclusive","groups":["Protein","Vegan","Gluten-Free"],"seo_title":"Creamy mushroom soup","short_description":"Creamy mushroom soup","category":[{"_id":"5b758db371add855d7360792","name":"Soups"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:17:37","created_at":"2018-08-16 14:51:21"},{"_id":"5b758fb671add855905eeec2","image":"chicken-oats-soup_5b758fb62694b.jpg","thumb_image":"chicken-oats-soup_5b758fb6269cf.jpg","name":"Chicken & Oats Soup","plu_code":"1212","price_title":"AED17.00","price":"17","tax":"Inclusive","groups":null,"seo_title":"Chicken & Oats Soup","short_description":"Fresh spring veggies, all white shredded chicken breasts and a spoonful of oats, slowly simmered and delicately spiced.","category":[{"_id":"5b758db371add855d7360792","name":"Soups"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:17:34","created_at":"2018-08-16 14:52:38"}],"5b758dcb71add8561723de62":[{"_id":"5b7590fa71add8557567d6b2","image":"summer-rolls_5b7590fa98331.jpg","thumb_image":"summer-rolls_5b7590fa983b7.jpg","name":"Summer rolls","plu_code":"343","price_title":"AED16.00","price":"16","tax":"Inclusive","groups":null,"seo_title":"Summer rolls","short_description":"Summer rolls","category":[{"_id":"5b758dcb71add8561723de62","name":"Starters & sides"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:17:34","created_at":"2018-08-16 14:58:02"},{"_id":"5b75913d71add856501616e3","image":"roasted-potato-chips_5b75913db8145.jpg","thumb_image":"roasted-potato-chips_5b75913db81c8.jpg","name":"Roasted Potato Chips","plu_code":"4353","price_title":"AED15.00","price":"15","tax":"Inclusive","groups":null,"seo_title":"Roasted Potato Chips","short_description":"Skin on, hand cut and oven roasted.","category":[{"_id":"5b758dcb71add8561723de62","name":"Starters & sides"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:17:32","created_at":"2018-08-16 14:59:09"},{"_id":"5b75918671add856a5036bb2","image":"sweet-potato_5b7591866db09.jpg","thumb_image":"sweet-potato_5b7591866db8c.jpg","name":"Sweet Potato Wedges","plu_code":"3424","price_title":"AED15.00","price":"15","tax":null,"groups":null,"seo_title":"Sweet Potato Wedges","short_description":"Oven Roasted sweet potato wedges","category":[{"_id":"5b758dcb71add8561723de62","name":"Starters & sides"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:17:31","created_at":"2018-08-16 15:00:22"},{"_id":"5b7591b671add855db57e3f3","image":"stir-fried-broccoli-web_5b7591b698a41.jpg","thumb_image":"stir-fried-broccoli-web_5b7591b698aca.jpg","name":"Cajun broccoli and baby carrots","plu_code":"3242","price_title":"AED15.00","price":"15","tax":null,"groups":null,"seo_title":"Cajun broccoli and baby carrots","short_description":"Cajun broccoli and baby carrots","category":[{"_id":"5b758dcb71add8561723de62","name":"Starters & sides"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:17:28","created_at":"2018-08-16 15:01:10"},{"_id":"5b7591f071add856aa683272","image":"beetroot-hummos-and-crudites_5b7591f0efbdc.jpg","thumb_image":"beetroot-hummos-and-crudites_5b7591f0efc61.jpg","name":"Beetroot hummos and crudites","plu_code":"65464","price_title":"AED15.00","price":"15","tax":"Inclusive","groups":null,"seo_title":"Beetroot hummos and crudites","short_description":"Supercharged hummos served with crispy veggies made for double dipping!","category":[{"_id":"5b758dcb71add8561723de62","name":"Starters & sides"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:17:26","created_at":"2018-08-16 15:02:08"}],"5b758ddb71add8564d08a7e2":[{"_id":"5b75960071add85731533852","image":"kale-and-chicken-protein-pot-on-board-web_5b759600a058b.jpg","thumb_image":"kale-and-chicken-protein-pot-on-board-web_5b759600a0613.jpg","name":"Kale & Chicken","plu_code":"23","price_title":"AED19.00","price":"19","tax":"Inclusive","groups":null,"seo_title":null,"short_description":"Zaatar marinated chicken breast with kale and almonds","category":[{"_id":"5b758ddb71add8564d08a7e2","name":"Protein pots"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:36:32","created_at":"2018-08-16 15:19:28"},{"_id":"5b75963471add8573821d542","image":"lentil-and-chickpea-web_5b759634328c0.jpg","thumb_image":"lentil-and-chickpea-web_5b75963432946.jpg","name":"Lentil & Chickpea","plu_code":"243","price_title":"AED19.00","price":"19","tax":"Inclusive","groups":null,"seo_title":"Lentil & Chickpea","short_description":"Simmered lentils and chickpeas, with cherry tomatoes, diced carrots and crumbled feta","category":[{"_id":"5b758ddb71add8564d08a7e2","name":"Protein pots"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:36:28","created_at":"2018-08-16 15:20:20"}],"5b758de971add856501616e2":[{"_id":"5b75968471add856501616e4","image":"tandoori-chicken-wrap_5b759684d18b1.jpg","thumb_image":"tandoori-chicken-wrap_5b759684d1938.jpg","name":"Tandoori Chicken Wrap","plu_code":"343","price_title":"AED30.00","price":"30","tax":"Inclusive","groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758de971add856501616e2","name":"Sandwiches & wraps"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:36:23","created_at":"2018-08-16 15:21:40"},{"_id":"5b7596a571add85731533853","image":"vegetarian-texan_5b7596a5ee02d.jpg","thumb_image":"vegetarian-texan_5b7596a5ee0af.jpg","name":"The Vegetarian Texan","plu_code":"232","price_title":"AED27.00","price":"27","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758de971add856501616e2","name":"Sandwiches & wraps"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:36:17","created_at":"2018-08-16 15:22:13"},{"_id":"5b7596cc71add856bc248262","image":"chicken-moussakhan_5b7596cccc779.jpg","thumb_image":"chicken-moussakhan_5b7596cccc7ee.jpg","name":"Chicken Moussakhan","plu_code":"233","price_title":"AED28.00","price":"28","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758de971add856501616e2","name":"Sandwiches & wraps"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:36:13","created_at":"2018-08-16 15:22:52"},{"_id":"5b7596f271add856b95fefe2","image":"baked-falafel_5b7596f2c9837.jpg","thumb_image":"baked-falafel_5b7596f2c98ba.jpg","name":"Baked Falafel","plu_code":"234","price_title":"AED27.00","price":"27","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758de971add856501616e2","name":"Sandwiches & wraps"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:36:09","created_at":"2018-08-16 15:23:30"},{"_id":"5b75971d71add856ad258312","image":"chicken-quesadilla-web_5b75971d6fc6b.jpg","thumb_image":"chicken-quesadilla-web_5b75971d6fcf4.jpg","name":"Chicken Fajita Quesadillas","plu_code":"3453","price_title":"AED30.00","price":"30","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758de971add856501616e2","name":"Sandwiches & wraps"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:36:05","created_at":"2018-08-16 15:24:13"},{"_id":"5b75975071add856b95fefe3","image":"meat-shawarma-1_5b7597500496c.jpg","thumb_image":"meat-shawarma-1_5b759750049f0.jpg","name":"Lean And Mean Beef Shawarma","plu_code":"6465","price_title":"AED30.00","price":"30","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758de971add856501616e2","name":"Sandwiches & wraps"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:35:59","created_at":"2018-08-16 15:25:04"},{"_id":"5b75979571add8573a17d072","image":"steak-and-cheese-baguette_5b7597950d647.jpg","thumb_image":"steak-and-cheese-baguette_5b7597950d6cb.jpg","name":"Philly Cheese-Steak Sandwich","plu_code":"345","price_title":"AED32.00","price":"32","tax":"Inclusive","groups":null,"seo_title":null,"short_description":"Philly Cheese-Steak Sandwich","category":[{"_id":"5b758de971add856501616e2","name":"Sandwiches & wraps"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:35:54","created_at":"2018-08-16 15:26:13"}],"5b758dfe71add8561723de63":[{"_id":"5b75986171add8573c5fb022","image":"classic-burger_5b7598617ed91.jpg","thumb_image":"classic-burger_5b7598617ee14.jpg","name":"Classic Burger","plu_code":"353","price_title":"AED32.00","price":"32","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758dfe71add8561723de63","name":"Burgers"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:35:46","created_at":"2018-08-16 15:29:37"},{"_id":"5b75988b71add856b95fefe4","image":"chicken-burger_5b75988ba5062.jpg","thumb_image":"chicken-burger_5b75988ba50e3.jpg","name":"Chicken Burger","plu_code":"232","price_title":"AED32.00","price":"32","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758dfe71add8561723de63","name":"Burgers"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:35:44","created_at":"2018-08-16 15:30:19"}],"5b758e1171add855d7360793":[{"_id":"5b7598bf71add85731533854","image":"chilly-coconut-chicken_5b7598bfcab51.jpg","thumb_image":"chilly-coconut-chicken_5b7598bfcabd6.jpg","name":"Chilly Coconut Chicken","plu_code":"4232","price_title":"AED42.00","price":"42","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758e1171add855d7360793","name":"Mains"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:35:39","created_at":"2018-08-16 15:31:11"},{"_id":"5b75990271add856b95fefe5","image":"shrimp-pesto-alio_5b759902ba959.jpg","thumb_image":"shrimp-pesto-alio_5b759902ba9da.jpg","name":"Basil Shrimp Aglio Olio","plu_code":"234","price_title":"AED44.00","price":"44","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758e1171add855d7360793","name":"Mains"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:35:37","created_at":"2018-08-16 15:32:18"}],"5b758e2071add8564d08a7e3":[{"_id":"5b75993b71add85751614322","image":"rocky-road-3_5b75993b2d8db.jpg","thumb_image":"rocky-road-3_5b75993b2d960.jpg","name":"Rocky Road","plu_code":"3443","price_title":"AED17.00","price":"17","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758e2071add8564d08a7e3","name":"Skinny Delites (Desserts)"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:35:36","created_at":"2018-08-16 15:33:15"},{"_id":"5b75996671add85759195b92","image":"choco-cheesecake-web_5b759966122b0.jpg","thumb_image":"choco-cheesecake-web_5b75996612333.jpg","name":"Chocolate Cheesecake","plu_code":"3454","price_title":"AED21.00","price":"21","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758e2071add8564d08a7e3","name":"Skinny Delites (Desserts)"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:35:34","created_at":"2018-08-16 15:33:58"}],"5b758e2b71add855db57e3f2":[{"_id":"5b75999871add856a5036bb4","image":"orange_5b759998999c8.jpg","thumb_image":"orange_5b75999899a47.jpg","name":"Fresh Orange Juice","plu_code":"454","price_title":"AED19.00","price":"19","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758e2b71add855db57e3f2","name":"Fresh Juices & Smoothies"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:35:33","created_at":"2018-08-16 15:34:48"},{"_id":"5b7599bf71add8574911c352","image":"lemon-mint_5b7599bf984df.jpg","thumb_image":"lemon-mint_5b7599bf98561.jpg","name":"Lemonade & Mint","plu_code":"645","price_title":"AED16.00","price":"16","tax":null,"groups":null,"seo_title":null,"short_description":null,"category":[{"_id":"5b758e2b71add855db57e3f2","name":"Fresh Juices & Smoothies"}],"sub_category":[],"included_modifier_groups":[],"included_modifiers":[],"modifier_groups":[],"modifiers":[],"created_by":"5b6362e971add816b63336e2","updated_by":"5b6362e971add816b63336e2","status":"enable","updated_at":"2018-08-16 15:35:31","created_at":"2018-08-16 15:35:27"}]},"modifer":[]}';
      
        return response()->json(["response" => 200, 'status' => 'success', "data" => json_decode($data)]);
        die;
    }
    
    public function addOrder(Request $request){
        $customer=$request->session()->get('customer');
        $data=$request->input('data');
        //echo '<pre>';
        //print_r($data);die;
        if($data){
           $order=new Order();
           $order->store_id=$request->input('data.store_id');
           $order->cart_items=$request->input('data.cart_items');
           $order->sub_cart_total=$request->input('data.sub_cart_total');
           $order->total_pay=$request->input('data.total_pay');
           $order->discount=$request->input('data.discount');
           $order->shipping=$request->input('data.shipping');
           $order->order_status='In Kitchen';
           $order->customer=$customer;
        if ($order->save()){
                $request->session()->forget('customer');
                $request->session()->forget('store');
                $request->session()->forget('order_type');
               return response()->json(["response" => 200, 'status' => 'success', "action" =>'/pos']);
            }else{
                return response()->json(["response" => 400, 'status' => 'error', "errors" => ['An internal error.']]);
            }
        }
        die;
    }
}
