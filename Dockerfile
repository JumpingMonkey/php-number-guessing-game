FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Copy application files
COPY . /app

RUN chmod +x game.php && ln -s /app/game.php /usr/local/bin/game

# Set entrypoint command to run the number guessing game
CMD [ "game" ]
