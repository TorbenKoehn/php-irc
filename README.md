# PHP IRC Bot

Nothing special, really.

## What is this?

This is a IRC Client and/or Bot written in PHP.
It should be called via the CLI (Command-Line Interface)


## How to use it?

Create a new bot instance (Or client, Bot actually has no functionality right now)

    $bot = new Irc\Bot( 'MyAwesomeBot', 'irc.example.com' );

and connect it

    $bot->connect();

You can listen to some events and react to them

    $bot->on( 'chat', function( $e, $bot ) {

        $bot->chat( $e->channel, 'Heeeey, youve written something!!' );
    } );


Now open a console and fire this thing up

    $ php my-bot-file.php

There are a ton of possible events and methods to call on the bot.
A tiny documentation of them can be found below.

## Status

This thing may have bugs. Actually, it may have a shitload of bugs because I didn't test most of its features.
What I know is, that it works. It can connect, it sends events, it can react to them.
It can communicate with your IRC server just fine.
Everything else is missing development time.

## Events

All event callbacks should have 2 parameters

    function( $e, $bot )

or

    function( $e, $client )

`$e` is always an object with some properties that contain event specific data (Event Args)
`$client` is always the sender of the event (The Bot/Client, that called it)


### connecting, disconnecting
Triggers, when the client starts (dis)connecting

### connected, disconnected
Triggers, whent the client is (dis)connected

### reconnecting
Triggers, when the client was disconnected by force and tries reconnecting

### tick
Triggers permanently in the receive-loop. Actually, don't use this (unless you specified a tickInterval, not recommended)

### message, message:[Command]
Triggers, when the client receives any kind of message from the IRC server.
You can access `$e->message` to get the message instance, `$e->raw` to get the raw message sent.

Command is the actual command send by the IRC server.
You can find them here: http://tools.ietf.org/html/rfc2812

### send, send:[Command], sent, sent:[Command]
Triggers, when the client sends or sent a message (respectively)
Provides `$e->message` and `$e->raw`

### join, join:[Channel], join:[Nick], join:[Channel]:[Nick]
Triggers, when someone joins a channel you're in (Including yourself).
Provides `$e->nick` and `$e->channel` for you to work with.

### part, part:[Channel], part:[Nick], part:[Channel]:[Nick]
Same as join, but for leaving a channel (/part)
Provides `$e->nick` and `$e->channel`.

### kick, kick:[Channel], kick:[Nick], kick:[Channel]:[Nick]
Same as join/part, but for users getting kicked out of a channel
Provides `$e->nick` and `$e->channel`.

### notice, notice:[To], notice:[From], notice:[To]:[From]
Received when someone sends a notice (Probably to yourself, so [To] is pretty useless now that I see it...)
Provides `$e->from`, `$e->to` and `$e->text`. Text is the raw string of text the user sent.

### chat, chat:[Channel], chat:[Channel]:[Nick]
Received when someone sends something in a channel.
Provides `$e->from`, `$e->channel` and `$e->text`.

### pm, pm:[To], pm:[To]:[From]
Received when someone sends you a PM.
Same as notice actually.

### names, names:[Channel]
Received when a NAMES request for a channel was finished.
Provides `$e->names` contains an object with a `names` and a `channel` property.
Self-explanatory

### list
Received when a LIST request is finished.
Provides `$e->list` which contains an associative array of channels (keys) and channel data (values).
Channel data contains `userCount`, `topic` and `channel` for you to do awesome stuff with it.

### welcome
Triggers, whent he server recognizes the client and its authentication the first time.
This should be your main entry point for everything.
Don't send stuff, before you got this event. It works, but it makes no sense.

### options
Triggers, when the client received an ISUPPORT request that contains a bunch of options of the server.
The client parses and saves those cleanly for you to do something with it.
Some client methods rely on them (isChannel(), isUser() etc.)


Awesome, isn't it?

Now...

## Methods

These are the methods you can call on your `$bot`-Object.
I won't explain all of them, since the method name is somewhat self-explanatory

### getNick()/setNick( string $nickName )

### getName()/setName( string $name )

### getRealName()/setRealName( string $realName )

### getServerPassword()/setServerPassword( string $password )

### getReconnectInterval()/setReconnectInterval( int $intervalInMilliseconds )

### getTickInterval()/setTickInterval( int $intervalInMilliseconds )

### enableReconnection()/disableReconnection()

### enableRawMode()/disableRawMode()
The client usually cares about pings etc. automatically, you don't need to handle that.
But you can! RawMode disables automatic handling and you can handle everything by yourself.
This also disables some events, such as names, list, welcome, options, notice, pm, chat etc.
The `message` event will still work, though.

### getOption( string $option )/getOptions()
Gets a server option. Just dump getOptions() once you're connected to see what options there are.

### inOptionValues( string $option, mixed $value )/inOptionKeys( string $option, mixed $value )
Checks if some value is contained in either they keys of an array option or the values.

### isChannel( string $nick )/isUser( string $nick )
Checks, if the nick provided is a channel or a user. This respects received server options.

### connect()/disconnect()/reconnect()
Does exactly what you think it does

### send( string $command [, string $arg1 [, string $arg2 [, ...] ] ] )
Automatically formats your desired message parameters and sends them to the IRC server.
This is the main communication method.
If you want to send something, send it with this!
e.g. `$bot->send( 'PRIVMSG', 'SomeOtherNick', 'Heey, this is a private message. Awesome, isn\'t it? ' )`

### sendPrefixed( string $prefix, string $command [, string $arg1 [, string $arg2 [, ...] ] ] )
Some messages require a prefix which is your own user in most cases.
Right now you gotta put this together by yourself.
It's either a hostname (`irc.devmonks.net`) or a user (`nickName!userName@userHost`)

### join( mixed $channel [, string $password ] )
Join a channel. Eats either one channel string, an array of channels or an associative array with channel names as keys and passwords as values.

### part( mixed $channel )
Leaves a channel. Can eat either one channel string or an array of channels.

### names( mixed $channel )
Sends a NAMES request to one or more channels (array of channels if you want more).
NAMES replies with some basic channel info, like the users that are in it and their operator status

### list( [ mixed $channel[, string $server ] ] )
Same as names(), but can also be called for the whole server.
Just calling `$bot->list()` will list all channels on the server.

### chat( string $channel, string $message ), pm( string $channel, string $message )
chat should be used for channels, pm for users, but actually, it doesn't matter at all.
This sends a message to either a channel or a user (private message)

### nick( string $nick )
Sets a new nick name for the client.



That was it!

If you want to know more about this, you may contact me anytime.
Merge requests for new features are welcome.

