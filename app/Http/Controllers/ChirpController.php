<?php

namespace App\Http\Controllers;

use App\Events\UserCommentDelete;
use App\Events\UsersComment;
use App\Models\Chirp;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Broadcast::event('new-message', [
        //     'message' => 'messagedd',
        // ]);
        // UsersComment::dispatch('sd');
        return Inertia::render('Chirps/Index', [
            'chirps' => Chirp::with('user:id,name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
        // dd(Chirp::find(1));
        $chirp = $request->user()->chirp()->create($validated);



        // UsersComment::dispatch(Auth::user()->name, $validated);
        broadcast(new UsersComment($request->user(), Chirp::find($chirp->id)))->toOthers();
     
 
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        $this->authorize('update', $chirp);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $chirp->update($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp) : RedirectResponse
    {
        // dd($chirp);
        UserCommentDelete::dispatch($chirp);

        $this->authorize('delete', $chirp);
        
        // dd($chirp);

        $chirp->delete();
 
        return redirect(route('chirps.index'));
    }
}
