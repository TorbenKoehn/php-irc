<?php

namespace Irc;

class Client extends Socket {

    const DEFAULT_PORT = 6667;

    const CMD_PING = 'PING';
    const CMD_PONG = 'PONG';
    const CMD_PASS = 'PASS';
    const CMD_NICK = 'NICK';
    const CMD_USER = 'USER';
    const CMD_JOIN = 'JOIN';
    const CMD_PART = 'PART';
    const CMD_NAMES = 'NAMES';
    const CMD_LIST = 'LIST';
    const CMD_PRIVMSG = 'PRIVMSG';
    const CMD_NOTICE = 'NOTICE';
    const CMD_KICK = 'KICK';
    const CMD_MODE = 'MODE';
    const RPL_WELCOME = '001';
    const RPL_MYINFO = '004';
    const RPL_ISUPPORT = '005';
    const RPL_TRACELINK = '200';
    const RPL_TRACECONNECTING = '201';
    const RPL_TRACEHANDSHAKE = '202';
    const RPL_TRACEUNKNOWN = '203';
    const RPL_TRACEOPERATOR = '204';
    const RPL_TRACEUSER = '205';
    const RPL_TRACESERVER = '206';
    const RPL_TRACENEWTYPE = '208';
    const RPL_STATSLINKINFO = '211';
    const RPL_STATSCOMMANDS = '212';
    const RPL_STATSCLINE = '213';
    const RPL_STATSNLINE = '214';
    const RPL_STATSILINE = '215';
    const RPL_STATSKLINE = '216';
    const RPL_STATSYLINE = '218';
    const RPL_ENDOFSTATS = '219';
    const RPL_UMODEIS = '221';
    const RPL_STATSLLINE = '241';
    const RPL_STATSUPTIME = '242';
    const RPL_STATSOLINE = '243';
    const RPL_STATSHLINE = '244';
    const RPL_STATSCONN = '250';
    const RPL_LUSERCLIENT = '251';
    const RPL_LUSEROP = '252';
    const RPL_LUSERUNKNOWN = '253';
    const RPL_LUSERCHANNELS = '254';
    const RPL_LUSERME = '255';
    const RPL_ADMINME = '256';
    const RPL_ADMINLOC1 = '257';
    const RPL_ADMINLOC2 = '258';
    const RPL_ADMINEMAIL = '259';
    const RPL_TRACELOG = '261';
    const RPL_LOCALUSERS = '265';
    const RPL_GLOBALUSERS = '266';
    const RPL_NONE = '300';
    const RPL_AWAY = '301';
    const RPL_USERHOST = '302';
    const RPL_ISON = '303';
    const RPL_UNAWAY = '305';
    const RPL_NOWAWAY = '306';
    const RPL_WHOISUSER = '311';
    const RPL_WHOISSERVER = '312';
    const RPL_WHOISOPERATOR = '313';
    const RPL_WHOWASUSER = '314';
    const RPL_ENDOFWHO = '315';
    const RPL_WHOISIDLE = '317';
    const RPL_ENDOFWHOIS = '318';
    const RPL_WHOISCHANNELS = '319';
    const RPL_LISTSTART = '321';
    const RPL_LIST = '322';
    const RPL_LISTEND = '323';
    const RPL_CHANNELMODEIS = '324';
    const RPL_NOTOPIC = '331';
    const RPL_TOPIC = '332';
    const RPL_INVITING = '341';
    const RPL_SUMMONING = '342';
    const RPL_VERSION = '351';
    const RPL_WHOREPLY = '352';
    const RPL_NAMREPLY = '353';
    const RPL_LINKS = '364';
    const RPL_ENDOFLINKS = '365';
    const RPL_ENDOFNAMES = '366';
    const RPL_BANLIST = '367';
    const RPL_ENDOFBANLIST = '368';
    const RPL_ENDOFWHOWAS = '369';
    const RPL_INFO = '371';
    const RPL_MOTD = '372';
    const RPL_ENDOFINFO = '374';
    const RPL_MOTDSTART = '375';
    const RPL_ENDOFMOTD = '376';
    const RPL_YOUREOPER = '381';
    const RPL_REHASHING = '382';
    const RPL_TIME = '391';
    const RPL_USERSSTART = '392';
    const RPL_USERS = '393';
    const RPL_ENDOFUSERS = '394';
    const RPL_NOUSERS = '395';
    const ERR_NOSUCHNICK = '401';
    const ERR_NOSUCHSERVER = '402';
    const ERR_NOSUCHCHANNEL = '403';
    const ERR_CANNOTSENDTOCHAN = '404';
    const ERR_TOOMANYCHANNELS = '405';
    const ERR_WASNOSUCHNICK = '406';
    const ERR_TOOMANYTARGETS = '407';
    const ERR_NOORIGIN = '409';
    const ERR_NORECIPIENT = '411';
    const ERR_NOTEXTTOSEND = '412';
    const ERR_NOTOPLEVEL = '413';
    const ERR_WILDTOPLEVEL = '414';
    const ERR_UNKNOWNCOMMAND = '421';
    const ERR_NOMOTD = '422';
    const ERR_NOADMININFO = '423';
    const ERR_FILEERROR = '424';
    const ERR_NONICKNAMEGIVEN = '431';
    const ERR_ERRONEUSNICKNAME = '432';
    const ERR_NICKNAMEINUSE = '433';
    const ERR_NICKCOLLISION = '436';
    const ERR_USERNOTINCHANNEL = '441';
    const ERR_NOTONCHANNEL = '442';
    const ERR_USERONCHANNEL = '443';
    const ERR_NOLOGIN = '444';
    const ERR_SUMMONDISABLED = '445';
    const ERR_USERSDISABLED = '446';
    const ERR_NOTREGISTERED = '451';
    const ERR_NEEDMOREPARAMS = '461';
    const ERR_ALREADYREGISTRED = '462';
    const ERR_NOPERMFORHOST = '463';
    const ERR_PASSWDMISMATCH = '464';
    const ERR_YOUREBANNEDCREEP = '465';
    const ERR_KEYSET = '467';
    const ERR_CHANNELISFULL = '471';
    const ERR_UNKNOWNMODE = '472';
    const ERR_INVITEONLYCHAN = '473';
    const ERR_BANNEDFROMCHAN = '474';
    const ERR_BADCHANNELKEY = '475';
    const ERR_NOPRIVILEGES = '481';
    const ERR_CHANOPRIVSNEEDED = '482';
    const ERR_CANTKILLSERVER = '483';
    const ERR_NOOPERHOST = '491';
    const ERR_UMODEUNKNOWNFLAG = '501';
    const ERR_USERSDONTMATCH = '502';

