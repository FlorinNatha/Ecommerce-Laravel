<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

class HomeController extends Controller
{

       public function index()
       {
            $product = Product::paginate(3);
            return view('home.userpage', compact('product'));
       }


       public function redirect()
       {
            $usertype=Auth::user()->usertype;

            if($usertype=='1')
            {
                return view('admin.home');
            }

            else
            {
                //return view('home.userpage');
                $product = Product::paginate(3);
                return view('home.userpage', compact('product'));
            }
       } 

        public function product_details($id){
            $product=product::find($id);
            return view('home.product_details',compact('product'));
        }

        public function add_cart(Request $request, $id){
            if(Auth::id()){  //user loged welad check karnawa
                $user= Auth::user(); //userge data gannwa 
                $product = product::find($id);

                $cart = new cart;

                $cart->name=$user->name;
                $cart->email=$user->email;
                $cart->phone=$user->phone;
                $cart->address=$user->address;
                $cart->user_id=$user->id;  //'id' eka gaanne databese eke nama save wela tina eka 
                      //'user_id'  cart table ke dapu eka database eke
                
                $cart->product_title=$product->title;

                if($product->discount_price !=null){  //product eke discount price ekk tinwa nm,
                    $cart->price=$product->discount_price * $request->quantity;  // cart eke save wenne price ekat discount price eka
                }else{
                    $cart->price=$product->price * $request->quantity; // else cart eke save wenne product eke atta price eka
                }
                
                $cart->image =$product->image;
                $cart->product_id=$product->id;
                //$cart->quantity=$product->quantity;
                $cart->quantity=$request->quantity;  //'quantity' gththe product.blaade.php wala 'name' kiyala dapu thanin

                $cart->save();
                return redirect()->back();

            }else{
                return redirect('login');
            }
        }
}
