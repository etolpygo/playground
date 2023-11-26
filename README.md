## Sample Laravel 10 API ##

* CRUD jobs, basic Jobs resources
* POST api/jobs/import endpoint allowing import of csv jobs file by an authenticated user
* Wrapper import job saves an import record tagged with the currently authenticated user and dispatches a batch of jobs, one per each import line
* Notify admin event is fired after all jobs complete
* Email is configured to be sent via log


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
