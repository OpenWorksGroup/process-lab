import React from 'react';
import ReactDOM from 'react-dom';
import _ from 'underscore';
import FormSavedNotice from './form_saved_notice.jsx';

var classNames = require('classnames');

var CompetencyFrameworkForm = React.createClass({
    propTypes: {
        framework_id: React.PropTypes.number,
        framework_name: React.PropTypes.string,
        error: React.PropTypes.object,
        success: React.PropTypes.string,
        submit_button: React.PropTypes.string
    },
    getInitialState: function() {
        var frameworkId,frameworkName = "";
        frameworkId = this.props.frameworkId;
        frameworkName = this.props.frameworkName;
        var submitButton = "Add";
        if (frameworkId) submitButton = "Update";

        return {
            framework_id: frameworkId,
            framework_name: frameworkName,
            submit_button: submitButton
        }
    },
    handleChange: function(e) {
        var state = {};
        state[e.target.name] =  $.trim(e.target.value);
        state['success'] = "";
        this.setState(state);

    },
    saveChange: function(e) {
        e.preventDefault();

       var data = {framework: this.state.framework_name};

        if (this.state.framework_id) {
            data['framework_id'] = this.state.framework_id;
        }

        $.ajax({
            type: 'POST',
            url: '/admin/competency-framework',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
            console.log(result);
            this.setState({ framework_id: result['id'] });
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
                <div>
                    {this.state.success ?
                    <FormSavedNotice/>
                    : null}
                </div>
                <div className="row">
                    <div className="col-sm-8">
                        <div className={groupClass['framework']}>
                            <label htmlFor='framework' className="control-label">Framework Name</label>
                            <span className="required"><i className="fa fa-asterisk"></i></span>
                            &nbsp;  <span className={successClass['framework']}><i className="fa fa-check"></i></span>
                            <input 
                            name="framework_name" 
                            className="form-control" 
                            type="text" 
                            required={true} 
                            value={this.props.framework_name} 
                            defaultValue={this.state.framework_name}
                            onChange={this.handleChange} 
                            />
                        <span className="help-block text-danger">{helpBlock['framework']}</span>
                        </div>
                    </div>
                    <div className="col-sm-4">
                        <button className="btn btn-default" type="submit" onClick={this.saveChange}>{submit_button}</button>
                    </div>
                </div>

                <div className="row">
                    <div className="col-sm-12">
                        <h4>Categories</h4>
                        <CompetencyCategories categories={this.props.frameworkCategories} framework_id={this.state.framework_id} />
                    </div>
                </div>
            </form>
        );
    }

});

var CompetencyCategories = React.createClass({
    getInitialState: function() {
        var categories= [];
        if (this.props.categories) categories = JSON.parse(this.props.categories);
        return ({
            categoryItems: categories
        });
    },
    addCategoryItem: function(event) {
        var categoryItems = this.state.categoryItems;
        categoryItems.push(<CategoryItem />);
        this.setState({
            categoryItems: categoryItems
        });
    },
    removeCategory: function(e) {
        var data = {}; 

        var item = e.target.id;

        data['category_id'] = this.state.categoryItems[item]['id'];

        $.ajax({
            type: 'DELETE',
            url: '/admin/competency-framework-category',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {

            if (result['success']) {
                this.state.categoryItems.splice(item, 1);
                this.setState({
                    categoryItems: this.state.categoryItems
                });
                this.setState({success: "true"});
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
        var categories = this.state.categoryItems;
        var frameworkId = this.props.framework_id;
        var removeCategory = this.removeCategory;
        return (
           <div>
                <div>
                    {this.state.success ?
                    <FormSavedNotice/>
                    : null}
                </div>

                { categories.map(function(item, i) {;
                    return (<CategoryItem 
                        categories={categories} 
                        key={i} id={i} 
                        category_id={item.id} 
                        category_name={item.category} 
                        framework_id={frameworkId} 
                        removeCategory={removeCategory}
                        />);
                })}

            <div className="btn btn-default" onClick={ this.addCategoryItem }>add new category</div>

            </div>
        )
    }
});

var CategoryItem = React.createClass({
    getInitialState: function() {
        return ({
            framework_id: this.props.framework_id,
            category_id: this.props.category_id,
            category: this.props.category_name,
            categories: this.props.categories,
            error: {},
            success: undefined
        });
    },
    saveCategory: function(e) {
        var data = {};
        var value = $.trim(e.target.value);

        data['category']= value;
        data['framework_id'] = this.state.framework_id;

        if (this.state.category_id) {
            data['category_id'] = this.state.category_id;
        }

        $.ajax({
            type: 'POST',
            url: '/admin/competency-framework-category',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
            this.setState({ category_id: result['id'] });
            this.setState({success:"true"}); 
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            this.setState({ error: error });
        }.bind(this));

    },
    render: function() {

        var fields = ["category"];
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
                'not-hidden': successKey == "true"
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
                <div>
                    {this.state.success ?
                    <FormSavedNotice/>
                    : null}
                </div>
                <div className="row">
                    <div className="col-sm-8">
                        <div className="col-sm-4 text-left removeFile" id={this.props.id} onClick={this.props.removeCategory}><i className="remove fa fa-times" aria-hidden="true"></i> Remove</div>
                    </div>
                </div>
                <div className="row">
                    <div className="col-sm-8">
                        <div className={groupClass['category']}>
                            <span className={successClass['category']}><i className="fa fa-check"></i></span> 
                            <input 
                            className="form-control" 
                            name="category"
                            value={this.props.category} 
                            defaultValue={this.state.category}
                            type="text"  
                            placeholder="Category name"
                            onBlur={this.saveCategory}
                            />
                            <span className="help-block text-danger">{helpBlock['category']}</span>
                        </div>
                    </div>
                </div>
            </div>
        )
    }

});


module.exports = CompetencyFrameworkForm;