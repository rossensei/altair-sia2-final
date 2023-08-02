<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Workspace/Index', [
            'workspaces' => Workspace::where('user_id', auth()->user()->id)
                                        ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Workspace/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'string|required',
            'description' => 'string|required',
        ]);

        $fields['user_id'] = auth()->user()->id;

        Workspace::create($fields);

        return redirect('/workspaces')->banner('You added a new workspace.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Workspace $workspace)
    {
        $user = auth()->user();

        if (!$user->workspaces->contains('id', $workspace->id)) {
            // User does not have access to the requested workspace
            abort(403, 'Unauthorized');
        }

        $tasks = $workspace->tasks;

        return inertia('Workspace/Show', [
            'workspace' => $workspace,
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workspace $workspace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workspace $workspace)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workspace $workspace)
    {
        $workspace->delete();
        return back()->banner('Workspace has been removed.');
    }

    public function updateBackgroundPhoto(Request $request, Workspace $workspace)
    {
        // dd($request);
        $fileName = null;

        if($request->background_photo) {
            $fileName = time().'.'.$request->background_photo->extension();
            $request->background_photo->move(public_path('images/background-photos'), $fileName);
            $workspace->background_photo = $fileName;
            $workspace->save();

            return back()->banner('Workspace background photo has been updated.');
        }
    }
}
