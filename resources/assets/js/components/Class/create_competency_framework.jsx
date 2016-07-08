import React from 'react';
import ReactDOM from 'react-dom';
import CompetencyCategories from './competency_framework_categories.jsx';
import _ from 'underscore';

var classNames = require('classnames');
var cfId, frameworkName;

var CreateCompetencyFramework = React.createClass({
    propTypes: {
        cf_id: React.PropTypes.number,
        framework: React.PropTypes.string,
        error: React.PropTypes.object,
        success: React.PropTypes.string,
        submit_button: React.PropTypes.string
    },
    getInitialState: function() {
        console.log("FRAMEOWRK ID "+this.props.frameworkId);
        var frameworkId = this.props.frameworkId;
        $.ajax({
            type: 'GET',
            url: '/admin/competency-frameworks/retrieve'
        })
        .success(function(frameworks) {
            _.each(frameworks, function(framework){
                if (framework['id'] == frameworkId) {
                    frameworkName = framework['framework'];
                }
            });
        });

        if (frameworkName) {
            console.log("hello "+frameworkName);
            return {
                cf_id: this.props.frameworkId,
                framework: frameworkName,
                error: {},
                success: undefined,
                submit_button: "Add"
            };
        }
        else {

            return {
                cf_id: undefined,
                framework: '',
                error: {},
                success: undefined,
                submit_button: "Add"
            };
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

        var data = {framework: this.state.framework};

        if (this.state.cf_id) {
            data['cf_id'] = this.state.cf_id;
        }

        this.setState({ error: {}});
        this.setState({ success: ""});

        $.ajax({
            type: 'POST',
            url: '/admin/competency-framework',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
            this.setState({ cf_id: result['id'] });
            this.setState({success:"true"}); 
            this.setState({submit_button:"Update"}); 
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            this.setState({ error: error });
        }.bind(this));
    },
    render: function() {
        var fields = ["framework"];
        var groupClass = [], successClass = [], helpBlock = [], errValue = "";
        var errKey = _.keys(this.state.error)[0];
        var successKey = this.state.success;
        var submit_button = this.state.submit_button;
        var framework = this.state.framework;
        var cf_id = this.state.cf_id;
        cfId = this.props.frameworkId;

        successClass['submit_result'] = classNames({
            'text-success': true,
            'hidden': true,
            'not-hidden': successKey == "true"
        });

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
            <div>
                <div className="row">
                    <div className="col-sm-10">
                        <form>
                            <div className={groupClass['framework']}>
                                <label htmlFor='framework' className="control-label">Framework Name</label>
                                <span className="required"><i className="fa fa-asterisk"></i></span>
                                &nbsp;  <span className={successClass['framework']}><i className="fa fa-check"></i></span>
                                <input 
                                name="framework" 
                                className="form-control" 
                                type="text" 
                                required={true} 
                                value={this.props.framework} 
                                onChange={this.handleChange} 
                                />
                                <span className="help-block text-danger">{helpBlock['framework']}</span>
                            </div>

                            <div className="col-md-3">
                                <button className="btn btn-default" type="submit" onClick={this.saveChange}>{submit_button}</button>
                                &nbsp; <span className={successClass['submit_result']}><i className="fa fa-check"></i></span>
                            </div>
                        </form>
                    </div>
                </div>
            
                <div className={successClass['submit_result']}>
                    <div className="row">
                        <div className="col-sm-10">
                            <h4>Add Categories to {framework}</h4>
                            <div>
                            <CompetencyCategories cf_id={cf_id} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
});

module.exports = CreateCompetencyFramework;