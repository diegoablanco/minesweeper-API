## Minesweeper

This is an API implementation for the Minesweeper game.

## Getting started
Run `composer install` to install the application dependencies.
You can start using the application based on the provided sqlite file, or you can specify a different database conection in the .env file, then you will have to run the `php artisan migrate` command.
## Using the API

[Check the API documentation](https://web.postman.co/collections/5026772-868e3c6c-3b37-40df-b219-9dddbb41a8ad?version=latest&workspace=9d3f458c-790d-48da-8a0e-9f798103a0c1)

[Postman collection](https://www.getpostman.com/collections/a8b26c3ba789d8d3ea8b)

To play a game, create one using the creation endpoint. Once created you can start revealing and flagging cells until all bombs were flagged and the game is finished or you reveal a cell having a bomb and the game is over.

The API calls for reveal, flag and question actions will return a game object which state can be:
- started
- finished: when all bombs where flagged
- over: when a bomb is revealed.

Each game row has a collection of cells which state can be:
- unrev: not revealed
- rev: revealed
- question: marked with a question
- flagged
