import React from 'react';
import ReactDOM from 'react-dom';
import _ from 'underscore';
import FormSavedNotice from '../form_saved_notice.jsx';

var classNames = require('classnames');
var templateId,savedCourse={}, submitButton="Add Course";

var CourseEditor = React.createClass({
    propTypes: {
    	template_course_id: React.PropTypes.number,
        template_id: React.PropTypes.number,
        course_id: React.PropTypes.string,
        course_title: React.PropTypes.string,
		course_url: React.PropTypes.string,
        error: React.PropTypes.object,
        success: React.PropTypes.string,
        submit_button: React.PropTypes.string
    },
    getInitialState: function() {

        var courseId,courseTitle,course_url,templateCourseId = "";

        if (this.props.editId) {
           submitButton = "Update Course";
        }

        if (this.props.courseInfo) {
            savedCourse = JSON.parse(this.props.courseInfo);
            courseId = savedCourse['course_id'];
            courseTitle = savedCourse['course_title'];
            course_url = savedCourse['course_url'];
            templateCourseId = savedCourse['id'];
        }

		return {
            template_id: templateId,
			template_course_id: templateCourseId,
			course_id: courseId,
			course_title: courseTitle,
			course_url: course_url,
            submit_button: submitButton,
      		error: undefined,
      		success: undefined
    	}
    },
    handleChange: function(e) {
        var state = {};
        state[e.target.name] =  $.trim(e.target.value);
        state['success'] = "";
        this.setState(state);
    },
    saveChange: function(e) {
    	var self;
    	e.preventDefault();
  		self = this;

        var data = {
        	course_id: this.state.course_id,
        	course_title: this.state.course_title,
        	course_url: this.state.course_url,
            template_course_id: this.state.template_course_id
        };


        data['template_id'] = templateId;
 

        if (this.state.template_course_id) {
            data['template_course_id'] = this.state.template_course_id;
        }

        this.setState({ error: {}});
        this.setState({ success: ""});

      //  console.log("DATA "+JSON.stringify(data));

        $.ajax({
            type: 'POST',
            url: '/api/admin/templates/course',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
            this.setState({ template_course_id: result['id'] });
            this.setState({success:"true"}); 
            this.setState({submit_button:"Update Course"}); 
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
           // console.log("ERROR "+JSON.stringify(error));
            this.setState({ error: error });
        }.bind(this));
    },
    render: function() {
        var fields = ["template_id","course_id","course_title","course_url"];
        var groupClass = [], successClass = [], helpBlock = [], errValue = "",idOk = false;
        var successKey = this.state.success;
        var submit_button = this.state.submit_button;

        if (this.props.id) {
           templateId = this.props.id; 
        }

        if (this.props.editId) {
           templateId = this.props.editId; 
           submitButton = "Update Course";
        }

        if (this.props.id || this.props.editId) {
           idOk = true
        }

        if (this.props.courseInfo) {
            savedCourse = JSON.parse(this.props.courseInfo);
        }

        successClass['submit_result'] = classNames({
            'text-success': true,
            'hidden': true,
            'not-hidden': successKey == "true"
        });

        var errKey = _.keys(this.state.error)[0];

        if (_.values(this.state.error)[0]) {
            errValue = _.values(this.state.error)[0][0];
        }
       
        _.each(fields, function(field){
            groupClass[field] = classNames({
                'form-group': true,
                'col-md-12': field == 'template_id',
                'col-md-3': field != 'template_id',
            	'has-error': errKey == field
            });

            if (errKey == "template_id") {
                helpBlock["template_id"] = "Please add a Title above."
            }
            else if (errKey == field) {
                helpBlock[field] = errValue;
            }
        });

        return (
            <form>
                <div>
                    {this.state.success ?
                        <FormSavedNotice/>
                    : null}
                </div>
                <div className={groupClass['course_id']}>
                    <label htmlFor='course_id' className="control-label">Course Id</label>
                    <input 
                    name="course_id" 
                    className="form-control" 
                    type="text" 
                    required={true} 
                    value={this.props.course_id} 
                    defaultValue={this.state.course_id}
                    onChange={this.handleChange} 
                    disabled ={idOk != true}
                    />
                    <span className="help-block text-danger">{helpBlock['course_id']}</span>
                </div>
                <div className={groupClass['course_title']}>
                    <label htmlFor='course_id' className="control-label">Title</label>
                    <input 
                    name="course_title" 
                    className="form-control" 
                    type="text" 
                    required={true} 
                    value={this.props.course_title} 
                    defaultValue={this.state.course_title}
                    onChange={this.handleChange} 
                    disabled ={idOk != true}
                    />
                    <span className="help-block text-danger">{helpBlock['course_title']}</span>
                </div>
                <div className={groupClass['course_url']}>
                    <label htmlFor='course_id' className="control-label">URL</label>
                    <input 
                    name="course_url" 
                    className="form-control" 
                    type="text" 
                    required={true} 
                    value={this.props.course_url} 
                    defaultValue={this.state.course_url}
                    onChange={this.handleChange} 
                    disabled ={idOk != true}
                    />
                    <span className="help-block text-danger">{helpBlock['course_url']}</span>
                </div>

                <div className="col-md-3 template-course-button">
                <button className="btn btn-default" type="submit" onClick={this.saveChange}>{submit_button}</button>
                &nbsp; <span className={successClass['submit_result']}><i className="fa fa-check"></i></span>
                </div>

                <div className={groupClass['template_id']}>
                    <span className="help-block text-danger">{helpBlock['template_id']}</span>
                </div>
            </form>
        )
    }
});

module.exports = CourseEditor;