import React from 'react';
import ReactDOM from 'react-dom';
import _ from 'underscore';

var Select = require('react-select');
var selectIsLoadingExternally = true;
var classNames = require('classnames');

var template_id,frameworkCategories =[];

var RubricEditor = React.createClass({
    propTypes: {
        framework_id: React.PropTypes.number
    },
    componentDidMount: function() {
        $.ajax({
            type: 'GET',
            url: '/admin/competency-frameworks/retrieve'
        })
        .success(function(frameworkResults) {
            var frameworkOptions = [];
            _.each(frameworkResults, function(framework){
                frameworkOptions.push({value: framework['id'], label: framework['framework']});
            });
            this.setState({frameworkOptions: frameworkOptions});
        }.bind(this));
    },
    getInitialState: function() {
        return {
            frameworkOptions: null,
            frameworkCategories: null,
            framework_id: undefined,
            framework_name: ""
        }
    },
    loadCategories: function(value) {
        template_id = this.props.id;
        this.setState({framework_id: value});
        var frameworkId = value;

        var frameworkObj = _.find(this.state.frameworkOptions, function(obj) { return obj.value == value })
        this.setState({framework_name: frameworkObj['label']});

        $.ajax({
            type: 'GET',
            url: '/admin/competency-frameworks-categories/retrieve'
        })
        .success(function(categoryResults) {
            _.each(categoryResults, function(category){
                if (category['framework_id'] == frameworkId) {
                    frameworkCategories.push({value: category['id'], label: category['category']});
                }
            });
            this.setState({frameworkCategories: frameworkCategories});
        }.bind(this));
    },
    removeFramework: function(){

        var data = {};
        data['template_id'] = template_id;
        data['framework_id'] = this.state.framework_id;
        data['category_id'] = null;

       // console.log("FRAMEWORK DELETE DATA "+JSON.stringify(data));

        $.ajax({
            type: 'DELETE',
            url: '/api/admin/template-rubric',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
          //  console.log(JSON.stringify(result));

            if (result['success']) {
                this.setState({framework_id: undefined});
                this.setState({framework_name: ""});
                this.setState({frameworkCategories: null});
              //  console.log(result['success']);
              //  console.log(this.state.frameworkOptions);
            }      
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            if (error) {
                var errMessage = error['message'];
                console.log(errMessage);
            }
        }.bind(this)); 
    },
    render: function() {

        if (this.state.frameworkOptions) {

            if (this.state.framework_name) {

                return (
                    <div className="col-md-10">
                        <div className="panel panel-default">
                            <div className="panel-heading">
                                <h3 className="panel-title">Add Rubric Scores and Values</h3>
                            </div>
                            <div className="panel-body">
                                <p>This will set up your competencies to assess work against, using 
                                your selected framework</p>

                                <div className="row">
                                    <div className="col-sm-10">
                                        <div><h5>Framework: {this.state.framework_name}</h5> <div className="removeClick" onClick={this.removeFramework}><i className="remove fa fa-times" aria-hidden="true"></i> Remove framework</div></div>
                                        <CompetencyCategory framework_id={this.state.framework_id} frameworkCategories={this.state.frameworkCategories} />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                );
            }
            else {

                return (
                    <div className="col-md-10">
                        <div className="panel panel-default">
                            <div className="panel-heading">
                                <h3 className="panel-title">Add Rubric Scores and Values</h3>
                            </div>
                            <div className="panel-body">
                                <p>This will set up your competencies to assess work against, using 
                                your selected framework</p>

                                <div className="row">
                                    <div className="col-sm-10">
                                        <Select
                                        name="framework_id"
                                        value={this.state.framework_id}
                                        options={this.state.frameworkOptions}
                                        onChange={this.loadCategories}
                                        placeholder="Select framework"
                                        />
                                        <div>&nbsp;</div>
                                        <CompetencyCategory framework_id={this.state.framework_id} frameworkCategories={this.state.frameworkCategories} />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                );

            }
        }
        else {
            return (
                <div className="col-md-10">
                    <div className="panel panel-default">
                        <div className="panel-heading">
                            <h3 className="panel-title">Add Rubric Scores and Values</h3>
                        </div>
                        <div className="panel-body">
                            <p>This will set up your competencies to assess work against, using 
                            your selected framework</p>
    
                            <div className="row">
                                <div className="col-md-12">
                                    <Select
                                    name="framework"
                                    value={this.state.category_id}
                                    isLoading={selectIsLoadingExternally}
                                    placeholder="Select framework"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            );
        }
    }

});

