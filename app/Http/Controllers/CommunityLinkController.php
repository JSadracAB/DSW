<?php

namespace App\Http\Controllers;

use App\Models\CommunityLink;
use App\Models\Channel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = CommunityLink::where('approved', true)->latest('updated_at')->paginate(25);
        $channels = Channel::orderBy('title', 'asc')->get();
        return view('community/index', compact('links', 'channels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        // $request->path();
        // Muestra unicamente la ruta

        // $request->url();
        // Muestra la url sin contar las variables

        // $request->input();
        // Muestra los campos input

        // $request->fullUrl();
        // Muestra la url completa (variables incluidas)

        $this->validate($request, [
            'title' => 'required',
            'link' => 'required|active_url',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $user = new User;
        $trusted_user = $user->isTrusted();
        $existing_link = CommunityLink::hasAlreadyBeenSubmitted($request['link']);

        if ($trusted_user) {
            if (!$existing_link) {
                request()->merge(['user_id' => Auth::id(), 'approved' => $trusted_user]);
                CommunityLink::create($request->all());
                return back()->with('success', 'Link creado y añadido con exito');
            } else {
                return back()->with('info', 'Su link se ha actualizado');
            }
        } else {
            if(!$existing_link) {
                request()->merge(['user_id' => Auth::id(), 'approved' => $trusted_user]);
                CommunityLink::create($request->all());
                return back()->with('info', 'Su nuevo link se añadira cuando sea aprobado :)');
            } else {
                return back()->with('info', 'Su nuevo link se añadira cuando sea aprobado :)');
            }
            
        }

        // return response('Respuesta', 200);
        // return response('Error', 404);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommunityLink  $communityLink
     * @return \Illuminate\Http\Response
     */
    public function show(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommunityLink  $communityLink
     * @return \Illuminate\Http\Response
     */
    public function edit(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommunityLink  $communityLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommunityLink $communityLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CommunityLink  $communityLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommunityLink $communityLink)
    {
        //
    }
}
