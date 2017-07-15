# SMS Sender - Web

The web app for the SMS sender.


## Usage

### Web

* Inside `config/prod.php` you should change your token to something unique
* First you'll need to create the (SQLite) database. For that, go to `http://[PROJECT-PATH]/web/database/create?token=[YOUR-TOKEN]`
* To send the SMS, go to the following page: `http://[PROJECT-PATH]/web/api/send?token=[YOUR-TOKEN]&to=+122111222&message=Hello+World`

### Mobile

* Open the mobile application
* Enter your URL (for example: `http://[PROJECT-PATH]/web`) and token (for example: `very_unique_token`)
* Click connect
* If everything goes well, you will be connected. The device will check every 15 seconds the queue, and if there is any new SMS there, it will send it


## How does it work

* You make a API request to the server, that saves the message and the number of the recipient
* The mobile app checks every X seconds if there is a new SMS in the queue. If there is, it will send it to the recipient (the oldest SMSes will be sent first)


## License

SMS Sender is licensed under the MIT license.
