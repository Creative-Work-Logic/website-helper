<?php

    class clsProject_telnet{
        use trtBasic;
        public $var=array();
        public $cls=array();
        function __construct(){
			
			
		}
            
            
        function displayAnsiFile($client, $filePath) {
            if (file_exists($filePath)) {
                $ansiArt = file_get_contents($filePath);
                socket_write($client, $ansiArt, strlen($ansiArt));
            } else {
                socket_write($client, "ANSI file not found.\n", 20);
            }
        }
    
        function create_telnet_server(){
            
            // Set the IP address and port for the server
            $address = '127.0.0.1';
            $port = 8080;
    
            // Create a TCP/IP socket
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            if ($socket === false) {
                echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
                exit;
            }
    
            // Bind the socket to the address and port
            $result = socket_bind($socket, $address, $port);
            if ($result === false) {
                echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($socket)) . "\n";
                exit;
            }
    
            // Listen for incoming connections
            $result = socket_listen($socket, 5);
            if ($result === false) {
                echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($socket)) . "\n";
                exit;
            }
    
            echo "BBS Server listening on $address:$port...\n";
    
            do {
                // Accept incoming connections
                $client = socket_accept($socket);
                if ($client === false) {
                    echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($socket)) . "\n";
                    break;
                }
    
                // Display ANSI welcome screen
                $this->displayAnsiFile($client, 'welcome.ans');
    
                // Main loop to handle client input
                while (true) {
                    $input = socket_read($client, 1024, PHP_BINARY_READ);
                    if ($input === false || $input === "") {
                        break;
                    }
    
                    $input = trim($input);
                    if ($input === 'exit') {
                        socket_write($client, "\0331;31mGoodbye!\0330m\n", 16);
                        break;
                    }
    
                    // Echo the input back to the client with ANSI color
                    $response = "\033[1;36mYou said: $input\033[0m\n";
                    socket_write($client, $response, strlen($response));
                }
    
                // Close the client socket
                socket_close($client);
            } while (true);
    
            // Close the server socket
            socket_close($socket);
        }
    }
    