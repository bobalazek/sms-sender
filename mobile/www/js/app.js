var app = {
    initialize: function() {
        document.addEventListener(
            'deviceready',
            app.onDeviceReady,
            false
        );
    },
    log: [],
    isConnected: false,
    url: null,
    token: null,
    processInterval: 15000,
    onDeviceReady: function() {
        $('#connect-button').on('click', app.checkStatus);

        setInterval(function() {
            if (app.isConnected) {
                app.processQueue();
            }
        }, app.processInterval);
    },
    checkStatus: function() {
        var url = $('#url-input').val();
        var token = $('#token-input').val();
        
        if (
            !url ||
            url === 'http://'
        ) {
            alert('Please enter the URL.');
            return false;
        }
        if (!token) {
            alert('Please enter the token.');
            return false;
        }

        $.get(url + '/api/ping?token=' + token)
            .done(function(data, textStatus, jqXHR) {
                if (data.error) {
                    app.handleFail(data.error.message);
                } else {
                    app.handleSuccess(
                        url,
                        token
                    );
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                app.handleFail(textStatus);
            });
    },
    handleSuccess: function(url, token) {
        app.isConnected = true;
        app.url = url;
        app.token = token;
        
        $('#connection-status')
            .removeClass('label-danger')
            .addClass('label-success')
            .text('Connected')
        ;
        
        app.addLog('Connected to the server.');
    },
    handleFail: function(error) {
        app.isConnected = false;
        app.url = null;
        app.token = null;
        
        $('#connection-status')
            .removeClass('label-success')
            .addClass('label-danger')
            .text('Not connected')
        ;
        
        app.addLog('Error: ' + error);
        
        alert(error);
    },
    addLog: function(text) {
        var $log = $('#log');
        var time = new Date().toLocaleString();
        var row = '[' + time + '] ' + text;
        app.log.push(row);

        $log.prepend('<p>' + row + '</p>');
    },
    processQueue: function() {
        app.addLog('Started processing the queue ...');
        
        $.get(
            app.url + '/api/queue/next?token=' + app.token,
            function(data) {
                if (data.error) {
                    app.addLog('Error: ' + data.error.message);
                } else {
                    if (data.data === null) {
                        app.addLog('No new SMSes found.');
                    } else {
                        app.sendSMS(data.data);
                    }
                }    
            }
        );
    },
    sendSMS: function(data) {
        var options = {
            replaceLineBreaks: false,
            android: {
                intent: '',
            }
        };

        sms.send(
            data.to,
            data.message,
            options,
            function() {
                app.addLog('Successfully sent the SMS.');

                $.get(
                    app.url +
                    '/api/process/' + data.id +
                    '?token=' + app.token
                );
            },
            function() {
                app.addLog('Could not send the SMS.');
            }
        );
    },
};

$(document).ready(function() {
    app.initialize();
});
