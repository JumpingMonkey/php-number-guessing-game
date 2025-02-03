# PHP Number Guessing Game

A simple CLI-based number guessing game implemented in PHP where the computer randomly selects a number between 1 and 100, and the user has to guess the number.

## Game Features

- Interactive CLI-based gameplay.
- Multiple difficulty levels (Easy, Medium, Hard) determine the number of allowed guesses.
- Provides hints by indicating if the guess is too high or too low.
- Tracks the time taken to guess the number.
- Maintains high scores for each difficulty level.
- Option to play multiple rounds and change difficulty after each round.

## How to Run

### Prerequisites

- Docker and Docker Compose installed.

### Steps to Run

1. Clone or download this repository.
2. Open a terminal and navigate to the project directory.
3. Build and run the Docker container:
   ```bash
   docker-compose run --rm game
   ```
   Or just run from inside the container:
   ```bash
   php game.php
   ```
4. Follow the on-screen instructions to play the game.

## File Overview

- `game.php`: Contains the main game logic.
- `Dockerfile`: Builds the PHP CLI container.
- `docker-compose.yml`: Docker Compose file for container orchestration.
- `README.md`: Project documentation.

## License

This project is open-source and available under the MIT License.

## Project URL

[roadmap.sh PHP Number Guessing Game Project](https://roadmap.sh/projects/number-guessing-game)