    protected $nick = 'PHPIrc';
    protected $name = 'PhpIrcClient';
    protected $realName = 'PHP IRC Client';
    protected $serverPassword;
    protected $options = array();
    protected $reconnect = true;
    protected $reconnectInterval = 3000;
    protected $tickInterval = 0;
    protected $rawMode = false;

    public function __construct( $nick, $server, $port = self::DEFAULT_PORT ) {

        $this->nick = $nick;

        //attach basic triggers
        $this->on( 'message', array( $this, 'handleMessage' ) );
        $this->on( 'connected', array( $this, 'sendLogin' ) );

        parent::__construct( $server, $port );
    }

    public function getNick() {

        return $this->nick;
    }

    public function setNick( $nick ) {

        if( $this->isConnected() ) {

            //Change nick via NICK command
            //The response of it will change it internally then
            //It's possible that the nick is taken, we try to stay in sync
            $this->nick( $nick );
        } else {
            //Else we just change it internally directly
            $this->nick = $nick;
        }

        return $this;
    }

    public function getName() {

        return $this->name;
    }

    public function setName( $name ) {

        if( !$this->isConnected() ) {

            $this->name = $name;
        } else {

            //Set it on the next disconnect
            $this->once( 'disconnected', function( $e, $c ) use( $name ) {

                $c->setName( $name );
            } );
        }

        return $this;
    }

