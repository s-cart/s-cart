<?php

namespace App\Pmo\Api\Controllers;

use App\Pmo\Front\Controllers\RootFrontController;
use Illuminate\Http\Request;
use App\Pmo\Front\Models\ShopCustomer;
use App\Pmo\Front\Controllers\Auth\AuthTrait;
use Illuminate\Support\Facades\Validator;

class AdminCustomerController extends RootFrontController
{
    use AuthTrait;
    /**
     * Get the customer list
     *
     * @return [json] user object
     */
    public function customers(Request $request)
    {
        $customers = (new ShopCustomer)
                ->jsonPaginate();
        return response()->json($customers, 200);
    }

    /**
     * Get customer detail
     *
     * @return [json] customer object
     */
    public function customerDetail(Request $request, $id)
    {
        $customer = (new ShopCustomer)->where('id', $id)
                ->first();
        if ($customer) {
            $dataReturn = $customer;
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
     * Create new customer
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $data['country'] = strtoupper($data['country'] ?? '');

        $v = $this->validator($data);
        if ($v->fails()) {
            $msg = '';
            foreach ($v->errors()->toArray() as $key => $value) {
                $msg .=$key." : ".$value[0]."\n ";
            }
            return response()->json([
                'error' => 1,
                'msg' => 'Error while create new customer',
                'detail' => $msg
            ]);
        }

        $user = $this->insertCustomer($data);
        
        return response()->json($user);
    }

    /**
     * Validate data input
     */
    protected function validator(array $data)
    {
        $dataMap = $this->mappingValidator($data);
        return Validator::make($data, $dataMap['validate'], $dataMap['messages']);
    }

    /**
     * Inser data new customer
     */
    protected function insertCustomer(array $data)
    {
        $dataMap = $this->mappingValidator($data);
        $user = ShopCustomer::createCustomer($dataMap['dataInsert']);
        if ($user) {
            sc_customer_created_by_admin($user, $dataMap['dataInsert']);
        }
        return $user;
    }
}