var CompetencyCategory = React.createClass({
    getInitialState: function() {
        return {
            category_id: null,
            category_name: null,
            frameworkCategories: this.props.frameworkCategories
        }
    },
    saveCategoryId: function(value){
        this.setState({category_id: value});

        var categoryObj = _.find(this.props.frameworkCategories, function(obj) { return obj.value == value })
        var arr = _.reject(this.props.frameworkCategories, function(d){ return d.value === value; });
        this.setState({frameworkCategories: arr});
        this.setState({category_name: categoryObj['label']});
    },
    removeCompetency: function() {
        var data = {};
        data['framework_id'] = this.props.framework_id;
        data['category_id'] = this.state.category_id;

       // console.log("FRAMEWORK DELETE COMPETENCY "+JSON.stringify(data));

        $.ajax({
            type: 'DELETE',
            url: '/api/admin/template-rubric',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
           // console.log(JSON.stringify(result));

            if (result['success']) {
                this.setState({category_id: undefined});
                this.setState({category_name: null});
                this.setState({frameworkCategories: frameworkCategories});
                //console.log(result['success']);
               // console.log(this.state.frameworkOptions);
            }      
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            if (error) {
                var errMessage = error['message'];
                console.log(errMessage);
            }
        }.bind(this)); 

    },
    render: function() {

        if (this.props.frameworkCategories) {
            
            if (this.state.category_name) {
                return(
                        <div className="row">
                            <div className="col-md-12">
                                <div><h5>Competency: {this.state.category_name}</h5> <div className="removeClick" onClick={this.removeCompetency}><i className="remove fa fa-times" aria-hidden="true"></i> Remove competency</div></div>
                                <CategoryDescriptions category_id={this.state.category_id} framework_id={this.props.framework_id} frameworkCategories={this.state.frameworkCategories}/>
                            <div>&nbsp;</div><div>&nbsp;</div>
                        </div>
                    </div>
                );
            }
            else {
                return (
                        <div className="row">
                            <div className="col-md-12">
                                <Select
                                name="category_id"
                                value={this.state.category_id}
                                options={this.props.frameworkCategories}
                                onChange={this.saveCategoryId}
                                placeholder="Select competency"
                                />
                                <div>&nbsp;</div>
                                <CategoryDescriptions category_id={this.state.category_id} framework_id={this.props.framework_id} frameworkCategories={this.props.frameworkCategories}/>
                            <div>&nbsp;</div><div>&nbsp;</div>
                        </div>
                    </div>
                );
            }
        }
        else {
            return null;
        }
    }
});

