import React from 'react';
import ReactDOM from 'react-dom';
import TemplateSetUp from'./Class/template_setup.jsx';
import TagsEditor from'./Class/tags_editor.jsx';

var TemplateForm = React.createClass({
	getInitialState: function() {
    	return {
      		id: ''
    	};
    },
	addId: function(id) {
		this.state.id << id;
    	this.setState({id: id});
  	},
	render: function() {
    	return (
      		<div>
        		<TemplateSetUp addId={this.addId}/>
        		<TagsEditor id={this.state.id}/>
      		</div>
    	);
  	}

});


module.exports = TemplateForm;