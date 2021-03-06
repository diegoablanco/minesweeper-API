<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Repositories\GameRepository;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    public function __construct(GameRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return response()->json($this->repository->all());
    }

    public function show(Request $request, $id)
    {
        return response()->json($this->repository->find($id));
    }

    public function create(Request $request)
    {
        $game = $this->repository->create($request->rows, $request->cols, $request->mines);
        return response()->json($game, 201);
    }

    public function reveal(Request $request, $id, $row, $col)
    {
        $game = $this->repository->reveal($id, $row, $col);
        return response()->json($game, 201);
    }

    public function flag(Request $request, $id, $row, $col)
    {
        $game = $this->repository->flag($id, $row, $col);
        return response()->json($game, 201);
    }

    public function question(Request $request, $id, $row, $col)
    {
        $game = $this->repository->question($id, $row, $col);
        return response()->json($game, 201);
    }
}
