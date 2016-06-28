import React from 'react';
import ReactDOM from 'react-dom';
import TagsEditor from '../Class/template_tags_editor.jsx';

var GradeTags = React.createClass({

	render: function() {
    	return (
      		<div>
        		<TagsEditor id={1234}/>
      		</div>
    	);
  	}

});


module.exports = GradeTags;