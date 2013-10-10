<?php

namespace Irc;

class Socket extends EventEmitter {

    const DEFAULT_TIMEOUT = .3;

    protected $handle;
    protected $server;
    protected $port;
    protected $timeOut = 3;
    protected $bufferSize = 1024;

    public function __construct( $server, $port, $timeOut = self::DEFAULT_TIMEOUT ) {

        $this->server = $server;
        $this->port = $port;
        $this->timeOut = $timeOut;
    }

    public function connect() {

        $this->emit( 'connecting', array( 'server' => $this->server, 'port' => $this->port ) );
        $errNo = null;
        $errStr = null;
        $this->handle = @fsockopen( 
            strval( $this->server ), 
            intval( $this->port ), 
            $errNo, 
            $errStr, 
            floatval( $this->timeOut ) 
        );

        if( !$this->isConnected() ) {

            throw new SocketException( "Failed to connect($errNo): $errStr" );
        }

        $this->emit( 'connected', array( 'server' => $this->server, 'port' => $this->port ) );

        return $this;
    }

    public function disconnect() {

        $this->emit( 'disconnecting', array( 'server' => $this->server, 'port' => $this->port ) );

        if( $this->isConnected() )
            fclose( $this->handle );

        $this->emit( 'disconnected', array( 'server' => $this->server, 'port' => $this->port ) );

        return $this;
    }

    public function isConnected() {

        return is_resource( $this->handle );
    }

    public function send( $message ) {

        fputs( $this->handle, $message );

        return $this;
    }

    public function sendLine( $message ) {

        fputs( $this->handle, "$message\r\n" );

        return $this;
    }

    public function receive( $len = 32 ) {

        return fread( $this->handle, $len );
    }

    public function receiveLine() {

        return fgets( $this->handle, $this->bufferSize );
    }
}