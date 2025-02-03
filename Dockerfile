FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Copy application files
COPY . /app

# Set entrypoint command to run the number guessing game
CMD [ "php", "game.php" ]
