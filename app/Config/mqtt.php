<?php

return [
    'connectionSettings' => (new \PhpMqtt\Client\ConnectionSettings)

        // The username used for authentication when connecting to the broker.
        ->setUsername(getenv('MQTT_USERNAME'))

        // The password used for authentication when connecting to the broker.
        ->setPassword(getenv('MQTT_PASSWORD'))

        // Whether to use a blocking socket when publishing messages or not.
        // Normally, this setting can be ignored. When publishing large messages with multiple kilobytes in size,
        // a blocking socket may be required if the receipt buffer of the broker is not large enough.
        //
        // Note: This setting has no effect on subscriptions, only on the publishing of messages.
//        ->useBlockingSocket(false)

        // The connect timeout defines the maximum amount of seconds the client will try to establish
        // a socket connection with the broker. The value cannot be less than 1 second.
        ->setConnectTimeout(60)

        // The socket timeout is the maximum amount of idle time in seconds for the socket connection.
        // If no data is read or sent for the given amount of seconds, the socket will be closed.
        // The value cannot be less than 1 second.
        ->setSocketTimeout(5)

        // The resend timeout is the number of seconds the client will wait before sending a duplicate
        // of pending messages without acknowledgement. The value cannot be less than 1 second.
        ->setResendTimeout(10)

        // This flag determines whether the client will try to reconnect automatically
        // if it notices a disconnect while sending data.
        // The setting cannot be used together with the clean session flag.
        ->setReconnectAutomatically(false)

        // Defines the maximum number of reconnect attempts until the client gives up.
        // This setting is only relevant if setReconnectAutomatically() is set to true.
        ->setMaxReconnectAttempts(3)

        // Defines the delay between reconnect attempts in milliseconds.
        // This setting is only relevant if setReconnectAutomatically() is set to true.
        ->setDelayBetweenReconnectAttempts(0)

        // The keep alive interval is the number of seconds the client will wait without sending a message
        // until it sends a keep alive signal (ping) to the broker. The value cannot be less than 1 second
        // and may not be higher than 65535 seconds. A reasonable value is 10 seconds (the default).
        ->setKeepAliveInterval(10)

        // If the broker should publish a last will message in the name of the client when the client
        // disconnects abruptly, this setting defines the topic on which the message will be published.
        //
        // A last will message will only be published if both this setting as well as the last will
        // message are configured.
        ->setLastWillTopic(null)

        // If the broker should publish a last will message in the name of the client when the client
        // disconnects abruptly, this setting defines the message which will be published.
        //
        // A last will message will only be published if both this setting as well as the last will
        // topic are configured.
        ->setLastWillMessage(null)

        // The quality of service level the last will message of the client will be published with,
        // if it gets triggered.
        ->setLastWillQualityOfService(0)

        // This flag determines if the last will message of the client will be retained, if it gets
        // triggered. Using this setting can be handy to signal that a client is offline by publishing
        // a retained offline state in the last will and an online state as first message on connect.
        ->setRetainLastWill(false)

        // This flag determines if TLS should be used for the connection. The port which is used to
        // connect to the broker must support TLS connections.
        ->setUseTls(false)

        // This flag determines if the peer certificate is verified, if TLS is used.
        ->setTlsVerifyPeer(true)

        // This flag determines if the peer name is verified, if TLS is used.
        ->setTlsVerifyPeerName(true)

        // This flag determines if self signed certificates of the peer should be accepted.
        // Setting this to TRUE implies a security risk and should be avoided for production
        // scenarios and public services.
        ->setTlsSelfSignedAllowed(false)

        // The path to a Certificate Authority certificate which is used to verify the peer
        // certificate, if TLS is used.
        ->setTlsCertificateAuthorityFile(null)

        // The path to a directory containing Certificate Authority certificates which are
        // used to verify the peer certificate, if TLS is used.
        ->setTlsCertificateAuthorityPath(null)

        // The path to a client certificate file used for authentication, if TLS is used.
        //
        // The client certificate must be PEM encoded. It may optionally contain the
        // certificate chain of issuers.
        ->setTlsClientCertificateFile(null)

        // The path to a client certificate key file used for authentication, if TLS is used.
        //
        // This option requires ConnectionSettings::setTlsClientCertificateFile() to be used as well.
        ->setTlsClientCertificateKeyFile(null)

        // The passphrase used to decrypt the private key of the client certificate,
        // which in return is used for authentication, if TLS is used.
        //
        // This option requires ConnectionSettings::setTlsClientCertificateFile() and
        // ConnectionSettings::setTlsClientCertificateKeyFile() to be used as well.
        ->setTlsClientCertificateKeyPassphrase(null)

        // The TLS ALPN is used to establish a TLS encrypted mqtt connection on port 443,
        // which usually is reserved for TLS encrypted HTTP traffic.
        ->setTlsAlpn(null)

];