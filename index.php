<?php

ini_set( 'max_execution_time', 0 );

//Autoload bootstrap
set_include_path( implode( PATH_SEPARATOR, array(
    __DIR__.'/library',
    __DIR__.'/plugins',
    get_include_path()
) ) );

spl_autoload_register( function( $class ) {
    $path = str_replace( '\\', '/', $class ).'.php';
    include $path;
    return class_exists( $class, false );
});



//The real thing.
$bot = new Irc\Bot( 'TestBot', 'irc.devmonks.net' );

    //When we started connecting
$bot->on( 'connecting', function() { 

        echo "Connecting...\n"; 
    } )

    //When we connected successfully (But didn't send the login yet!)
    ->on( 'connected', function() { 

        echo "Connected!\n"; 
    } )

    //When we send a message
    ->on( 'send', function( $e ) { 

        echo "Sending $e->message\n"; 
    } )

    //When we received a message
    ->on( 'message', function( $e ) { 

        echo "Received $e->message\n"; 
    } )

    //When we're authenticated and the server welcomes us
    ->on( 'welcome', function( $e, $bot ) {

        //We list all the channels. This will trigger the 'list' event
        $bot->listChannels();
    } )

    //This triggers once for the 'list' event
    ->once( 'list', function( $e, $bot ) {

        //Once the 'list' event is triggered, join all channels that have been listed
        $bot->join( array_keys( $e->list ) );
    } )

    //When WE joined a channel
    ->on( 'join:TestBot', function( $e, $bot ) {

        $bot->chat( $e->channel, 'What\'s up?' );
    } )

    //When there was a 'NAMES' request (Retrieve channel user infos)
    ->on( 'names', function( $e, $bot ) { } )

    //When someone writes in some channel
    ->on( 'chat', function( $e, $bot ) { 

        echo "CHAT($e->channel): $e->from: $e->text\n"; 
    } )

    //When someone writes us a PM
    ->on( 'pm', function( $e, $bot ) { 

        echo "PM($e->to): $e->from: $e->text\n"; 
    } )

    //When someone writes a notice
    ->on( 'notice', function( $e, $bot ) { 

        echo "NOTICE($e->to): $e->from: $e->text\n"; 
    } )

    //When we retrieved the server options
    ->on( 'options', function( $e, $bot ) { 

        echo "Received server options.\n"; 
    } )


    //Now finally connect that thing.
    ->connect();