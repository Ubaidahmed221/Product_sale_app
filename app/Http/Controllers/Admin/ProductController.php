<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(){
        try{
            //  $product = Product::with(['categories'])->paginate(5);
             $product = Product::with(['categories','productVariations.variationValue'])
             ->whereNull('deleted_at')
             ->paginate(5);

            return view('admin.products',compact('product'));
        }
        catch(\Exception $e){
            return abort(404,"Something Went Wrong");

        }
    }
    public function store(Request $request){
        try{
            $request->validate([
                'images' => 'required|array',
                'images.*' => 'file|mimes:jpg,png,jpeg|max:5048',
                'title' => 'required|string|max:255',
                'pkr_price' => 'required|numeric',
                'usd_price' => 'required|numeric',
                'stock' => 'required|numeric',
                'categories' => 'array',
                'variations' => 'array',
                'variations.*.variation_id' => 'required|integer|exists:variations,id',
                'variations.*.variation_value_ids' => 'array',
                'variations.*.variation_value_ids.*' => 'integer|exists:variation_values,id',
                'description' => 'nullable',
                'add_information' => 'nullable'               

            ]);
        $product =  Product::create(
                $request->only('title','pkr_price','usd_price','stock','description','add_information')
            );
            // for images store
            if($request->hasFile('images')){
                $imagePaths = [];
                foreach($request->file('images') as $image){
                    $imageName = time() . '_' . uniqid(). '.'. $image->getClientOriginalExtension();
                    $image->move(public_path('products'),$imageName);
                    $imagePaths[] = 'products/'. $imageName;

                }
                foreach($imagePaths as $path){
                    $product->images()->create(['path' => $path]);

                }
            }
            // for category store
            if(isset($request->categories)){
                $product->categories()->sync($request->categories);

            }
            // form variation store
            if($request->has('variations')){
                foreach($request->variations as $variations){
                    if(isset($variations['variation_value_ids'])){
                        foreach($variations['variation_value_ids'] as $valueId){
                            ProductVariation::create([
                                'product_id' => $product->id,
                                'variation_id' => $variations['variation_id'],
                                'variation_value_id' => $valueId,
                            ]);

                        }
                    }

                }

            }
            // Log::info($request->all());
          

            return response()->json([
                'success' => true,
                'msg' => 'Product created Successfully'
            ]);

        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
    public function productImages(Request $request){
        try{
          
       $data =  ProductImage::where('product_id',$request->id)->get()
            ->map(function($image){
                return [
                    'id'  => $image->id,
                    'url' => asset($image->path)
                ];
            });

            return response()->json([
                'success' => true,
                'msg' => 'Product Images',
                'data' => $data
            ]);

        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
    public function productImagesRemove(Request $request){
        try{
          
            $image = ProductImage::find($request->id);
            if($image){
                $filePath =  public_path($image->path);
                if( File::exists($filePath)){
                    File::delete($filePath);

                }else{
                    return response()->json([
                        'success' => false,
                        'msg' => ' File Not Found on the Server'
                    ]);

                }
                $image->delete();
                
                return response()->json([
                    'success' => true,
                    'msg' => 'Product Images remove Successfully'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'msg' => ' Images Not Found'
            ]);
        }
        
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
    public function update(Request $request){
        try{
            $request->validate([
                'id' => 'required',
                'images' => 'nullable|array',
                'images.*' => 'file|mimes:jpg,png,jpeg|max:5048',
                'title' => 'required|string|max:255',
                'pkr_price' => 'required|numeric',
                'usd_price' => 'required|numeric',
                'stock' => 'required|numeric',
                'categories' => 'array',
                'variations' => 'array',
                'variations.*.variation_id' => 'required|integer|exists:variations,id',
                'variations.*.variation_value_ids' => 'array',
                'variations.*.variation_value_ids.*' => 'integer|exists:variation_values,id',
                'description' => 'nullable',
                'add_information' => 'nullable'               

            ]);

            $product = Product::findOrFail($request->id);
        $product->update(
                $request->only('title','pkr_price','usd_price','stock','description','add_information')
            );
            // for images store
            if($request->hasFile('images')){
                $imagePaths = [];
                foreach($request->file('images') as $image){
                    $imageName = time() . '_' . uniqid(). '.'. $image->getClientOriginalExtension();
                    $image->move(public_path('products'),$imageName);
                    $imagePaths[] = 'products/'. $imageName;

                }
                foreach($imagePaths as $path){
                    $product->images()->create(['path' => $path]);

                }
            }
            // for category store
            if(isset($request->categories)){
                $product->categories()->sync($request->categories);

            }
            // form variation store
            if($request->has('variations')){
                foreach($request->variations as $variations){
                    if(isset($variations['variation_value_ids'])){
                        foreach($variations['variation_value_ids'] as $valueId){
                            ProductVariation::updateOrCreate([
                                'product_id' => $product->id,
                                'variation_id' => $variations['variation_id'],
                                'variation_value_id' => $valueId,
                            ]);

                        }
                    }

                }

            }
            // Log::info($request->all());
          

            return response()->json([
                'success' => true,
                'msg' => 'Product Update Successfully'
            ]);

        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
    public function destory(Request $request){
        try{
            $request->validate([
                'id' =>  'required'
            ]);
            Product::where('id',$request->id)->update([
                'deleted_at' => date('Y-m-d H:i:s')
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Product Delete Successfully'
            ]);

        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
    public function variationdestory(Request $request){
        try{
            $request->validate([
                'id' => 'required'
            ]);

           ProductVariation::where('id',$request->id)->delete();
     
            return response()->json([
                'success' => true,
                'msg' => 'Product Variation deleted Successfully'
            ]);

        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
    public function productInfo(Request $request){
        try{
            $request->validate([
                'id' =>  'required'
            ]);
         
            $data = Product::with(['categories','productVariations.variationValue'])
            ->whereNull('deleted_at')
            ->where('id',$request->id)
            ->first();

            return response()->json([
                'success' => true,
                'msg' => 'Product Information',
                'data' => $data
            ]);

        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }


}
