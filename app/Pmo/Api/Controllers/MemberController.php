<?php

namespace App\Pmo\Api\Controllers;

use App\Pmo\Front\Controllers\RootFrontController;
use Illuminate\Http\Request;
use App\Pmo\Front\Models\ShopOrder;

class MemberController extends RootFrontController
{

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function getInfo(Request $request)
    {
        return response()->json($request->user());
    }
}
