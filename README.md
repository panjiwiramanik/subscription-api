postman collection included

Installation

1. use env provided in .env.example and modify the database settings with yours
2. migrate and seed database
3. open the postman collection, first subscribe to registered sites in database using Subscribers->Subscribe the site endpoint and then create new post using Site posts->store endpoint
4. the application using database queue so you have to run php artisan queue:listen