<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Mail;
use Session;

class ClientsController extends Controller
{
    /**
     * Function to display the index(products to be bought)
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var array $cartList */
        $cartList = Session::get('cart', []);

        $items = $cartList ? Product::query()->whereNotIn('id', $cartList)->get() : Product::all();

        return $request->isXmlHttpRequest() ? $items : view('client.index', compact('items'));
    }

    /**
     * Method used to redirect to login form or products if already logged in
     *
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        $login = Session::has('logged') ? Session::get('logged') : [];


        if ($login) {
            return $request->isXmlHttpRequest() ? ['success' => true] : redirect()->route('Products.list');
        } else {
            return $request->isXmlHttpRequest() ? ['success' => false] : view('admins.login');
        }
    }

    /**
     * Method used to display the items inside the cart
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cart(Request $request)
    {
        $cartList = Session::has('cart') ? Session::get('cart') : [];

        $items = $cartList ? Product::select()->whereIn('id', $cartList)->get() : [];

        return $request->isXmlHttpRequest() ? $items : view('client.cart', compact('items'));
    }

    /**
     * Method used for adding the items to cart
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function addToCart(Request $request, $id)
    {
        $cartList = Session::has('cart') ? Session::get('cart') : [];
        $cartList[] = $id;

        $request->session()->put('cart', $cartList);
        return $request->isXmlHttpRequest() ? ['success' => true] : redirect()->route('Clients.index');
    }

    /**
     * Method to remove the item from the shopping cart
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function removeFromCart(Request $request, $id)
    {
        $cartList = Session::has('cart') ? Session::get('cart') : [];

        if (($key = array_search($id, $cartList)) !== false) {
            unset($cartList[$key]);
        }

        session()->put('cart', $cartList);

        return $request->isXmlHttpRequest() ? ['success' => true] : redirect()->route('Clients.cart');
    }

    /**
     * Method used for composing the mail to be sent
     *
     * @param Request $request
     * @return array
     */
    public function sendOrder(Request $request)
    {
        $this->validate($request, [
            'coustomer_name' => 'required',
            'email' => 'required|email',
            'comments' => 'required',
        ]);

        $cartList = Session::has('cart') ? Session::get('cart') : [];

        if ($cartList) {
            $items = Product::select()->whereIn('id', $cartList)->get();
        } else {
            return ['success' => false];
        }

        $data = array(
            'name' => $request->input('coustomer_name'),
            'from' => $request->input('email'),
            'comments' => $request->input('comments'),
            'url' => asset('storage/Images/'),
            'items' => $items,
        );
        $clientCredentials = array(
            'adr' => $request->input('email'),
            'name' => $request->input('coustomer_name'),
            'shop' => env('SHOP_EMAIL'),
            'shopName' => 'IT Mecha Tech',
        );

        Mail::send('client.mail', $data, function ($message) use ($clientCredentials) {
            /** @var \Illuminate\Mail\Message $message */
            $message->to($clientCredentials['shop'], $clientCredentials['shopName'])->subject('Order List');
            $message->from($clientCredentials['adr'], $clientCredentials['name']);
        });

        Session::forget('cart');
        return $request->isXmlHttpRequest() ? ['success' => true] : redirect()->route('Clients.cart');

    }
}