    public function getRealName() {

        return $this->realName;
    }

    public function setRealName( $realName ) {

        if( !$this->isConnected() ) {

            $this->realName = $realName;
        } else {

            //Set it on the next disconnect
            $this->once( 'disconnected', function( $e, $c ) use( $realName ) {

                $c->setRealName( $realName );
            } );
        }

        return $this;
    }

    public function getServerPassword() {

        return $this->serverPassword;
    }

    public function setServerPassword( $password ) {

        if( !$this->isConnected() ) {

            $this->serverPassword = $password;
        }

        return $this;
    }

    public function getReconnectInterval() {

        return $this->reconnectInterval;
    }

    public function setReconnectInterval( $interval ) {

        $this->reconnectInterval = $interval;
    }

    public function getTickInterval() {

        return $this->tickInterval;
    }

    public function setTickInterval( $interval ) {

        $this->tickInterval = $interval;

        return $this;
    }

    public function enableReconnection() {

        $this->reconnect = true;

        return $this;
    }

    public function disableReconnection() {

        $this->reconnect = false;

        return $this;
    }

    public function enableRawMode() {

        $this->rawMode = true;

        return $this;
    }

    public function disableRawMode() {

        $this->rawMode = false;

        return $this;
    }

    public function getOption( $option, $defaultValue = null ) {

        $o = strtoupper( $option );

        if( empty( $this->options[ $o ] ) )
            if( empty( $this->options[ $option ] ) )
                return $defaultValue;
            else
                return $this->options[ $option ];

        return $this->options[ $o ];
    }

    public function getOptions() {

        return $this->options;
    }

    public function inOptionValues( $option, $value ) {

        $oValue = $this->getOption( $option, array() );

        return in_array( $value, $oValue );
    }

    public function inOptionKeys( $option, $value ) {

        $oValue = $this->getOption( $option, array() );

        return in_array( $value, array_keys( $oValue ) );
    }

    public function isChannel( $nick ) {

        return $this->inOptionKeys( 'chantypes', $nick[ 0 ] );
    }

    public function isUser( $nick ) {

        return !$this->isChannel( $nick );
    }

    public function connect( $force = false ) {

        if( $this->isConnected() ) {
            //Already connected
            if( $force )
                $this->disconnect();
            else
                return $this;
        }

        parent::connect();

        //The Message Receive Task
        do {

            $this->emit( 'tick' );
            //check, if we still got a connection
            if( !$this->isConnected() ) {

                //We got disconnected!
                //Try to reconnect.
                if( $this->reconnect ) {
                    $this->emit( 'reconnecting', array( 
                        'server' => $this->server, 
                        'port' => $this->port,
                        'interval' => $this->reconnectInterval
                    ) );
                    sleep( $this->reconnectInterval );
                    $this->connect();
                    //After this point, connect() will be stuck in an endless loop in the best case.
                    //"connected" will be triggered, once it reconnects
                }
                break;
            }

            $message = trim( $this->receiveLine() );

            if( empty( $message ) )
                continue;

            $msg = Message::parse( $message );
            $this->emit( "message, message:$msg->command", array( 'message' => $msg, 'raw' => trim( $message ) ) );
            //slow this down a bit
            sleep( $this->tickInterval );
        } while( true );

        return $this;
    }

    public function reconnect() {

        return $this->disconnect()
                    ->connect();
    }

