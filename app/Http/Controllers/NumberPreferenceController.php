<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\NumberPreference;
use App\Http\Requests\NumberPreference\StoreNumberPreferenceRequest;
use App\Http\Requests\NumberPreference\UpdateNumberPreferenceRequest;

class NumberPreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $query = NumberPreference::with(['number']);

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
     * @param  \App\Http\Requests\StoreNumberPreferenceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNumberPreferenceRequest $request)
    {
        try {
            $data = [
                "number_id" => $request->number_id,
                "name" => $request->name,
                "value" => $request->value,
            ];
            return response()->json(NumberPreference::create($data));
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
     * @param  \App\Models\NumberPreference  $numberPreference
     * @return \Illuminate\Http\Response
     */
    public function show(NumberPreference $numberPreference)
    {
        return response()->json($numberPreference);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNumberPreferenceRequest  $request
     * @param  \App\Models\NumberPreference  $numberPreference
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNumberPreferenceRequest $request, NumberPreference $numberPreference)
    {
        try {
            $data = [
                "number_id" => $request->number_id,
                "name" => $request->name,
                "value" => $request->value,
            ];
            return response()->json($numberPreference->update($data));
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
     * @param  \App\Models\NumberPreference  $numberPreference
     * @return \Illuminate\Http\Response
     */
    public function destroy(NumberPreference $numberPreference)
    {
        try {
            return response()->json($numberPreference->delete());
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
