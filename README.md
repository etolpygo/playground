## Sample Laravel 10 API ##

### Features overview ###
* CRUD jobs, basic Jobs API resources
* POST api/jobs/import endpoint allowing import of a csv jobs file by an authenticated user
* Wrapper import job saves an Import record tagged with the currently authenticated user and dispatches a batch of individual import, one per each csv line
* Notify admin event is fired after all jobs complete
* Email is configured to be sent to the Log


### Running the app ###
* cp .env.example .env
* php artisan migrate:fresh --seed
* php artisan serve

Application is now available at http://127.0.0.1:8000/

### Endpoints ###
public:
* GET http://127.0.0.1:8000/api/jobs
* GET http://127.0.0.1:8000/api/jobs/{job_id}
* POST http://127.0.0.1:8000/api/login - login with email of any seeded user and password 'password'

authenticated:
* POST http://127.0.0.1:8000/api/jobs
* POST http://127.0.0.1:8000/api/jobs/import
* PUT|PATCH http://127.0.0.1:8000/api/jobs/{job}
* DELETE http://127.0.0.1:8000/api/jobs/{job} 

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
