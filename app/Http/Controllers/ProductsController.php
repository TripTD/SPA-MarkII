<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;


class ProductsController extends Controller
{
    /**
     * Method used to display the big table with all the products
     *
     * @param Request $request
     * @return object
     */
    public function list(Request $request)
    {
        $items = Product::all();

        return $request->isXmlHttpRequest() ? $items : view('admins.products', compact('items'));
    }

    /**
     * Displaying a certain product to be edited or up to insertion
     *
     * @param Request $request
     * @param null $id
     * @return array
     */
    public function show(Request $request, $id = null)
    {
        return $request->isXmlHttpRequest() ? ['success' => true] : view('admins.product', compact('id'));

    }

    /**
     *Method used for the editing and inserting part of a product
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'Title' => 'required',
            'Description' => 'required',
            'Price' => 'required',
            'Image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $product = $request['id'] !== null ? Product::find($request['id']) : new Product;

        /**
         * @property object title
         * @property object description
         * @property object price
         */

        $product->title = $request->input('Title');
        $product->description = $request->input('Description');
        $product->price = $request->input('Price');
        $image = time() . '.' . $request->Image->getClientOriginalExtension();
        $request->Image->move(public_path('storage/Images'), $image);

        $product->image = $image;
        $product->save();

        return $request->isXmlHttpRequest() ? ['success' => true] : redirect()->route('Products.list');
    }

    /**
     * Method used to delete a product from the database
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);
        $product->delete();

        return $request->isXmlHttpRequest() ? ['success' => true] : redirect()->route('Products.list');
    }
}
