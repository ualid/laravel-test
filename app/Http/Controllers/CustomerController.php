<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Customer::orderBy('name');
            return response()->json($query->get());
        } catch (\Throwable $e) {
            return response()->json([
                'title' => 'Erro inesperado',
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        try {
            if(isset($request->status_id)) {
                $statusId = $request->status_id;
            } else {
                $statusNew = Status::new()->first();
                $statusId = $statusNew->id;
            }
            $data = [
                "name" => $request->name,
                "user_id" => $request->user_id,
                "status_id" => $statusId,
                "document" => $request->document,
            ];
            return response()->json(Customer::create($data));
        } catch (\Throwable $e) {
            return response()->json([
                'title' => 'Erro inesperado',
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return response()->json($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        try {
            if(isset($request->status_id)) {
                $statusId = $request->status_id;
            } else {
                $statusNew = Status::new()->first();
                $statusId = $statusNew->id;
            }
            $data = [
                "name" => $request->name,
                "user_id" => $request->user_id,
                "status_id" => $statusId,
                "document" => $request->document,
            ];
            return response()->json($customer->update($data));
        } catch (\Throwable $e) {
            return response()->json([
                'title' => 'Erro inesperado',
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->load(['number']);
            return response()->json($customer->delete());
        } catch (\Throwable $e) {
            return response()->json([
                "errors" => [
                    "title" => "Erro inesperado",
                    "line" => $e->getLine(),
                    "file" => $e->getFile(),
                    "message" => $e->getMessage()
                ]
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