var CategoryDescriptions = React.createClass({
    componentDidMount: function() {
        $.ajax({
            type: 'GET',
            url: '/api/admin/settings'
        })
        .success(function(settingsResults) {
            this.setState({category_value_1: settingsResults['competency_framework_description_1']});
            this.setState({category_value_2: settingsResults['competency_framework_description_2']});
            this.setState({category_value_3: settingsResults['competency_framework_description_3']});
            this.setState({category_value_4: settingsResults['competency_framework_description_4']});
        }.bind(this));
    },
    getInitialState: function() {
        return {
            description_1: null,
            description_2: null,
            description_3: null,
            description_4: null,
            category_value_1: null,
            category_value_2: null,
            category_value_3: null,
            category_value_4: null,
            rubric_id: undefined,
            error: {},
            success: undefined
        }
    },
    handleChange: function(e) {
        var state = {};
        state[e.target.name] =  $.trim(e.target.value);
        this.setState(state);
    },
    saveDescription: function(e){
        var data = {};
        var name = e.target.name;
        var value = $.trim(e.target.value);

        this.setState({ error: {}});
        this.setState({ success: ""});

        data[name] = value;
        data['template_id'] = template_id;
        data['framework_id'] = this.props.framework_id;
        data['category_id'] = this.props.category_id;

       // console.log("DATA "+JSON.stringify(data));

        if (this.state.rubric_id) { // don't show checkmark if description is empty
            data['rubric_id'] = this.state.rubric_id;
        }

        $.ajax({
            type: 'POST',
            url: '/api/admin/template-rubric',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
            this.setState({ rubric_id: result['id'] });
            if (value) {
                this.setState({success:name});
            }
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            this.setState({ error: error });
        }.bind(this));
    },
    render: function() {

        if (this.props.category_id && this.state.category_value_1) {

            var fields = ["description_1","description_2","description_3","description_4"];
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
                    'col-md-12': true,
                    'has-error': errKey == field
                });

                if (errKey == field) {
                    helpBlock[field] = errValue;
                }
            });

            return (
                <div>
                    <div className="row">
                        <div className="col-md-12">
                            <p>Score and value description:</p>
                        </div>
                    </div>
                    <div className="row">
                        <div className={groupClass['description_1']}>
                            <label htmlFor='description_1' className="control-label">1) {this.state.category_value_1}</label>
                            &nbsp;  <span className={successClass['description_1']}><i className="fa fa-check"></i></span>
                            <textarea 
                            name="description_1"
                            className="form-control" 
                            value={this.props.description_1} 
                            onChange={this.handleChange} 
                            onBlur={this.saveDescription}
                            />
                    
                            <span className="help-block text-danger">{helpBlock['description_1']}</span>
                        </div>
                    </div>
                    <div className="row">
                        <div className={groupClass['description_2']}>
                            <label htmlFor='description_2' className="control-label">2) {this.state.category_value_2}</label>
                            &nbsp;  <span className={successClass['description_2']}><i className="fa fa-check"></i></span>
                            <textarea 
                            name="description_2"
                            className="form-control" 
                            value={this.props.description_2} 
                            onChange={this.handleChange} 
                            onBlur={this.saveDescription}
                            />
                    
                            <span className="help-block text-danger">{helpBlock['description_2']}</span>
                        </div>
                    </div>
                    <div className="row">
                        <div className={groupClass['description_3']}>
                            <label htmlFor='description_3' className="control-label">3) {this.state.category_value_3}</label>
                            &nbsp;  <span className={successClass['description_3']}><i className="fa fa-check"></i></span>
                            <textarea 
                            name="description_3"
                            className="form-control" 
                            value={this.props.description_3} 
                            onChange={this.handleChange} 
                            onBlur={this.saveDescription}
                            />
                    
                            <span className="help-block text-danger">{helpBlock['description_3']}</span>
                        </div>
                    </div>
                    <div className="row">
                        <div className={groupClass['description_4']}>
                            <label htmlFor='description_4' className="control-label">4) {this.state.category_value_4}</label>
                            &nbsp;  <span className={successClass['description_4']}><i className="fa fa-check"></i></span>
                            <textarea 
                            name="description_4"
                            className="form-control" 
                            value={this.props.description_4} 
                            onChange={this.handleChange} 
                            onBlur={this.saveDescription}
                            />
                    
                            <span className="help-block text-danger">{helpBlock['description_4']}</span>
                        </div>
                    </div>

                    <AddCompetencyCategory framework_id={this.props.framework_id} frameworkCategories={this.props.frameworkCategories} />

                </div>
            );
        }
        else {
            return null;
        }
    }
});

var AddCompetencyCategory = React.createClass({
    getInitialState: function() {
        return {
            competencies: []
        }
    },
    addCompetency: function(event) {
        var competencies = this.state.competencies;
        competencies.push(<CompetencyCategory />);
        this.setState({
            competencies: competencies
        });
    },
    render: function() {

        var framework_id = this.props.framework_id;
        var frameworkCategories = this.props.frameworkCategories;

        if (this.state.competencies.length > 0){
            return (
                <div>
                    { this.state.competencies.map(function(field, f) {
                        return (<CompetencyCategory key={f} framework_id={framework_id} frameworkCategories={frameworkCategories} />)
                    })} 
                </div>
            );
        }
        else {
            if (this.props.frameworkCategories.length > 0){
                return (
                    <div className="row">
                        <div className="col-md-12">
                            <div className="btn btn-default" onClick={this.addCompetency}>add new competency</div>
                        </div>
                    </div>
                );
            }
            else {
                return null;
            }
        }

    }
});

module.exports = RubricEditor;