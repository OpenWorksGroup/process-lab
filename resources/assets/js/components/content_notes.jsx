import React from 'react';
import ReactDOM from 'react-dom';
import ContentNote from './Class/content_note_field.jsx';

var ContentNotesForm = React.createClass({
	render: function() {
    	return (
      		<div>
        		<ContentNote
            contentId={this.props.contentId}
            notes={this.props.notes} 
            />
      		</div>
    	);
  	}

});

module.exports = ContentNotesForm;