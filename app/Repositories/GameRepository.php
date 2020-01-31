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
                $this->revealCell($cell);
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

    private function revealCell($cell)
    {
        $cell->state = Cell::REVEALED;
        $cell->save();
    }
}