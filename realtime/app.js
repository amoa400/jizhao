var express = require('express')
  , routes = require('./routes')
  , http = require('http')
  , path = require('path')
  , ejs = require('ejs')
  , db = require('mysql').createConnection({
  		host : '192.168.222.1',
		port : 3306,
		user : 'root',
		password : '123',
		database : 'interview',
		charset : 'UTF8_GENERAL_CI',
		debug : false
	});

var app = express();

// all environments
app.set('port', process.env.PORT || 3000);
app.set('views', __dirname + '/views');
app.engine('.html', ejs.__express);
app.set('view engine', 'html');
app.use(express.favicon());
app.use(express.logger('dev'));
app.use(express.bodyParser());
app.use(express.methodOverride());
app.use(app.router);
app.use(express.static(path.join(__dirname, 'public')));

// development only
if ('development' == app.get('env')) {
  app.use(express.errorHandler());
}

app.get('/', routes.index);

// db
db.connect();


var server = http.createServer(app).listen(app.get('port'), function(){
  console.log('Express server listening on port ' + app.get('port'));
});

// socket.io
var io = require('socket.io').listen(server);
io.sockets.on('connection', function(socket) {
	socket.on('join', function(data) {
		db.query("SELECT * FROM `it_session` WHERE `room_id` = '"+data.room_id+"' AND `user_id` = '"+data.user_id+"'",
			function(err, res) {
				if (err)
					throw err;
				if (res[0].session_id == data.session_id) {
					var clients = io.sockets.clients(data.room_id);
					for (var i = 0 ; i < clients.length; i++)
						if (data.user_id == clients[i].user_id) {
							clients[i].emit('error', 'You have leaved this room.');
							clients[i].leave(data.room_id);
						}
					//db.query("UPDATE `it_session` SET `session_id` = 'xxxxxxxxxx' WHERE `room_id` = '"+data.room_id+"' AND `user_id` = '"+data.user_id+"'");
					socket.user_id = data.user_id;
					socket.join(data.room_id);
					console.log(io.sockets.clients(data.room_id).length);
				}
				else
					socket.emit('error', 'Your session_id is wrong. [Please refresh this page]');
			}
		);
	});
	
	socket.on('send', function(data) {
		if (!io.sockets.manager.roomClients[socket.id]['/'+data.room]) {
			socket.emit('error', 'You have not joined this room. [Please refresh this page]');
			return;
		}
		io.sockets.in(data.room).emit('receive', {cont: data.cont});
	});

});



