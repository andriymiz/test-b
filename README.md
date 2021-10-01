## About Test

We need a new  API service to accept tickets and save them to a database.  The idea is to allow employees to submit tickets from a public page without having to sign in.  (Right now, employees need VPN before they can sign into our administration).
 
- The API should enforce CORS (allow specific domains to POST and reject others).
- We will provide the database definitions and some HTML.
- Before saving the ticket to the database, we should determine the user, based on their username or email. (if the user is not found, then the user should get an error message).
- We need a Google captcha to prevent abuse.
- We want to verify the ticket, either:
  - User must submit a valid password when submitting the ticket, or
  - User must click a link that is sent to their email to “verify” who is submitting the ticket.

## Setup
- Rename `.env.example` to `.env` by running this command `cp .env.example .env`;
- Run `composer install` it will install all the packages and creates the vendor folder;
- Or from docker `docker run --rm -v "$(pwd)":/app composer install`.
- Make sure you have docker installed on your machine, and the docker daemon is running;
- Setup the database credentials in the `.env`;
- To start the application run `./vendor/bin/sail up -d`;
- To generate the application key run `./vendor/bin/sail artisan key:generate`;
- To migrate the database run `./vendor/bin/sail php artisan migrate:fresh --seed`;
- To run tests execute `./vendor/bin/sail php ./vendor/phpunit/phpunit/phpunit`.

## Comments
- For enforce CORS fill `ALLOWED_ORIGINS` in `.env`;
- While database is not provided, there is a `Users.php`, `Ticket.php`, `TicketMessage.php` models and `welcome.blade.php` as example with form;
- Before save ticket, system will searching user by username or email in db `TicketController.php`;
- To prevent abuse by ReCaptcha needs to fill `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET_KEY` in `.env` file from http://www.google.com/recaptcha/admin;
- For verify ticket user can enter password. If password is wrong then link to confirmation will be sended to email;
- For testing email you can use MailHog (localhost:8025), also need fill MAIL_FROM_ADDRESS.
