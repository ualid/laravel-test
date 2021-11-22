<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Response;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $query = Status::orderBy('name');
            return response()->json($query->get());
        } catch (\Throwable $e) {
            return response()->json([
                'title' => 'Erro inesperado',
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
