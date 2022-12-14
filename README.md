# PHP Laravel API Template

## Requirements

- PHP 9
- PHP Modules: php-xml, php-curl, php-zip, php-pgsql, php-mysql
- PHP "Composer" for creating web projects and install packages

## Concepts used in Template

- Routing
- Controller
- Database Connection
- Database Table setup (Migration)
- CRUD against a Database Resource (Create-Read-Update-Delete)
- Request File (requests.http) for testing your Routes
- Signup with password hashing
- Login with API Token creation
- Route Protection with Token verification
- Deployment to Heroku using Procfile

## Configure it

- copy the .env.sample file to an .env file
- Look inside .env file for the section that starts with "DB_" (around line 11)
- Filll in your DB Connection details 
  - in case you don't have one, you could e.g. create a free MySQL database at https://www.freesqldatabase.com/
  - after registration and creation of the database you will receive an email with the connection details (host, database, user, password) which you can fill into the .env file 
- Start the app from terminal: "php artisan serve"
- If it works: Try to navigate to the route /api/animals in the browser -> it probably will complain that the animals table does not exist the database
- Creating the database tables by running migration:
  - "php artisan migrate" 
  - (hoping it runs through without errors :leichtes_lächeln:)
- If migration worked: Try to navigate to /api/animals again 
  - => it should now return an empty array instead of error. 
  - In that case: Your DB connection works!
- Now you can test to create a new entry, using the request.http file 
  - POST an animal
  - Afterwards list all animals using GET /api/animals
  - Your new animals should get listed here
  - Post 2-3 more
  - Try update and delete of animal too


## Preparing for deployment

On Heroku you can deploy PHP pages for free

- Login on heroku.com
  - Create an account if you don't have one so far
- In the dashboard: Create a new app
  - In case you already have 5 apps => hopefully you can delete an old one
  - Otherwise you need to create another Heroku account using another email
- Configure .env
  - Go to Tab "Settings"
  - Copy all DB variables from your .env file over to here
    - DB_CONNECTION
    - DB_HOST
    - DB_DATABASE
    - DB_USERNAME
    - DB_PASSWORD
  - Also create a config var "TOKEN_SECRET" and give it some value, e.g. yourHolySecret, ideally with some special chars in it
    - the TOKEN_SECRET will get used to create and verify your login tokens
- Import your code from GitHub
  - Go to tab "Deploy"
  - Deployment method: Choose "GitHub"
  - Pick / Import your PHP Laravel repo from GitHub
- Manual Deploy => deploy branch
  - You can also activate automatic deploys
  - Then on each push to your Repo, Heroku will deploy the new stuff automatically- 
- Once the deploy ran through => click "Open App"
- Test your /api/animals route if it shows the data from your DB
- DONE!


### Use free Postgres database on Heroku

The freesqldatabase has a limit of 5 MB. It is ideal for local development, but not that much for usage in production.

- In Tab "Overview" click the link "Configure Add-ons" 
- In Section "Add-Ons" => search in the Input field for "Heroku Postgres"
- Activate the Add-On
- Now a Postgres database will get created for your app
- Go to Settings => Reveal Config vars
- You should see a new key "DATABASE_URL" which points to the Postgres DB
- Change key DB_CONNECTION from "mysql" to "pgsql"
- Now your API should connect to your postgres DB instead
- Now click "Open App"
- Navigate to "/api/animals" - probably the list is empty
- In requests.http => configure the API_URL to point to your heroku app
  - ideally comment out the API_URL pointing to localhost
- Now execute a POST request to /api/animals to create a new animal into the postgres DB
- Check the /api/animals route in the browser if it worked!

