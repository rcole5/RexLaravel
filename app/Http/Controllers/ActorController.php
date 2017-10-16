<?php

namespace App\Http\Controllers;

use App\Transformers\ActorTransformer;
use Illuminate\Http\Request;
use \App\Models\Actor;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class ActorController extends Controller
{

    /**
     * Returns all actors.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        $fractal = new Manager();
        $actor = Actor::all();
        $resource = new Collection($actor, new ActorTransformer());
        return response($fractal->createData($resource)->toJson(), 200);
    }

    public function show(Actor $actor)
    {
        return $actor;
    }

    /**
     * Creates an actor.
     *
     * @param Request $r
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $r)
    {
        $fractal = new Manager();
        $actor = Actor::create($r->all());
        $resource = new Item($actor, new ActorTransformer());
        return response($fractal->createData($resource)->toJson(), 201);
    }

    /**
     * Updates an actor.
     *
     * @param Request $r
     * @param Actor $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $r, Actor $actor)
    {
        $fractal = new Manager();
        $actor->update($r->all());
        $resource = new Item($actor, new ActorTransformer());
        return response($fractal->createData($resource)->toJson(), 200);
//        return response()->json($actor, 200);
    }

    /**
     * Deletes an actor.
     *
     * @param Actor $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Actor $actor)
    {
        $actor->delete();
        return response()->json(null, 204);
    }
}
