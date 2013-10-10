<?php

namespace Irc;

class Message {

    public $nick = null;
    public $name = null;
    public $host = null;
    public $command = '';
    public $args = array();

    public function __construct( $command, $args = array(), $prefix = null ) {

        $this->command = $command;
        $this->args = $args;
        
        if( !empty( $prefix ) ) {

            if( strpos( $prefix, '!' ) !== false ) {

                $parts = preg_split( '/[!@]/', $prefix );
                $this->nick = !empty( $parts[ 0 ] ) ? $parts[ 0 ] : '';
                $this->name = !empty( $parts[ 1 ] ) ? $parts[ 1 ] : '';
                $this->host = !empty( $parts[ 2 ] ) ? $parts[ 2 ] : '';
            } else {

                $this->nick = $prefix;
            }
        }
    }

    public function __toString() {

        $args = array_map( 'strval', $this->args );
        $len = count( $args );
        $last = $len - 1;

        if( $len > 0 && ( strpos( ' ', $args[ $last ] ) !== -1 || $args[ $last ][ 0 ] === ':' ) ) {

            $args[ $last ] = ':'.$args[ $last ];
        }

        $prefix = $this->getHostString();

        array_unshift( $args, $this->command );
        if( !empty( $prefix ) )
            array_unshift( $args, ":$prefix" );

        return implode( ' ', $args );
    }

    public function getHostString() {

        $str = "$this->nick";

        if( !empty( $this->name ) )
            $str .= "!$this->name";

        if( !empty( $this->host ) )
            $str .= "@$this->host";

        return $str;
    }

    public function getArg( $index, $defaultValue = null ) {

        return !empty( $this->args[ $index ] ) ? $this->args[ $index ] : $defaultValue;
    }

    public static function parse( $message ) {

        $message = trim( $message );

        if( empty( $message ) )
            return null;

        $prefix = '';
        $command = '';
        $args = array();
        $matches = array();

        if( preg_match( '/^
            (:(?<prefix>[^ ]+)\s+)?     #the prefix (either "server" or "nick!user@host")
            (?<command>[^ ]+)           #the command (e.g. NOTICE, PRIVMSG)
            (?<args>.*)                 #The argument string
        $/x', $message, $matches ) ) {

            $matches = array_map( 'trim', $matches );

            if( !empty( $matches[ 'prefix' ] ) )
                $prefix = $matches[ 'prefix' ];

            if( !empty( $matches[ 'command' ] ) )
                $command = $matches[ 'command' ];

            if( !empty( $matches[ 'args' ] ) ) {
                if( strpos( $matches[ 'args' ], ' :' ) !== false ) {
                    $parts = explode( ' :', $matches[ 'args' ], 2 );
                    $args = explode( ' ', $parts[ 0 ] );
                    $args[] = $parts[ 1 ];
                } else if( strpos( $matches[ 'args' ], ':' ) === 0 )
                    $args[] = substr( $matches[ 'args' ], 1 );
                else
                    $args = explode( ' ', $matches[ 'args' ] );
            }

            $args = array_values( array_filter( $args, function( $val ) {

                $val = trim( $val );
                return !empty( $val );
            } ) );
        } else
            return new Message( 'UNKNOWN', array( $message ) );

        return new Message( $command, $args, $prefix );
    }
}