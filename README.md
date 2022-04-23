# Nested Comment

- Create a comment system single-page web application using a framework of choice (preferably Laravel 5.5+) and VueJS / React with the following requirements:
- Assume that there is only one Blog Post that can be commented on.
- Only the user’s name and comment text are required to post a comment.
- A comment can be replied to with another comment.
- Nested comments are up to 3 layers only
- The page should not refresh when posting a comment.
- Comments must be ordered by the latest.
- Make the user interface as beautiful, responsive, and easy to use as you can.
- Use MySQL database for storing your data.
- No need to edit, delete, etc of comments.
- What we are looking for:
- Optimal code that is clean and maintainable.
- Business logic organization and software design patterns.
- Optimized SQL performance.
-Documentation.
- Unit tests.

## How to setup

- run ```composer install```
- run ```npm install```
- copy .env.example to .env 
- setup the database connection
- run ```php artisan key:generate```
- run ```php artisan migrate```
- run ```npm run dev```
- run ```php artisan serve```


## Testing
- run ```.\vendor\bin\phpunit```
