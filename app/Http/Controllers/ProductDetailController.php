<?php

namespace App\Http\Controllers;
use App\Models\ProductCompany;


use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productDetail = ProductDetail::all();
        $productCompany = ProductCompany::all();
       

        return view('my_product.all_product',compact('productDetail','productCompany'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'product_name' => 'required|unique:product_details|max:255',
          'productC' => 'required',
        ],[

            'product_name.required' =>'يرجي ادخال اسم المنتج',
            'product_name.unique' =>'هذه المنتج موجودة بالفعل',
            'productC.required' =>'يرجي الشركة المصنعة,'

        ],
       
    
    );



    ProductDetail::create([
            'product_name' => $request->product_name,
            'company_id' => $request->productC,
            'image_name' => $request->product_name,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/all_product');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductDetail  $productDetail
     * @return \Illuminate\Http\Response
     */
    public function show(ProductDetail $productDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductDetail  $productDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductDetail $productDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductDetail  $productDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductDetail $productDetail)
    {

       
        $validatedData = $request->validate([
            'product_name' => 'required|max:255|unique:product_details,product_name,'.$request->id,
          
        ],[

            'product_name.required' =>'يرجي ادخال اسم المنتج',
            'product_name.unique' =>'هذه المنتج موجودة بالفعل',
          

        ],
       
    
    );


        $id = ProductCompany::where('company_name', $request->company_name)->first()->id;

        $Products = ProductDetail::findOrFail($request->id);
 
        $Products->update([
        'product_name' => $request->product_name,
        'company_id' => $id,
        ]);
 
        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductDetail  $productDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        session()->flash('delete', 'لايمكن حذف هذه المنتجات ');
        return back();
    }
}
