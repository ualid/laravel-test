<?php

namespace App\Http\Controllers;

use App\Models\Number;
use App\Http\Requests\Number\StoreNumberRequest;
use App\Http\Requests\Number\UpdateNumberRequest;
use App\Models\NumberPreference;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class NumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $query = Number::orderBy('number');

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
     * @param  \App\Http\Requests\StoreNumberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNumberRequest $request)
    {
        try {

            DB::beginTransaction();

            if(isset($request->status_id)) {
                $statusId = $request->status_id;
            } else {
                $statusNew = Status::active()->first();
                $statusId = $statusNew->id;
            }
            $data = [
                "number" => $request->number,
                "customer_id" => $request->customer_id,
                "status_id" => $statusId,
            ];

            $newNumber = Number::create($data);

            $numberPreferenceAutoAttendant =[
                "number_id" => $newNumber->id,
                "name" => 'auto_attendant',
                "value" => 1,
            ];

            $numberPreferenceVoicemailEnabled =[
                "number_id" => $newNumber->id,
                "name" => 'voicemail_enabled',
                "value" => 1,
            ];

            NumberPreference::create($numberPreferenceAutoAttendant);
            NumberPreference::create($numberPreferenceVoicemailEnabled);

            DB::commit();
            return response()->json($newNumber);
        } catch (\Throwable $e) {
            DB::rollback();
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
     * @param  \App\Models\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function show(Number $number)
    {
        return response()->json($number);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNumberRequest  $request
     * @param  \App\Models\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNumberRequest $request, Number $number)
    {
        try {
            if(isset($request->status_id)) {
                $statusId = $request->status_id;
            } else {
                $statusNew = Status::active()->first();
                $statusId = $statusNew->id;
            }
            $data = [
                "number" => $request->number,
                "customer_id" => $request->customer_id,
                "status_id" => $statusId,
            ];

            return response()->json($number->update($data));
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
     * @param  \App\Models\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function destroy(Number $number)
    {
        try {
            $number->load('numberPreference');
            return response()->json($number->delete());
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
