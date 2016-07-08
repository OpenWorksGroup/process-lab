import React from 'react';
import ReactDOM from 'react-dom';
import TemplateSetUp from './Class/template_setup.jsx';
import CourseEditor from './Class/template_course_editor.jsx';
import TagsEditor from './Class/template_tags_editor.jsx';
import SectionsEditor from './Class/template_sections_editor.jsx';
import RubricEditor from './Class/template_rubric_editor.jsx';

var TemplateForm = React.createClass({
	getInitialState: function() {
    var templateInfo = {},editId;
    if (this.props.templateInfo) {
      templateInfo = JSON.parse(this.props.templateInfo);
      editId = templateInfo['id'];
    }

    	return {
      		id: this.props.id,
          editId: editId
    	};
    },
	addId: function(id) {
    this.state.id << id;
    this.setState({id: id});
  },
	render: function() {
    	return (
      		<div>
        		<TemplateSetUp templateInfo={this.props.templateInfo} addId={this.addId}/>
            <CourseEditor courseInfo={this.props.courseInfo} editId={this.state.editId} id={this.state.id}/>
            <TagsEditor tags={this.props.tags} editId={this.state.editId} id={this.state.id}/>
            <SectionsEditor 
            sections={this.props.sections} 
            sectionsFields={this.props.sectionsFields} 
            editId={this.state.editId} 
            id={this.state.id}/>
            <RubricEditor 
            rubric={this.props.rubric} 
            rubricCompetencies={this.props.rubricCompetencies}
            editId={this.state.editId} 
            id={this.state.id}/>

      		</div>
    	);
  	}

});

module.exports = TemplateForm;