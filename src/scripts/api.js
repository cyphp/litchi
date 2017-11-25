/**
 * @description This module communicates with Lychee's API
 */

api = {

	path    : 'http://litchi.dev/',
	onError : null

}

api.post = function(fn, params, callback) {

	loadingBar.show()

	params = {...params, function: fn}

	const success = (data) => {

		setTimeout(loadingBar.hide, 100)

		// Catch errors
		if (typeof data==='string' && data.substring(0, 7)==='Error: ') {
			api.onError(data.substring(7, data.length), params, data)
			return false
		}

		callback(data)

	}

	const error = (jqXHR, textStatus, errorThrown) => {

		api.onError('Server error or API not found.', params, errorThrown)

	}

	$.ajax({
		type: 'POST',
		url: api.path,
		data: params,
		dataType: 'json'
	}).done(success).fail(error);

}

api.auth = (method = 'POST', params, callback) => {
	loadingBar.show();

	let fn;

	switch (method) {
		case 'POST':
			fn = 'Session::login';
			break;
		case 'GET':
			fn = 'Session::init';
			break;
		case 'DELETE':
			fn = 'Session::logout';
			break;
	}

	$.ajax({
		type: method, // method,
		url: api.path + 'auth/',
		data: {...params, fn},
		dataType: 'json'
	}).done((data) => {
		setTimeout(loadingBar.hide, 100);

		// Catch errors
		if (typeof data==='string' && data.substring(0, 7)==='Error: ') {
			api.onError(data.substring(7, data.length), params, data);
			return false;
		}

		callback(data);
	}).fail((jqXHR, textStatus, errorThrown) => {
		api.onError('Server error or API not found.', params, errorThrown);
	});
};
