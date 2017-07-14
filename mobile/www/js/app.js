var app = {
    initialize: function() {
        document.addEventListener(
            'deviceready',
            this.onDeviceReady.bind(this),
            false
        );
    },
    onDeviceReady: function() {
        // TODO
    },
    sendSMS: function(to, message) {
        var options = {
            replaceLineBreaks: false,
            android: {
                intent: '',
            }
        };
        
        sms.send(
            to,
            message,
            options,
            function() {
                // TODO: success
            },
            function() {
                // TODO: error
            }
        );
    },
};

app.initialize();
