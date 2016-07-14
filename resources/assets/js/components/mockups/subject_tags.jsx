import React from 'react';
import ReactDOM from 'react-dom';
import TagsEditor from '../Class/tags_editor.jsx';

var SubjectTags = React.createClass({

	render: function() {
    	return (
      		<div>
        		<TagsEditor id={1234}/>
      		</div>
    	);
  	}

});


module.exports = SubjectTags;