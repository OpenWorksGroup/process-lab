import React from 'react';
import ReactDOM from 'react-dom';
import _ from 'underscore';

var classNames = require('classnames');

var SectionsEditor = React.createClass({
    getInitialState: function() {
        return {
            section_items: []
        }
    },   
    render: function() {
        var template_id = this.props.id;
        return(
            <div className="col-md-10">
                <div className="panel panel-default">
                    <div className="panel-heading">
                        <h3 className="panel-title">Add Sections and Fields</h3>
                    </div>
                    <div className="panel-body">
                        <p>This will set up your selections, such as Ask or Investigate, 
                        and the types of content under each, such as design chellenge or experiment.</p>

                        <form>
                            <SectionItem section_num={1} template_id={template_id}/>

                            <AddSectionItem template_id={template_id} />
                            
                        </form>
                    </div>
                </div>
            </div>
        );
    }
});

var SectionItem = React.createClass({
    componentWillMount: function() {
            this.setState({section_num: this.props.section_num})
    },
        getInitialState: function() {
        return ({
            section_title:"",
            section_id: undefined
        });
    },
    handleChange: function(e) {
        var state = {};
        state[e.target.name] =  $.trim(e.target.value);
    },
    saveSection: function(e) {
        var data = {};
        var name = e.target.name;
        var value = $.trim(e.target.value);
       // console.log("Section name "+name);
       // console.log("Section value "+value);

        data[name] = value;
        data['template_id'] = this.props.template_id;
        data['order'] = this.state.section_num; // Set up for future re-ording capability

        console.log("DATA "+JSON.stringify(data));

        if (this.state.section_id) {
            data['section_id'] = this.state.section_id;
        }
        
        this.setState({ error: {}});
        this.setState({ success: ""});

        $.ajax({
            type: 'POST',
            url: '/api/admin/templates/section',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
            console.log(JSON.stringify(result));
            console.log("RESULT ID "+result['id']);
            this.setState({section_id: result['id']});
            this.setState({success:"true"}); 
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            console.log("ERROR "+JSON.stringify(error));
            this.setState({ error: error });
        }.bind(this));
    },
    render: function() {
      //  var section_num;
       // section_num = (this.props.section_num) ? this.props.section_num : 1;
        var section_num = this.state.section_num;
        var placeholder = "Section "+section_num+" title...";

        console.log("SECTION section_id "+this.state.section_id);

        return (
            <div>
                <div className="row">
                    <div className="col-sm-6">
                        <div className="form-group">
                            <input 
                            className="form-control" 
                            name="section_title"
                            value={this.props.section_title} 
                            type="text" 
                            required={true} 
                            placeholder={placeholder}
                            disabled ={!this.props.template_id}
                            onBlur={this.saveSection}
                            />
                        </div>
                    </div>
                </div>
                <div className="row">
                    <div className="col-sm-offset-1 col-sm-6">
                        <div className="form-group">
                            <input 
                            className="form-control" 
                            name="section_description"
                            value={this.props.section_description} 
                            disabled ={!this.state.section_id}
                            type="text" 
                            required={true} 
                            placeholder="Short description" 
                            onBlur={this.saveSection}
                            />
                        </div>
                    </div>
                </div>

                <FieldItem field_num={1} section_id={this.state.section_id}/ >

                <AddFieldItem section_id={this.state.section_id}/>
            </div>
        );
    }
});

var AddSectionItem = React.createClass({    
    getInitialState: function() {
        return {
            section_items: [],
            section_num: 1
        }
    },   
    addSection: function() {
        e.preventDefault();

        var sectionItems = this.state.section_items;
        sectionItems.push(<SectionItem />);
        this.setState({section_items: sectionItems});
        //this.setState({section_num: this.state.section_num});
        var sectionNum = this.state.section_num++;
        console.log("section_num "+this.state.section_num);
    },
    render: function() {
        var template_id = this.props.template_id;
        var section_num = this.state.section_num;

            return (

            <div>
                { this.state.section_items.map(function(item, i) {;
                    return (<SectionItem key={i} template_id={template_id} section_num={section_num}/>);
                })}

                <div className="row">
                    <div className="col-md-12">
                        <button className="btn btn-default" onClick={this.addSection}>add new section and fields</button>
                    </div>
                </div>
            </div>
        );
    }
});

