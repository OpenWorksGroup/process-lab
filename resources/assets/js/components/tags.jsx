import React from 'react';
import ReactDOM from 'react-dom';
import TagsEditor from './Class/tags_editor.jsx';

var TagsForm = React.createClass({
	render: function() {
    	return (
      		<div>
        		<TagsEditor
            contentId={this.props.contentId}
            tags={this.props.tags} 
            />
      		</div>
    	);
  	}

});

module.exports = TagsForm;