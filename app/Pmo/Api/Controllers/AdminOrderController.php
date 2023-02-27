<?php

namespace App\Pmo\Api\Controllers;

use App\Pmo\Front\Controllers\RootFrontController;
use Illuminate\Http\Request;
use App\Pmo\Front\Models\ShopOrder;

class AdminOrderController extends RootFrontController
{

    /**
     * Get the order list
     *
     * @return [json] user object
     */
    public function orders(Request $request)
    {
        $orders = (new ShopOrder)
                ->jsonPaginate();
        return response()->json($orders, 200);
    }

    /**
     * Get order detail
     *
     * @return [json] order object
     */
    public function orderDetail(Request $request, $id)
    {
        $order = (new ShopOrder)->where('id', $id)
                ->with('details')
                ->first();
        if ($order) {
            $dataReturn = $order;
        } else {
            $dataReturn = [
                'error' => 1,
                'msg' => 'Not found',
                'detail' => 'Order not found or no permission!',
            ];
        }
        return response()->json($dataReturn, 200);
    }

    /**
     * Create new order
     *
     * @return void
     */
    public function createOrder()
    {
        $data = request()->all();
        $user = request()->user();
        $dataOrder = $data['dataOrder'];
        $dataTotal = $data['dataTotal'];
        $itemDetail = $data['itemDetail'];
        $dataOrder['admin_id'] = $user->id;
        $dataReturn = (new ShopOrder)->createOrder($dataOrder, $dataTotal, $itemDetail);
        if ($dataReturn['error'] == 1) {
            sc_report($dataReturn['msg']);
        }
        return response()->json($dataReturn, 200);
    }

    /**
     * Cancel order
     *
     * @param [type] $orderId
     * @return void
     */
    public function cancelOrder($orderId)
    {
        $user = request()->user();
        $order = (new ShopOrder)->where('id', $orderId)->first();
        if ($order) {
            $history = [
                'admin_id' => $user->id,
                'content' => 'API cancel order',
            ];
            (new ShopOrder)->updateStatus($orderId, $status = 4, $history);
            $dataReturn = [
                'status' => 0,
                'msg' => 'Cancel order success',
                'detail' => 'Order #'.$orderId. ' canceled',
            ];
        } else {
            $dataReturn = [
                'status' => 1,
                'msg' => 'Order not found',
                'detail' => 'Order #'.$orderId. ' not found',
            ];
        }
        return response()->json($dataReturn, 200);
    }
}
