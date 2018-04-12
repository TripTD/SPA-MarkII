<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;


class AdminsController extends Controller
{
    /**
     * Method used for login and access to products
     *
     * @param Request $request
     * @return array
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if (env('AP_USER') == $request->input('username') && env('AP_PASSWORD') == $request->input('password')) {
            session()->put('logged', 1);

            return $request->isXmlHttpRequest() ? ['success' => true] : redirect()->route('Products.list');
        }

        return $request->isXmlHttpRequest() ? ['success' => false] : redirect()->back();
    }

    /**
     * Method used for clearing the data session upon logging off
     *
     * @param Request $request
     * @return array
     */
    public function logout(Request $request)
    {
        Session::forget('logged');

        return $request->isXmlHttpRequest() ? ['success' => true] : redirect()->route('Clients.index');
    }
}
