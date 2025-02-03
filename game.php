#!/usr/bin/env php
<?php

function loadHighscores() {
    $filename = __DIR__ . '/highscores.json';
    if(file_exists($filename)) {
        $contents = file_get_contents($filename);
        $data = json_decode($contents, true);
        return $data ? $data : [];
    }
    return [];
}

function saveHighscores($scores) {
    $filename = __DIR__ . '/highscores.json';
    file_put_contents($filename, json_encode($scores, JSON_PRETTY_PRINT));
}

function getDifficulty($choice) {
    switch($choice) {
        case "1":
            return ["name" => "Easy", "attempts" => 10];
        case "2":
            return ["name" => "Medium", "attempts" => 5];
        case "3":
            return ["name" => "Hard", "attempts" => 3];
        default:
            return null;
    }
}

$handle = fopen('php://stdin', 'r');

// Initial welcome and difficulty selection
echo "Welcome to the Number Guessing Game!\n";
echo "I'm thinking of a number between 1 and 100.\n\n";

echo "Please select the difficulty level:\n";
echo "1. Easy (10 chances)\n";
echo "2. Medium (5 chances)\n";
echo "3. Hard (3 chances)\n\n";
echo "Enter your choice: ";

$choice = trim(fgets($handle));
$difficulty = getDifficulty($choice);

if(!$difficulty) {
    echo "Invalid choice. Exiting...\n";
    exit(1);
}

echo "\nGreat! You have selected the " . $difficulty["name"] . " difficulty level.\n";
echo "Let's start the game!\n\n";

$highscores = loadHighscores();

// Main game loop

do {
    $secret = rand(1, 100);
    $attemptsAllowed = $difficulty["attempts"];
    $attempts = 0;
    $startTime = microtime(true);
    $won = false;

    while($attempts < $attemptsAllowed) {
        echo "Enter your guess: ";
        $input = trim(fgets($handle));
        $attempts++;
        if(!is_numeric($input)) {
            echo "Please enter a valid number.\n";
            continue;
        }
        $guess = intval($input);

        if($guess == $secret) {
            $won = true;
            $endTime = microtime(true);
            $timeTaken = round($endTime - $startTime, 2);
            echo "Congratulations! You guessed the correct number in $attempts attempts in $timeTaken seconds.\n";
            // Update highscore
            $levelKey = strtolower($difficulty["name"]);
            if(!isset($highscores[$levelKey]) || $attempts < $highscores[$levelKey]) {
                $highscores[$levelKey] = $attempts;
                echo "New high score for {$difficulty["name"]} level!\n";
            }
            break;
        } else if($guess < $secret) {
            echo "Incorrect! The number is greater than $guess.\n";
        } else {
            echo "Incorrect! The number is less than $guess.\n";
        }
    }

    if(!$won) {
        echo "Game Over! You've used all your chances. The number was $secret.\n";
    }

    echo "\nCurrent High Scores:\n";
    foreach($highscores as $level => $score) {
        echo ucfirst($level) . ": $score attempts\n";
    }

    echo "\nDo you want to play again? (y/n): ";
    $playAgain = trim(fgets($handle));
    if(strtolower($playAgain) == 'y'){
         // Optionally allow user to change difficulty
         echo "\nDo you want to change difficulty? (y/n): ";
         $changeDiff = trim(fgets($handle));
         if(strtolower($changeDiff) == 'y'){
             echo "\nPlease select the difficulty level:\n";
             echo "1. Easy (10 chances)\n";
             echo "2. Medium (5 chances)\n";
             echo "3. Hard (3 chances)\n\n";
             echo "Enter your choice: ";
             $choice = trim(fgets($handle));
             $newDifficulty = getDifficulty($choice);
             if($newDifficulty){
                 $difficulty = $newDifficulty;
                 echo "\nDifficulty changed to " . $difficulty["name"] . ".\n";
             } else {
                 echo "Invalid choice, keeping previous difficulty.\n";
             }
         }
    } else {
         break;
    }

} while(true);

saveHighscores($highscores);

echo "Thanks for playing!\n";

?>