var FieldItem = React.createClass({
    componentWillMount: function() {
            this.setState({field_num: this.props.field_num})
           // this.setState({section_id: this.props.section_id})
    },
    getInitialState: function() {
        return {
            field_title:"",
            required_field: true,
            field_id: undefined
        }
    },
    handleChange: function(e) {
        var state = {};
        state[e.target.name] =  $.trim(e.target.value);
    },
    saveField: function(e) {
        var data = {};
        var name = e.target.name;
        var value = $.trim(e.target.value);
       // console.log("Section name "+name);
       // console.log("Section value "+value);

        data[name] = value;
        data['template_section_id'] = this.props.section_id;
        data['order'] = this.state.field_num; // Set up for future re-ording capability

        if (/field_required/.test(name)) {
            this.setState({required_field: !this.state.required_field});
        }

        console.log("DATA "+JSON.stringify(data));

        if (this.state.field_id) {
            data['field_id'] = this.state.field_id;
        }       
        this.setState({ error: {}});
        this.setState({ success: ""});

        $.ajax({
            type: 'POST',
            url: '/api/admin/admin/templates/section-field',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
            console.log(JSON.stringify(result));
            console.log("RESULT ID "+result['id']);
            this.setState({field_id: result['id']});
            this.setState({success:"true"}); 
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            console.log("ERROR "+JSON.stringify(error));
            this.setState({ error: error });
        }.bind(this));
    },
    render: function() {
        //console.log("field_num "+this.state.field_num);
        console.log("field item section_id "+this.props.section_id);

        var field_num = this.state.field_num;
        var field_id = this.state.field_id;
        var placeholder = "Field "+field_num+" title...";

        var fields = ["field_title","field_required"];
        var groupClass = [], successClass = [], helpBlock = [], errValue = "";
        var errKey = _.keys(this.state.error)[0];
        var successKey = this.state.success; 

        if (_.values(this.state.error)[0]) {
            errValue = _.values(this.state.error)[0][0];
        }

        groupClass['field_title'] = classNames({
            'form-group': true,
            'col-sm-6': true,
            'padding-left-20': true,
            'has-error': errKey == 'field_title'
        });   

        groupClass['field_required'] = classNames({
            'form-group': true,
            'col-sm-6': true,
            'padding-left-20': true,
            'disabled': true
        });     

        _.each(fields, function(field){
            successClass[field] = classNames({
                'hidden': true,
                'not-hidden': successKey == field
            });

            if (errKey == field) {
                helpBlock[field] = errValue;
            }
        });

        return (
            <div className="row">
                <div className={groupClass['field_title']}>

                        <input 
                        className="form-control" 
                        name="field_title"
                        value={this.props.field_title} 
                        type="text"
                        placeholder={placeholder}
                        disabled ={!this.props.section_id}
                        onBlur={this.saveField}
                        />

                </div>
                <div className={groupClass['field_required']}>
                        <label>
                        <input type="checkbox"
                        name="field_required"
                        value={this.state.required_field}
                        disabled ={!this.state.field_id}
                        onChange={this.saveField}/>
                        &nbsp; required field?
                        </label>  
                </div>
            </div>
        );
    }
});

var AddFieldItem = React.createClass({    
    getInitialState: function() {
        return {
            field_items: [],
            field_num: 1
        };
    },   
    addField: function(e) {
        e.preventDefault();

        var fieldItems = this.state.field_items;
        fieldItems.push(<FieldItem />);
        this.setState({field_items: fieldItems});
        //this.setState({field_num: this.state.field_num});
        var fieldNum = this.state.field_num++;
        console.log("field_num add"+this.state.field_num);
    },
    render: function() {
        var field_num = this.state.field_num;
        var section_id = this.props.section_id;
        var field_id = this.props.field_id;

        console.log("add field item section_id "+this.props.section_id);

            return (

            <div>
                { this.state.field_items.map(function(item, i) {;
                    return (<FieldItem key={i} field_num={field_num} section_id={section_id} field_id={field_id}/>);
                })}

                <div className="row">
                    <div className="col-md-12">
                        <button className="btn btn-default" onClick={this.addField}>add field to this section</button>
                    </div>
                </div>
            </div>
        );
    }
});




module.exports = SectionsEditor;