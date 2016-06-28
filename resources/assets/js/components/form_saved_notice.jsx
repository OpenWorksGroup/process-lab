import React from 'react';
import ReactDOM from 'react-dom';
var Crouton = require('react-crouton');

var FormSavedNotice = React.createClass({
	render: function() {

        return (
        	<div>
        	<Crouton
        	id={Date.now()}
        	type="info"
   			message="Your changes have been saved."
   			timeout={3000}
   			/>
   			</div>
        );
    }
});

module.exports = FormSavedNotice;