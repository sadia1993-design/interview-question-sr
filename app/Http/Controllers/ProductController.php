<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::with('productVariants', 'ProductVariantPrices')->paginate(2);

        $variants = Variant::join('product_variants', 'product_variants.variant_id', 'variants.id')
                        ->select('variants.title', 'product_variants.variant', 'variants.id')
                        ->distinct('product_variants.variant')
                        ->get();


        $variant_label = [];

        foreach ($variants as $key => $value) {
            $variant_label[$value->title][] = $value->variant;
        }


        $label = $variant_label;


        // dd($label);

        return view('products.index', compact('products', 'variants', 'label'));
    }

    public function search(Request $request){

         $title = ucwords($request->title);
         $titleProduct = Product::where('title', 'like', '%'. $title. '%')->get();

         return view('products.search', compact('titleProduct'));


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // echo "<pre>";
        //  print_r($request->all());
        //  exit;
       $product = Product::create($request->all());

       $data = [];
       $i =0;
       foreach ($request->product_variant as $key => $value) {
          foreach( $value['tags'] as $tag_key=> $tag_value){
              $data[$i]['variant']  = $tag_value;
              $data[$i]['variant_id']  = $value['option'];
              $data[$i]['product_id']  = $product->id;
              $data[$i]['created_at']  = date('Y-m-d h:s:i');
              $data[$i]['updated_at']  = date('Y-m-d h:s:i');

              $i++;
          }
       }

      $productVariance=  ProductVariant::insert($data);

    //   ProductVariantPrice
        //  echo "<pre>";
        //  print_r($request->all());
        //  exit;


    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {

        $variantArr = Variant::join('product_variants', 'product_variants.variant_id', 'variants.id')
                ->select('variants.title', 'product_variants.variant', 'variants.id')
                ->where('product_variants.product_id', $id)
                ->distinct('product_variants.variant')
                ->get();

        $variantListArr = array();
        foreach ($variantArr as $variant) {
            $variantListArr[$variant->id][] = $variant->variant;
        }

        $variants = Variant::pluck('title', 'id')->toArray();


        // get product Query
        $targetArr = Product::select('products.*', 'product_images.file_path')
                ->leftJoin('product_images', 'product_images.product_id', 'products.id')
                ->where('products.id', $id)
                ->first();


        $previewArr = Product::select('products.*');
        $previewArr = $previewArr->with(['ProductVariantPrices' => function($q) {
                $q->join('products', 'products.id', 'product_variant_prices.product_id');
                $q->leftJoin('product_variants as one', 'one.id', 'product_variant_prices.product_variant_one');
                $q->leftJoin('product_variants as two', 'two.id', 'product_variant_prices.product_variant_two');
                $q->leftJoin('product_variants as three', 'three.id', 'product_variant_prices.product_variant_three');
                $q = $q->select('product_variant_prices.*', 'one.variant as one_variant', 'two.variant as two_variant'
                        , 'three.variant as three_variant');
            }
        ]);
        $previewArr = $previewArr->where('products.id', $id)->first();

        return view('products.edit', compact('variants', 'targetArr', 'variantListArr', 'variants','previewArr'));
    }


    public function update(Request $request, $id){
        $product = Product::find($id);
        $input = $request->all();

        dd($product);
    }
}