    public function send( $command ) {

        $args = func_get_args();
        unset( $args[ 0 ] );
        $args = array_values( array_filter( $args, function( $arg ) {
            $arg = trim( $arg );
            return !empty( $arg );
        } ) );

        $message = $command instanceof Message ? $command : new Message( $command, $args );
        
        if( !$this->isConnected() ) {
            //We can't send anything, when we're not connected.
            //Should we really throw an error or let the user handle it via events?
            return $this;
        }

        $this->emit( "send, send:$message->command", array( 'message' => $message ) );
        $this->sendLine( (string)$message );
        $this->emit( "sent, sent:$message->command", array( 'message' => $message ) );

        return $this;
    }

    public function sendPrefixed( $prefix, $command ) {

        $args = func_get_args();
        unset( $args[ 0 ] );
        unset( $args[ 1 ] );
        $args = array_values( array_filter( $args, function( $arg ) {
            $arg = trim( $arg );
            return !empty( $arg );
        } ) );

        $message = new Message( $command, $args, $prefix );

        return $this->send( $message );    
    }

    public function join( $channel, $password = null ) {

        $channelString = '';
        $passString = '';

        if( is_array( $channel ) ) {
            if( array_keys( $channel ) !== range( 0, count( $channel ) - 1 ) ) {
                //channel => password array
                $channelString = implode( ',', array_keys( $channel ) );
                $passString = implode( ',', array_values( $channel ) );
            } else {
                $channelString = implode( ',', $channel );
            }
        } else {

            $channelString = $channel;
            if( $password )
                $passString = $password;
        }

        $this->send( self::CMD_JOIN, $channelString, $passString );

        return $this;
    }

    public function part( $channel ) {

        $channel = is_array( $channel ) ? implode( ',', $channel ) : $channel;

        $this->send( self::CMD_PART, $channel );

        return $this;
    }

    public function names( $channel = null, $server = null ) {

        $channel = is_array( $channel ) ? implode( ',', $channel ) : $channel;

        $this->send( self::CMD_NAMES, $channel, $server );

        return $this;
    }

    public function listChannels( $channel = null, $server = null ) {

        $channel = is_array( $channel ) ? implode( ',', $channel ) : $channel;

        $this->send( self::CMD_LIST, $channel, $server );

        return $this;
    }

    public function chat( $channel, $message ) {

        $this->sendPrefixed( "$this->nick!$this->name", self::CMD_PRIVMSG, $channel, $message );

        return $this;
    }

    public function pm( $nick, $message ) {

        //actually just an alias.....
        return $this->chat( $nick, $message );
    }

    public function nick( $nick = null ) {

        if( !$nick )
            $nick = $this->nick;

        $this->send( self::CMD_NICK, $nick );
    }

