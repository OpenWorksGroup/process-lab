import React from 'react';
import ReactDOM from 'react-dom';
import _ from 'underscore';

var classNames = require('classnames');

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
		return {
			template_course_id: undefined,
			course_id: "",
			course_title: "",
			course_url: "",
      		error: undefined,
      		success: undefined,
      		submit_button: "Add Course"
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
        	course_url: this.state.course_url
        };

        data['template_id'] = this.props.id;

        if (this.state.template_course_id) {
            data['template_course_id'] = this.state.template_course_id;
        }

        this.setState({ error: {}});
        this.setState({ success: ""});

        $.ajax({
            type: 'POST',
            url: '/admin/templates/course',
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
            this.setState({ error: error });
        }.bind(this));
    },
    render: function() {
        var fields = ["course_id","course_title","course_url"];
        var groupClass = [], successClass = [], helpBlock = [], errValue = "";
        var successKey = this.state.success;
        var submit_button = this.state.submit_button;

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
                'col-md-3': true,
            	'has-error': errKey == field
            });

            if (errKey == field) {
                helpBlock[field] = errValue;
            }
        });

        return (

        	<form>
                <div className={groupClass['course_id']}>
                    <label htmlFor='course_id' className="control-label">Course Id</label>
                    <input 
                    name="course_id" 
                    className="form-control" 
                    type="text" 
                    required={true} 
                    value={this.props.course_id} 
                    onChange={this.handleChange} 
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
                    onChange={this.handleChange} 
                    />
                    <span className="help-block text-danger">{helpBlock['course_title']}</span>
                </div>
                <div className={groupClass['course_url']}>
                    <label htmlFor='course_id' className="control-label">Url</label>
                    <input 
                    name="course_url" 
                    className="form-control" 
                    type="text" 
                    required={true} 
                    value={this.props.course_url} 
                    onChange={this.handleChange} 
                    />
                    <span className="help-block text-danger">{helpBlock['course_url']}</span>
                </div>

                <div className="col-md-3">
                <button className="btn btn-default" type="submit" onClick={this.saveChange} onBlur={this.handleChange}>{submit_button}</button>
                &nbsp; <span className={successClass['submit_result']}><i className="fa fa-check"></i></span>
                </div>
            </form>
		)
    }
});

module.exports = CourseEditor;