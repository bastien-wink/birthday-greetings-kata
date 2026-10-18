# Birthday Greetings Kata (PHP Version)

This is a PHP translation of the Birthday Greetings Kata, which is a refactoring exercise focused on teaching dependency inversion and dependency injection principles.

The original Java version and its documentation can be found in the [original repository](http://matteo.vaccari.name/blog/archives/154).

## Setup

Docker is the only requirement: `compose.yaml` starts MailDev, a test SMTP server, and a container from the official Composer image (PHP 8.4 and Composer).

```bash
docker compose up -d
docker compose exec php composer install
docker compose exec php vendor/bin/phpunit
docker compose exec php php src/birthday_greetings/Main.php
```

The code reaches MailDev through its service name, `maildev`. Received emails are visible at http://localhost:1080.

## Project Structure

- `src/birthday_greetings/` - Main application code
- `tests/` - Test code
- `employee_data.txt` - Sample employee data file

## The Exercise

The goal is to refactor the code to:
- Apply dependency inversion principle
- Implement dependency injection
- Separate concerns
- Make the code more testable and maintainable

## Notes

- The tests use MailDev as a mock SMTP server, which provides a web interface to inspect received emails
- The code intentionally contains code smells that should be addressed during the refactoring exercise



