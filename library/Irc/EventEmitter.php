<?php

namespace Irc;

class EventEmitter {

    protected $eventCallbacks = array();
    protected $onceEventCallbacks = array();

    public function on( $event, $callback ) {

        if( strpos( $event, ',' ) !== false ) {

            $events = explode( ',', $event );
            foreach( $events as $event ) {

                $this->on( trim( $event ), $callback );
            }
            return $this;
        }

        if( empty( $this->eventCallbacks[ $event ] ) )
            $this->eventCallbacks[ $event ] = array();

        $this->eventCallbacks[ $event ][] = $callback;

        return $this;
    }

    public function off( $event, $callback ) {

        if( empty( $this->eventCallbacks[ $event ] ) )
            return $this;

        $idx = null;
        foreach( $this->eventCallbacks[ $event ] as $key => $cb )
            if( $callback === $cb ) {
                $idx = $key;
                break;
            }

        array_splice( $this->eventCallbacks, $idx, 1 );

        return $this;
    }

    public function once( $event, $callback ) {

        if( empty( $this->onceEventCallbacks[ $event ] ) )
            $this->onceEventCallbacks[ $event ] = array();

        $this->onceEventCallbacks[ $event ][] = $callback;

        return $this;
    }

    public function emit( $event, $args = array() ) {

        if( strpos( $event, ',' ) !== false ) {

            $events = explode( ',', $event );
            foreach( $events as $event ) {

                $this->emit( trim( $event ), $args );
            }
            return $this;
        }

        $args[ 'time' ] = time();
        $args[ 'event' ] = $event;
        $args[ 'sender' ] = $this;

        if( !empty( $this->onceEventCallbacks[ $event ] ) ) {

            foreach( $this->onceEventCallbacks[ $event ] as $callback )
                call_user_func( $callback, (object)$args, $this );
            $this->onceEventCallbacks[ $event ] = array();
        }

        if( !empty( $this->eventCallbacks[ $event ] ) ) {

            foreach( $this->eventCallbacks[ $event ] as $callback )
                call_user_func( $callback, (object)$args, $this );
        }

        return $this;
    }
}