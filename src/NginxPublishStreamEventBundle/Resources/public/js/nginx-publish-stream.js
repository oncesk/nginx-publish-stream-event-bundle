function createEventEmitter(obj) {
	obj._events = {};
	obj.emit = function (name, data) {
		if (name in this._events) {
			for (var i in this._events[name]) {
				this._events[name][i].call(this, [event]);
			}
		}
		return this;
	};
	obj.on = function (name, fn) {
		if (!(name in this._events)) {
			this._events[name] = [];
		}
		this._events[name].push(fn);
		return this;
	};

	obj.off = function (name, fn) {
		if (name in this._events) {
			for (var i in this._events[name]) {
				if (this._events[name][i] === fn) {
					delete this._events[name][i];
					break;
				}
			}
		}
	};
}

function NginxPublishStream(configuration) {
	this.channels = {};
	$.extend({
		host: window.location.hostname,
		port: window.location.port,
		modes : "websocket|eventsource|stream"
	}, configuration);
	this.configuration = configuration;
	this.pushStream = null;
	this.eventNameResolvers = [];
	this.addEventNameResolver(function (event) {
		if (typeof event  == 'object') {
			return 'event' in event && 'name' in event.event ? event.event.name : false;
		}
		return false;
	});
	createEventEmitter(this);
}

NginxPublishStream.prototype.addEventNameResolver = function (resolver) {
	this.eventNameResolvers.push(resolver);
	return this;
};

NginxPublishStream.prototype.resolveEventName = function (event) {
	var name = null;
	for (var i in this.eventNameResolvers) {
		if (name = this.eventNameResolvers[i](event)) {
			break;
		}
	}
	return name;
};

NginxPublishStream.prototype.channel = function (id) {
	if (id in this.channels) {
		return this.channels[id];
	}
	return this.channels[id] = new NginxChannel(id);
};

NginxPublishStream.prototype.listen = function () {
	var self = this;
	this.pushStream = new PushStream(this.configuration);
	this.pushStream.onmessage = function (json, id, channel, eventid, isLastMessageFromBatch) {
		self.channel(channel).emit('message', json);
		var eventName = self.resolveEventName(json);
		if (eventName) {
			self.channel(channel).emit(eventName, json);
		}
	};
	this.pushStream.onstatuschange = function (state) {
		switch(state) {
			case PushStream.CLOSED:
				self.emit('disconnect');
				self.pushStream.connect();
				break;

			case PushStream.CONNECTING:
				self.emit('connecting');
				break;

			case PushStream.OPEN:
				self.emit('connect');
				break;
		}
	};

	var handleEvents = function (channel) {
		channel
		.on('disconnect', function () {
			self.pushStream.removeChannel(this.getId());
		})
		.on('connect', function () {
			self.pushStream.addChannel(this.getId());
		})
		.on('publish', function (data) {
			self.pushStream.sendMessage(data);
		});
	};
	for (var i in this.channels) {
		var channel = this.channels[i];
		this.pushStream.addChannel(channel.getId());
		handleEvents(channel);
	}
	this.pushStream.connect();
};

function NginxChannel(id) {
	this.id = id;
	createEventEmitter(this);
}
NginxChannel.prototype.getId = function () {
	return this.id;
};
NginxChannel.prototype.publish = function (data) {
	if (typeof data == 'object') {
		data = JSON.stringify(data);
	}
	this.emit('publish', data);
};
NginxChannel.prototype.disconnect = function () {
	this.emit('disconnect');
};

NginxChannel.prototype.connect = function () {
	this.emit('connect');
};

var NginxManager = {

    /**
     *
     * @param key
     * @param options
     * @returns {NginxPublishStream}
     */
	get : function (key, options) {
        if (key in this.streams) {
            return this.streams[key];
        }
		var conf = NginxConfig[key];
        options = typeof options == 'object' ? $.extend(conf, options) : conf;
		return this.streams[key] = new NginxPublishStream(options);
	},

    streams : {}
};

$(function () {
	var stream =
		NginxManager.get('localhost').channel('my_channel_1').on('hello', function (event) {
		console.log('its works');
		console.log(event);
		var self = this;
		setTimeout(function () {
			self.publish('sdfsdf sd fsd ');
		}, 1000);

	});
	stream.listen();
});
