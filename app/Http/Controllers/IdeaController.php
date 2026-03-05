<?php

namespace App\Http\Controllers;

use App\Actions\CreateIdea;
use App\Actions\UpdateIdea;
use App\Http\Requests\IdeaRequest;
use App\IdeaStatus;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Throwable;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $user = auth()->user();

        $status = $request->status;

        $ideas = $user->ideas()
            ->when(in_array($status, IdeaStatus::values()), fn ($query) => $query->where('status', $status))
            ->latest()->get();

        return view('idea.index', [
            'ideas' => $ideas,
            'statusCount' => Idea::statusCounts($user), // Passa os contadores no model de status para a view
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(IdeaRequest $request, CreateIdea $createIdea)
    {

        $createIdea->handle($request->safe()->all());

        return to_route('idea.index')
            ->with('success', 'idea created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        return view('idea.show', [
            'idea' => $idea,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Throwable
     */
    public function update(IdeaRequest $request, Idea $idea, UpdateIdea $action)
    {

        Gate::authorize('workWith', $idea);
        $action->handle($request->safe()->all(), $idea);

        return back()->with('success', 'idea updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        // autorização é feita no policy, então aqui só precisamos deletar a ideia
        Gate::authorize('workWith', $idea);
        $idea->delete();

        return to_route('idea.index')->with('success', 'idea deleted successfully.');
    }
}
