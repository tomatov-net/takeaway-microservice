## Takeaway Medior PHP developer test

For current task I decided to use **Laravel** just to save some time, because I use it more often on daily basis, 
rather than Lumen and Symfony. But for real project I would be choose something different, like **Symfony**, **Lumen**, or maybe *Node* with **Express.js**. 

###Run the project
1. `docker-compose up --build`
2. `docker exec -it takeaway-test-app-fpm bash`
 - `composer install && cp .env.example .env`
 - `php artisan migrate --seed`

`phpunit` or `phpunit --filter` to run the tests

###Todo

1. Initial laravel and docker installing
2. Models, migrations and seeders creation
3. Services integration
4. REST API creation
5. Repositories adding
6. Tests running
7. Pushing to github

##Docker
First things first, we need to run our app, so we need a docker.
I added a few images there:
- app-nginx to manage requests/responses
- app-fpm to compile php code
- app-db to store data
- app-fpm-cron to run cron jobs

I have had some troubles with running a docker in the same container with php-fpm.
So I decided to take it out into separate container, with its own php-fpm instance.

##Database
I designed database like this:
[link](https://dbdiagram.io/d/5decf22cedf08a25543ed685)

Delivery time of each restaurant I put into separated table, bounded by foreign key.
Messages and message types are also stored into db.


I think there should be also *OrderStatus* model, connected with orders,
but to save time I decided to pass it.


###SMS-services
I integrated 2 services: Nexmo and Twilio.
Both have own components with composer support, but I decided to use Guzzle library, based on CURL to minimize composer dependencies amount.

To add new service all you need is:
 - add credentials to .env file;
 - link these credentials in config/services.php (sms.providers block);
 - in app/Services/TransportProviders add new class, which implements TransportProviderInterface;
 - profit!
 
All SMS responses are logged by Laravel native Log::info() method. On real life project it should be changed to database storing.

###REST API
[Documentation by OpenAPI standarts](https://app.swaggerhub.com/apis/tomatov.net/TakeawayTestAPI/1.0.0?loggedInWithGitHub=true)

Also there're files in the root of project: **openapi.json** and **openapi.yaml**.


There're next API endpoints:
- POST /api/orders/create
- POST /api/orders/confirm/{id} 
- POST /api/orders/deliver/{id}

Also, it will be good to add endpoints like ```['show', 'cancel', 'delete', 'update']``` to this list.
But like I said, it's matter of time.

`create` (fires by client, who wants to taste some good food :) endpoint creates new order by `restaurant_id` body parameter.


#####All next endpoints are fired by system operator.

`confirm` endpoint sets the `deliver_before` time, depending on restaurant delivery time value.
In current project there's only one value per restaurant, stored in `delivery_times` table.
But on real project it could be much more, depending on:
- time
- day of week
- street traffic state
- distance between client and restaurant
- weather 
- ~~system operator mood~~ :)
- etc

Here initial message with order information is created and being sent to client.

I decided to use queue for external APIs calling. In current project I do not use any `supervisor` and `Redis` tools to
make queues smooth and fast, but on real project it's strongly recommended to use them, or something like them.


`deliver` endpoint - is used to mark order as delivered to customer. From `deliver_before` time 
cron job starts check and compare current record, to send final message to customer.
 
 
After 90 minutes from `deliver_before`, customer gets final the message on his phone.


###Repositories
All db operations with models I decided to put into separated classes in **app/Repositories**.

Laravel scope queries I put into **app/Models/ScopeQueries** traits, to make code of model cleaner and shorter.

I also wanted to create Symfony-like Entities with getters and setters for each table.
With repositories and entities current project could be more independent from database, and could be used just like service.

But it would be last long, and I refused to do it.

###Tests
Tests could be run via `phpunit` command. I wrote several tests, which cover API,
sms sending, 



 


 



