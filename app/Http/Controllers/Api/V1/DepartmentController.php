<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        $queryDepartment =  Department::query()->with('districts');
        return DataTables::eloquent($queryDepartment)->make();
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:departments,code',
            'name' => 'required|unique:departments,name',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $department = new Department();
        $department->code = $request->input('code');
        $department->name = $request->input('name');
        $department->save();

        return response()->json(['message' => 'Datos insertados con éxito'], 201);
    }

    public function show($id): Model|Collection|Builder|array|null
    {
        return Department::find($id);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:departments,code,' . $id,
            'name' => 'required|unique:departments,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $department = Department::findOrFail($id);
        $department->update($request->all());
        return response()->json(['message' => 'Datos actualizados con éxito'], 201);
    }

    public function destroy($id): Response
    {
        $producer = Department::findOrFail($id);
        $producer->delete();
        return response()->noContent();
    }
}
