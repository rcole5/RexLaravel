<?php

namespace App\Http\Controllers;

use App\Transformers\ActorTransformer;
use Carbon\Carbon;
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

    /**
     * Returns a specific actor.
     *
     * @param Actor $actor
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function show(Actor $actor)
    {
        $fractal = new Manager();
        $response = new Item($actor, new ActorTransformer());
        return response($fractal->createData($response)->toJson(), 200);
    }

    /**
     * Get the latest actors.
     *
     * @param Request $r
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getLatest(Request $r)
    {
        $limit = $r->has('limit') ? $r->input('limit') : 3;
        $fractal = new Manager();
        $actor = Actor::orderBy('created_at', 'desc')->limit($limit)->get();
        $response = new Collection($actor, new ActorTransformer());
        return response($fractal->createData($response)->toJson(), 200);
    }

    /**
     * Creates an actor.
     *
     * @param Request $r
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $r)
    {
        $arr = $r->all();
        $arr['age'] = Carbon::parse($r->input('dob'))->age;
        $fractal = new Manager();
        $actor = Actor::create($arr);
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
