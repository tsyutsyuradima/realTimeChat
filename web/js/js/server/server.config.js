module.exports = {
    host : 'realtimechat',
    port : parseInt('3001'),
    origin : ' *:*',
    allowedServers : ["127.0.0.1","realtimechat"],
    dbOptions : {"driver":"dummy","config":[]},
    checkClientOrigin : 1,
    sessionVarName : 'PHPSESSID',
    socketLogFile : '/var/log/node-socket.log'
};

