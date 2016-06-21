import React from 'react';
import ReactDOM from 'react-dom';
import _ from 'underscore';

/**
To dos:
- documentation 
- Local storage state
- add required_period_time (probably a select)
**/

var classNames = require('classnames');
var moment = require('moment');

var TemplateSetUp = React.createClass({
    propTypes: {
        id: React.PropTypes.number,
        title: React.PropTypes.string,
        description: React.PropTypes.string,
        required_num_reviews: React.PropTypes.number,
        required_period_time: React.PropTypes.number,
        error: React.PropTypes.object,
        success: React.PropTypes.string,
    },
    getInitialState: function() {
        return {
            id: undefined,
            title: '',
            description: '',
            include_collaborative_feedback: true,
            required_num_reviews: 3,
            required_period_time: 1, // 1 day/86400 seconds
            error: {},
            success: undefined,
        };
    },
    handleChange: function(e) {
        var state = {};
        state[e.target.name] =  $.trim(e.target.value);
        this.setState(state);
    },
    saveChange: function(e) {
        var data = {};
        var name = e.target.name;
        var value = $.trim(e.target.value);

        if (name == "required_num_reviews" && value <= 0) {
            this.setState({ required_num_reviews:0});
            this.setState({ required_period_time:0});
            data['required_period_time'] = 0;
        }

        if (name == "required_num_reviews" && value > 0) {
            this.setState({ required_period_time:1});
            data['required_period_time'] = 1;
        }

        if (name == "required_period_time" && value == 0) {
            this.setState({ required_num_reviews:0});
            data['required_num_reviews'] = 0;
        }

        if (name == "required_period_time" && value > 0) {
            this.setState({ required_num_reviews:3});
            data['required_num_reviews'] = 3;
        }

        if (name == "include_collaborative_feedback") {
            this.setState({include_collaborative_feedback: !this.state.include_collaborative_feedback});
        }

        if (this.state.id) {
            data['id'] = this.state.id;
        }

        data[name] = value;

        this.setState({ error: {}});
        this.setState({name:value});
        $.ajax({
            type: 'POST',
            url: '/admin/templates',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
            this.setState({ id: result['id'] });
            this.props.addId(this.state.id); 
            this.setState({success:name});
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            this.setState({ error: error });
        }.bind(this));
    },
    render: function() {
        var fields = ["title","description","include_collaborative_feedback","required_num_reviews","required_period_time"];
        var groupClass = [], successClass = [], helpBlock = [], errValue = "";
        var errKey = _.keys(this.state.error)[0];
        var successKey = this.state.success;

        if (_.values(this.state.error)[0]) {
            errValue = _.values(this.state.error)[0][0];
        }
       
        _.each(fields, function(field){

            successClass[field] = classNames({
                'text-success': true,
                'hidden': true,
                'not-hidden': successKey == field
            });
         
            groupClass[field] = classNames({
                'form-group': true,
                'col-md-10': true,
            'has-error': errKey == field
            });

            if (errKey == field) {
                helpBlock[field] = errValue;
            }
        });

        
        return (
            <form>
                <div className={groupClass['title']}>
                    <label htmlFor='title' className="control-label">Title</label>
                    <span className="required"><i className="fa fa-asterisk"></i></span>
                    &nbsp;  <span className={successClass['title']}><i className="fa fa-check"></i></span>
                    <input 
                    name="title" 
                    className="form-control" 
                    type="text" 
                    required={true} 
                    value={this.props.title} 
                    onChange={this.handleChange} 
                    onBlur={this.saveChange}
                    />

                    <span className="help-block text-danger">{helpBlock['title']}</span>
                </div>
                <div className={groupClass['description']}>
                    <label htmlFor='description' className="control-label">Description</label>
                    <span className="required"><i className="fa fa-asterisk"></i></span>
                    &nbsp;  <span className={successClass['description']}><i className="fa fa-check"></i></span>
                    <textarea 
                    name="description"
                    className="form-control" 
                    value={this.props.description} 
                    onChange={this.handleChange} 
                    onBlur={this.saveChange}
                    />
                    
                    <span className="help-block text-danger">{helpBlock['description']}</span>
                </div>
                
                <div className={groupClass['include_collaborative_feedback']}>
                    <label>
                    <input type="checkbox"
                    name="include_collaborative_feedback"
                    checked={this.state.include_collaborative_feedback}
                    onChange={this.saveChange}
                    value={this.state.include_collaborative_feedback} />
                      &nbsp; Include Collaborative Feedback
                    </label>  
                </div>

                <div className={groupClass['required_num_reviews']}>
                    <label htmlFor='required_num_reviews' className="control-label">Designate Number of Reviewers</label>
                    <span className="required"><i className="fa fa-asterisk"></i></span> 
                    &nbsp;  <span className={successClass['required_num_reviews']}><i className="fa fa-check"></i></span>
                    <span className="help-block">"0" indicates no reviewers</span> 
                    <input 
                    name="required_num_reviews"
                    className="form-control"
                    type="text" 
                    value={this.state.required_num_reviews} 
                    onChange={this.handleChange} 
                    onBlur={this.saveChange}
                    />
                    <span className="help-block text-danger">{helpBlock['required_num_reviews']}</span> 
                </div>
                <div className={groupClass['required_period_time']}>
                    <label htmlFor='required_period_time' className="control-label">Designate Number of Days Allowed Per Review</label> 
                    <span className="required"><i className="fa fa-asterisk"></i></span>
                    &nbsp; <span className={successClass['required_period_time']}><i className="fa fa-check"></i></span>
                    <input 
                    name="required_period_time"
                    className="form-control"
                    type="text" 
                    value={this.state.required_period_time} 
                    onChange={this.handleChange} 
                    onBlur={this.saveChange}
                    />
                    <span className="help-block text-danger">{helpBlock['required_period_time']}</span>
                </div>
            </form>
        );
    }
});

module.exports = TemplateSetUp;
