<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function search(Workspace $workspace, $searchKey)
    {
        $user = auth()->user();

        if (!$user->workspaces->contains('id', $workspace->id)) {
            // User does not have access to the requested workspace
            abort(403, 'Unauthorized');
        }

        return inertia('Workspace/Show', [
            'workspace' => $workspace,
            'tasks' => Task::where('workspace_id', $workspace->id)
                            ->where('taskname', 'like', "%".$searchKey."%")
                            ->get()
        ]);

    }

    public function toggleFinish(Workspace $workspace, Task $task)
    {
        $task->status = !$task->status;
        $task->save();
        
        if($task->status == 1) {
            $recipient = auth()->user()->email;
            $content = "Congratulations! You have finished this task [".$task->taskname."].";
            $subject = "Task Updates";

            Mail::send('emails.notify', ['content' => $content], function($message) use ($subject, $recipient) {
                $message->to($recipient);
                $message->subject($subject);
            });


            return back()->banner('You have completed the task.');
        }

        return back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Workspace $workspace)
    {
        return inertia('Task/Create', [
            'workspace' => $workspace
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Workspace $workspace)
    {
        // dd($request->all());

        $request->validate([
            'taskname' => 'required|string',
            'date_sched' => 'required|date',
        ]);

        Task::create($request->all());

        return redirect('/workspaces/view-tasks/'.$workspace->id)->banner('Your task has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workspace $workspace, Task $task)
    {
        return inertia('Task/Edit', [
            'workspace' => $workspace,
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workspace $workspace, Task $task)
    {
        $fields = $request->validate([
            'taskname' => 'required|string',
            'date_sched' => 'required|date',
        ]);

        $task->update($fields);

        return redirect('/workspaces/view-tasks/'.$workspace->id)->banner('Your task has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workspace $workspace, Task $task)
    {
        $task->delete();

        return back()->banner('You have removed a task.');
    }
}
