<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Egulias\EmailValidator\Result\Reason\UnclosedQuotedString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'titulo' => 'required|string|max:255',
            'descripcion' => 'string',
            'valor' => 'numeric',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'url_referencia' => 'string|url',
            'usuario_creador' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    public function show($id)
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json(['message' => 'No se encontro'], 404);
        }
        
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json(['message' => 'No se encontro'], 404);
        }
        
        $validator = Validator::make($request->all(),[
            'titulo' => 'required|string|max:255',
            'descripcion' => 'string',
            'valor' => 'numeric',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'url_referencia' => 'string|url',
            'usuario_creador' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $task->update($request->all());
        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json(['message' => 'No se encontro'], 404);
        }
        
        $task->delete();
        return response()->json(['message' => 'Eliminada correctamente']);
    }
}
