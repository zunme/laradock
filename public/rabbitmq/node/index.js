var http    = require('http');
var url     = require('url');
var amqp = require('amqplib/callback_api');
//var querystring = require('querystring');

var port    = 8081; // port

http.createServer(function(req, res){
    var path = url.parse(req.url).pathname;
    var queryData = url.parse(req.url, true).query;

    if(path!='/msg'){
    	  res.writeHead(400, {"Content-Type": "application/json"});
       var data = JSON.stringify({"error": "invalid request"});
       return res.end(data);
    }
	req.on('data', function(data){
	});

      req.on('end', function(){
        amqp.connect('amqp://172.17.0.1', function(err, conn) {
		  conn.createChannel(function(err, ch) {
		    var q = 'SMS';
		    //var msg = process.argv.slice(2).join(' ') || path;
		    var msg = JSON.stringify(queryData)
		    ch.assertQueue(q, {durable: true});
		    ch.sendToQueue(q, new Buffer(msg), {persistent: true});
		    //console.log(" [x] Sent '%s'", msg);
		  });
		  setTimeout(function() { conn.close(); }, 500);
		});
        res.writeHead(200, {"Content-Type": "application/json"});
        return res.end();
      });

}).listen(port);

console.log("Server listening at " + port);
