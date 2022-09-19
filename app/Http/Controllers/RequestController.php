<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request\StoreRequestRequest;
use App\Http\Requests\Request\UpdateRequestRequest;
use App\Models\Message;
use App\Models\Project;
use App\Models\Request as ModelsRequest;
use App\Models\UserReadMessage;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function __construct(
        ModelsRequest $request,
        Project $project,
        Message $message,
        UserReadMessage $userReadMessage
    ) {
        $this->request = $request;
        $this->project = $project;
        $this->message = $message;
        $this->userReadMessage = $userReadMessage;
    }

    public function index()
    {
        $requests = $this->request->all();
        return view('request.list', ['requests' => $requests]);
    }

    public function create(Request $req)
    {
        $project = $req->has('project_id') ?
            $this->project->getById($req->get('project_id')) :
            null;

        return view('request.add', [
            'project' => $project
        ]);
    }

    public function store(StoreRequestRequest $req)
    {
        $newRequest = $this->request->create($req->all());
        return redirect('requests/' . $newRequest->id . '/edit?project_id=' . $req->get('project_id'));
    }

    public function show(ModelsRequest $request)
    {
        $project = $this->project->getById($request->project_id);
        $messages = $this->message->getMessagesOfRequest(
            $request->id,
            withUser: true
        );
        $this->userReadMessage->readMessages(
            $messages,
            auth()->user()->id
        );

        return view('request.show', [
            'request' => $request,
            'project' => $project,
            'messages' => $messages
        ]);
    }

    public function edit(Request $req, ModelsRequest $request)
    {
        $project = null;
        if ($req->has('project_id')) {
            $project = $this->project->getById($req->get('project_id'));
        }

        return view('request.edit', [
            'request' => $request,
            'project' => $project
        ]);
    }

    public function update(UpdateRequestRequest $req, ModelsRequest $request)
    {
        $request->update($req->all());
        return redirect('requests/' . $request->id . '/edit?project_id=' . $req->get('project_id'));
    }

    public function destroy(ModelsRequest $request)
    {
        $request->delete();
        return to_route('dashboard');
    }

    public function changeStatus(ModelsRequest $request)
    {
        $request->update([
            'status' => $request->status == 0 ? 1 : 0
        ]);

        return redirect('projects/' . $request->project_id);
    }
}
