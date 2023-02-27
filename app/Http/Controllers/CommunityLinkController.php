<?php

namespace App\Http\Controllers;

use App\Models\CommunityLink;
use App\Models\Channel;
use App\Models\User;
use App\Queries\CommunityLinksQuery;
use Illuminate\Http\Request;
use App\Http\Requests\CommunityLinkForm;
use Illuminate\Support\Facades\Auth;

class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel = null)
    {
        // dd($channel);

        $query = new CommunityLinksQuery;
        $popular_tag = request()->exists('popular');

        // Si existe la etiqueta 'popular'
        if ($popular_tag) {

            // Y se pasa un canal por parametro
            if ($channel) {
                // Filtra los links mas votados de ese canal
                $links =  $query->getMostPopularByChannel($channel);
            } else {
                // Si no, filtra todos los links mas votados
                $links =  $query->getMostPopular();
            }
        } 
        // Si no existe la etiqueta 'popular'
        else
        {
            // Y se pasa un canal por parametro
            if ($channel) {
                // Muestra todos los links de dicho canal sin filtrar
                $links = $query->getByChannel($channel);
            } else {
                // Si no, muestra todos los links existentes
                $links =  $query->getAll();
            }
        }

        $channels = Channel::orderBy('title', 'asc')->get();
        return view('community/index', compact('links', 'channel', 'channels'));
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
    public function store(CommunityLinkForm $request)
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

        $user = new User;
        $trusted_user = $user->isTrusted();

        $link = new CommunityLink();
        $link->user_id = Auth::id();

        $existing_link = $link->hasAlreadyBeenSubmitted($request->link);

        // Si no existe el link
        if (!$existing_link) {

            // Lo crea
            $request->merge(['user_id' => Auth::id(), 'approved' => $trusted_user]);
            CommunityLink::create($request->all());

            // Si es una usario verificado
            if ($trusted_user) {
                return back()->with('success', 'Link creado y añadido con exito');
            } else {
                return back()->with('info', 'Link creado (falta aprobacion)');
            }

            // Si ya existe, actualiza el link
        } else {
            return back()->with('info', 'El link se ha actualizado');
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
