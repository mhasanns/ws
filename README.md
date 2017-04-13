# ws

## Introduction:
WebSockets is a new technology introduced in the HTML5 standard and was assigned RFC 6455. It allows clients to connect to servers
over a full-duplix connection channel, which starts with a handshake, providing a persistent connection over the connectionless HTTP
protocol.

One of the drawbacks of the WebSocket protocol is that it doesn't have an authentication technique on it's own, and so it's solely
dependant on the developer's thinking how the client-server authentication process occurs. For example, some may use session cookies,
others may user HTTP authentication. Another drawback is that WebSockets don't follow the Same Origin Policy nor Cross Site Resource
Sharing rules, allowing for cross origin attacks if the functions are not well protected on purpose by the developers.

This small app demonstrates how Cross Site WebSockets Hijacking attacks occur by showing an unprotected version of a simple handshake
and connection, and a two safe ways of doing so.

### NOTE: This app only works on Windows machines currently. I have no idea why, and at this point I'm too afraid to ask.

## Requirements:
An HTTP server is required for this app to work (Apache, Nginx, etc.), as well as PHP.

## Installation:
1- Download (or clone) this repo to your local machine and extract it into your web root<br>
2- Start your normal HTTP server and navigate to http://HOST/path/to/ws-master/app/index.php, authenticate with `admin:admin` (super secure !)<br>
3- Fire a CLI, navigate to /path/to/ws-master/server, then issue the command `php server.php`<br>
4- Follow the explanation in the pages

## Brother Abernathy:
This section was added upon <a href='https://github.com/asdizzle'>@asdizzle</a>'s request, actually he forced me to do that

<img src='https://i.imgur.com/2lZ8PHu.jpg' width='300px' height='250px' alt="Brother Abernathy">
