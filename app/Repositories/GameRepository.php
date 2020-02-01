<?php

namespace App\Repositories;

use App\Models\Game;
use App\Models\Row;
use App\Models\Cell;

/**
 * Class GameRepository
 * @package App\Repositories
 * @version January 31, 2020, 3:26 pm UTC
*/

class GameRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Game::class;
    }
    public function all()
    {
        return Game::all();
    }

    public function find($id)
    {
        return Game::with(['rows'])->find($id);
    }

    public function reveal($id, $row, $col)
    {
        $game = Game::find($id);
        // TODO: validate row and cols
        // TODO: validate game state
        $cell = $game->rows[$row]->cells[$col];
        
        if($cell->state == Cell::UNREVEALED) {
            if($cell->is_bomb) {
                $game->state = Game::OVER;
                $game->save();
            } else {
                $this->revealCell($game, $cell);
            }
        }
        return $game;
    }

    public function flag($id, $row, $col)
    {
        $game = Game::find($id);
        $gameCells = $game->rows->flatMap(function ($row) {
            return $row->cells;
        });
        $bombCells = $gameCells->where('is_bomb');
        $totalFlagged = $gameCells->where('state', Cell::FLAGGED)->count();
        // TODO: validate row and cols
        // TODO: validate game state

        // check if there's flags left
        if($totalFlagged < $bombCells->count()) {
            $cell = $game->rows[$row]->cells[$col];
            
            if($cell->state == Cell::UNREVEALED) {
                $cell->state = Cell::FLAGGED;
                $cell->save();
            }
            // check game is finished
            if($bombCells->where('state', Cell::FLAGGED)->count() == $bombCells->count()) {                
                $game->state = Game::FINISHED;
                $game->save();
            }
        }
        return $game;
    }

    public function create(array $attributes, $rows = 10, $cols = 10, $mines = 10) {
        $game = Game::create();
        for ($rowIndex = 0; $rowIndex < $rows; $rowIndex++) {
            $row = new Row();
            $game->rows()->save($row);
            for ($colIndex = 0; $colIndex < $cols; $colIndex++) {
                $cell = new Cell();
                $row->cells()->save($cell);
            }
        }

        for($mineIndex = 0; $mineIndex < $mines; $mineIndex++) {
            $bombAdded = false;
            while(!$bombAdded) {
                $randomRow = \mt_rand(0, $rows - 1);
                $randomCell = \mt_rand(0, $cols - 1);
                $cell = $game->rows[$randomRow]->cells[$randomCell];
                if($cell->is_bomb)
                    continue;
                $cell->is_bomb = true;
                $cell->save();
                $bombAdded = true;
            }

        }
        return $game;
    }

    private function revealCell($game, $cell)
    {
        $neighbouringCells = $this->getNeighbouringCells($game, $cell);
        
        $cell->neighbouring_bombs = $neighbouringCells->where('is_bomb')->count();
        $cell->state = Cell::REVEALED;

        $cell->save();

        if($cell->neighbouring_bombs == 0) {
            foreach($neighbouringCells as $neighbouringCell) {
                revealCell($game, $neighbouringCell);
            }
        }
    }

    private function getNeighbouringCells($game, $cell)
    {
        $rowIndex = $game->rows->pluck('id')->search($cell->row_id);
        $row = $game->rows[$rowIndex];
        $colIndex = $row->cells->pluck('id')->search($cell->id);
        $rowsCount = $game->rows->count();
        $cellsCount = $row->cells->count();
        $neighbouringCells = collect([]);

        if($colIndex > 0) {
            $neighbouringCells[] = $row->cells[$colIndex - 1];
        }
        if($colIndex < $cellsCount - 1) {
            $neighbouringCells[] = $row->cells[$colIndex + 1];
        }
        if($rowIndex > 0) {
            $upperRow = $game->rows[$rowIndex - 1];
            $neighbouringCells[] = $upperRow->cells[$colIndex];
            if($colIndex > 0) {
                $neighbouringCells[] = $upperRow->cells[$colIndex - 1];
            }
            if($colIndex < $cellsCount - 1) {
                $neighbouringCells[] = $upperRow->cells[$colIndex + 1];
            }
        }
        if($rowIndex < $rowsCount - 1) {
            $lowerRow = $game->rows[$rowIndex + 1];
            $neighbouringCells[] = $lowerRow->cells[$colIndex];
            if($colIndex > 0) {
                $neighbouringCells[] = $lowerRow->cells[$colIndex - 1];
            }
            if($colIndex < $cellsCount - 1) {
                $neighbouringCells[] = $lowerRow->cells[$colIndex + 1];
            }
        }
        return $neighbouringCells;
    }
}
