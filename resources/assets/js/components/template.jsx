import React from 'react';
import ReactDOM from 'react-dom';
import TemplateSetUp from './Class/template_setup.jsx';
import CourseEditor from './Class/template_course_editor.jsx';
import TagsEditor from './Class/template_tags_editor.jsx';
import SectionsEditor from './Class/template_sections_editor.jsx';

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
            <CourseEditor id={this.state.id}/>
        		<TagsEditor id={this.state.id}/>
            <SectionsEditor id={this.state.id}/>
      		</div>
    	);
  	}

});


module.exports = TemplateForm;