    protected function handleMessage( $e ) {

        /* This one handles basic server reponses so that the user
           can care about useful functionality instead.

           You can use rawMode to disable automatic interaction in here.
        */

        if( $this->rawMode )
            return;

        $message = $e->message;
        $raw = $e->raw;

        static $namesReply = null,
               $listReply = null;
        switch( $message->command ) {
            case self::CMD_PING:    
                //Reply to pings
                $this->send( self::CMD_PONG, $message->getArg( 0, $this->server ) );
                break;
            case self::CMD_JOIN:
                //Emit channel join events
                $nick = $message->nick ? $message->nick : $this->nick;
                $channel = $message->getArg( 0 );

                $this->emit( "join, join:$channel, join:$nick, join:$channel:$nick", array( 
                    'nick' => $nick, 
                    'channel' => $channel 
                ) );
                break;
            case self::CMD_PART:
                //Emit channel part events
                $nick = $message->nick ? $message->nick : $this->nick;
                $channel = $this->addAllChannel( $message->getArg( 0 ) );

                $this->emit( "part, part:$channel, part:$nick, part:$channel:$nick", array( 
                    'nick' => $nick, 
                    'channel' => $channel 
                ) );
                break;
            case self::CMD_KICK:
                //Emit kick events
                $channel = $message->getArg( 0 );
                $nick = $message->getArg( 1 );

                $this->emit( "kick, kick:$channel, kick:$nick, kick:$channel:$nick", array( 
                    'nick' => $nick, 
                    'channel' => $channel 
                ) );
                break;
            case self::CMD_NOTICE:
                //Emit notice message events
                $from = $message->nick;
                $to = $message->getArg( 0 );
                $text = $message->getArg( 1, '' );

                $this->emit( "notice, notice:$to, notice:$to:$from", array( 
                    'from' => $from, 
                    'to' => $to, 
                    'text' => $text 
                ) );
                break;
            case self::CMD_PRIVMSG:
                //Handle private messages (Normal chat messages)
                $from = $message->nick;
                $to = $message->getArg( 0 );
                $text = $message->getArg( 1, '' );

                if( $this->isChannel( $to ) ) {

                    $this->emit( "chat, chat:$to, chat:$to:$from", array( 
                        'from' => $from, 
                        'channel' => $to,
                        'text' => $text
                    ) );
                    break;
                }

                $this->emit( "pm, pm:$to, pm:$to:$from", array( 
                    'from' => $from, 
                    'to' => $to, 
                    'text' => $text 
                ) );
                break;
            case self::RPL_NAMREPLY:

                $namesReply = (object)array(
                    'nick' => $message->getArg( 0 ),
                    'channelType' => $message->getArg( 1 ),
                    'channel' => $message->getArg( 2 ),
                    'names' => array_map( 'trim', explode( ' ', $message->getArg( 3 ) ) )
                );
            case self::RPL_ENDOFNAMES:

                if( empty( $namesReply ) )
                    break;

                $channel = $namesReply->channel;

                $this->emit( "names, names:$channel", array( 
                    'names' => $namesReply, 
                    'channel' => $channel 
                ) );
                $namesReply = null;
                break;
            case self::RPL_LISTSTART:

                $listReply = array();
                break;
            case self::RPL_LIST:

                $channel = $message->getArg( 1 );
                $listReply[ $channel ] = (object)array(
                    'channel' => $channel,
                    'userCount' => $message->getArg( 2 ),
                    'topic' => $message->getArg( 3 )
                );
                break;
            case self::RPL_LISTEND:

                $this->emit( 'list', array( 'list' => $listReply ) );
                $listReply = null;
                break;
            case self::RPL_WELCOME:
                //correct internal nickname, if given a new one by the server
                $this->nick = $message->getArg( 0, $this->nick );

                $this->emit( 'welcome' );
                break;
            case self::RPL_ISUPPORT:

                $args = $message->args;
                unset( $args[ 0 ], $args[ count( $args ) - 1 ] );

                foreach( $args as $arg ) {

                    list( $key, $val ) = explode( '=', $arg );

                    //handle some keys specifically
                    switch( strtolower( $key ) ) {
                        case 'prefix':

                            list( $modes, $prefixes ) = explode( ')', ltrim( $val, '(' ) );
                            $modes = str_split( $modes );
                            $prefixes = str_split( $prefixes );
                            $val = array();
                            foreach( $modes as $k => $v )
                                $val[ $prefixes[ $k ] ] = $v;

                            break;
                        case 'chantypes':
                        case 'statusmsg':
                        case 'elist':

                            $val = str_split( $val );
                            break;
                        case 'chanmodes':
                        case 'language':

                            $val = explode( ',', $val );
                            break;
                    }

                    $this->options[ $key ] = $val;
                }

                $this->emit( 'options', array( 'options' => $this->options ) );
                break;
        }
    }

    protected function sendLogin( $e ) {

        if( $this->rawMode )
            return;

        if( !empty( $this->serverPassword ) )
            $this->send( self::CMD_PASS, $this->serverPassword );

        if( empty( $this->name ) )
            $this->name = $this->nick;

        if( empty( $this->realName ) )
            $this->realName = $this->name;

        $this->nick();
        $this->send( self::CMD_USER, $this->name, 8, '*', $this->realName );
    }

    
}