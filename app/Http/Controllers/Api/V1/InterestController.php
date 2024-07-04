<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Interest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class InterestController extends Controller
{
    public function index(): JsonResponse
    {
        $queryData =  Interest::query();
        return DataTables::eloquent($queryData)->make();
    }
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ci' => 'required|unique:clients,ci',
            'name' => 'required',
            'last_name' => 'required',
            'date_birth' => 'required',
            'gender' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $client = Client::create($request->all());

        if ($request->has('users_id')) {
            $client->users()->sync($request->input('users_id'));
        }

        return response()->json(['message' => 'Datos insertados con éxito'], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ci' => 'required|unique:clients,ci,' . $id,
            'name' => 'required',
            'last_name' => 'required',
            'date_birth' => 'required',
            'gender' => 'required',
            'users_id' => 'array|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $client->update($request->all());

        if ($request->has('users_id')) {
            $client->users()->sync($request->input('users_id'));
        }

        return response()->json(['message' => 'Datos actualizados con éxito'], 200);
    }

    public function show($id): Model|Collection|Builder|array|null
    {
        return Client::with(['users'])->find($id);
    }

    public function destroy($id): JsonResponse
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        // Eliminar el cliente
        $client->delete();

        return response()->json(['message' => 'Cliente eliminado con éxito'], 200);
    }

}
