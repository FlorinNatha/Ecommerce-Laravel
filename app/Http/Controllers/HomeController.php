<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;

use Session;
use Stripe;



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

        public function show_cart(){
            if(Auth::id()){   //user loged weld blanwa
                $id=Auth::user()->id;
                $cart=cart::where('user_id','=',$id)->get();
                return view('home.showcart',compact('cart'));
            }else{
                return redirect('login');
            }
            
        }

        public function remove_cart($id){
            $cart=cart::find($id);
            $cart->delete();
            return redirect()->back();
        }

        public function cash_order(){
            $user=Auth::user();  //loged wechcha user data gnnava $user variable ekata
            $userid=$user->id;
            $data = cart :: where('user_id', '=', $userid)->get(); //cart table eke user_id eke match wenwad balnwa userge id ekt
            
            foreach($data as $data){
                $order = new order;

                $order->name=$data->name; //mull name eka order table ekn 2weni name eka cart table ekn
                $order->email=$data->email;
                $order->phone=$data->phone;
                $order->address=$data->address;
                $order->user_id=$data->user_id;

                $order->product_title=$data->product_title;
                $order->price=$data->price;
                $order->quantity=$data->quantity;
                $order->image=$data->image;
                $order->product_id=$data->product_id;

                $order->payment_status='cash on delivery';
                $order->delivery_status='processing';

                $order->save();

                $cart_id=$data->id; //cart ekn id eka gnnwa
                $cart=cart::find($cart_id);
                $cart->delete();
            }
            return redirect()->back()->with('message','We have Received Your Order. We will connect with you soo');
        }


        public function stripe($totalprice){
            return view('home.stripe',compact('totalprice'));
        }


        public function stripePost(Request $request , $totalprice){
            
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            Stripe\Charge::create ([
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks for payment." 
            ]);


            $user=Auth::user();  //loged wechcha user data gnnava $user variable ekata
            $userid=$user->id;
            $data = cart :: where('user_id', '=', $userid)->get(); //cart table eke user_id eke match wenwad balnwa userge id ekt
            
            foreach($data as $data){
                $order = new order;

                $order->name=$data->name; //mull name eka order table ekn 2weni name eka cart table ekn
                $order->email=$data->email;
                $order->phone=$data->phone;
                $order->address=$data->address;
                $order->user_id=$data->user_id;

                $order->product_title=$data->product_title;
                $order->price=$data->price;
                $order->quantity=$data->quantity;
                $order->image=$data->image;
                $order->product_id=$data->product_id;

                $order->payment_status='Paid';
                $order->delivery_status='processing';

                $order->save();

                $cart_id=$data->id; //cart ekn id eka gnnwa
                $cart=cart::find($cart_id);
                $cart->delete();
            }


             Session::flash('success', 'Payment successful!');
            return back();
        }

       
}
