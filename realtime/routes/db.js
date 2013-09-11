var mongo = require('mongoose');
var Schema = mongo.Schema;

exports.connect = function(callback) {
	mongo.connect('mongodb://localhost/test');
}

exports.close = function(callback) {
	mongo.disconnect();
}

// data schema
var dataSchema = new Schema({
	_id : Number,
	room_id : String,
	user_id : Number,
	data : String,
	time : Number
});
dataSchema.static.findAndModify = function (query, sort, doc, options, callback) {
    return this.collection.findAndModify(query, sort, doc, options, callback);
};

// data model
mongo.model('data', dataSchema);
var dataModel = mongo.model('data');

exports.add = function(room_id, user_id, data, callback) {
mongo.runCommand(
               {
                 findAndModify: "people",
                 query: { name: "Gus", state: "active", rating: 100 },
                 sort: { rating: 1 },
                 update: { $inc: { score: 1 } },
                 upsert: true
               }
             );
	var dm = new dataModel();
	dm._id = 1110;
	dm.room_id = room_id;
	dm.user_id = user_id;
	dm.data = data;
	dm.time = Math.round(new Date().getTime() / 1000);
	dm.save();
	//console.log(room_id + ' ' + user_id + ' ' + data + ' ' + new Date());
}
