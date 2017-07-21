# SMS Sender

A home-made API for sending SMS. Meant for development purposes.


## Usage

### Web

* Inside `config/prod.php` you should change your token to something unique
* First you'll need to create the (SQLite) database. For that, go to `http://[MY-IP]/sms-sender/web/database/create?token=[YOUR-TOKEN]`
* To send the SMS, go to the following page: `http://[MY-IP]/sms-sender/web/api/send?token=[YOUR-TOKEN]&to=+122111222&message=Hello+World` (in a real world scenario, you will rather make an AJAX request to that page)

### Mobile

* Navigate to the `mobile/` directory and build the app: `cordova build`
* You will find the apk in `mobile/platforms/android/build/outputs/apk`
* Install that APK on your mobile device
* Open the application
* Enter your URL (for example: `http://[MY-IP]/sms-sender/web`) and token (for example: `very_unique_token`)
* Click connect
* If everything goes well, you will be connected. The device will check every 15 seconds the queue, and if there is any new SMS there, it will send it to the number you spefified


## How does it work

* You make a API request to the server, that saves the message and the number of the recipient
* The mobile app checks every X seconds if there is a new SMS in the queue. If there is, it will send it to the recipient (the oldest SMSes will be sent first)


## Additional notes

**THIS IS ONLY MEANT FOR DEVELOPMENT. USE IT WITH CAUTION. CARRIER FEES WILL APPLY. TO BE SAFE, ONLY EVER USE THIS WITH PREPAID SIM CARDS / PACKAGES!**

> The idea behind this project was, me having a prepaid SIM card, that I used for testing before.
> Then I started working on some Two-Factor authentication stuff, which (at least apart of it) was also the SMS confirmation/authorization.
> So for that reason (& because it was the cheapest option), I quickly wrote this app to assist me with the project.
> For production projects, you should probably rather use actual SMS services, such as [Twilio](https://www.twilio.com), [plivo](https://www.plivo.com), [smsglobal](http://smsglobal.com), or any other SMS service.

## License

SMS Sender is licensed under the MIT license.
