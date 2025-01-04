const defaults = require('@wordpress/scripts/config/webpack.config');

module.exports = {
	...defaults,
	externals: {
		...defaults.externals,
		jquery: 'jQuery', // Make the 'jQuery' available from external source so that we do not have to install saperate dependency.
	},
};
