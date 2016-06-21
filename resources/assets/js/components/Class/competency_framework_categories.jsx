import React from 'react';
import ReactDOM from 'react-dom';
import _ from 'underscore';

var classNames = require('classnames');
var cfId;

var CompetencyCategories = React.createClass({
    getInitialState: function() {
        return ({
            categoryItems: []
        });
    },
    addCategoryItem: function(event) {
        var categoryItems = this.state.categoryItems;
        categoryItems.push(<CategoryItem />);
        this.setState({
            categoryItems: categoryItems
        });
    },
    render: function() {
        cfId = this.props.cf_id;
        return (
            <div>
                <form>
                    <CategoryItem />
                        { this.state.categoryItems.map(function(item, i) {;
                            return (<CategoryItem key={i}/>);
                        })}
                    <div className="btn btn-default" onClick={ this.addCategoryItem }>add new category</div>
                </form>
            </div>
        );
    }
});

var CategoryItem = React.createClass({
    propTypes: {
        category_id: React.PropTypes.number,
        category: React.PropTypes.string,
        error: React.PropTypes.object,
        success: React.PropTypes.string,
    },
    getInitialState: function() {
        return ({
            category:"",
            error: {},
            success: undefined
        });
    },
    handleChange: function(e) {
        var state = {};
        state[e.target.name] =  $.trim(e.target.value);
        state['success'] = "";
        this.setState(state);
    },
    saveCategory: function(e) {
        var data = {};
        var value = $.trim(e.target.value);

        data['category']= value;
        data['cf_id'] = cfId;

        if (this.state.category_id) {
            data['category_id'] = this.state.category_id;
        }

        console.log("Data "+JSON.stringify(data));

        this.setState({ error: {}});
        this.setState({ success: ""});

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
            <div className="row">
                <div className="col-sm-6">
                    <div className={groupClass['category']}>
                        <span className={successClass['category']}><i className="fa fa-check"></i></span> 
                        <input 
                        className="form-control" 
                        name="category"
                        value={this.props.category} 
                        type="text"  
                        placeholder="Category name"
                        onBlur={this.saveCategory}
                        />
                        <span className="help-block text-danger">{helpBlock['category']}</span>
                    </div>
                </div>
            </div>
        )
    }
});

module.exports = CompetencyCategories;