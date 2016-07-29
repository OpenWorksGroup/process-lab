import React from 'react';
import ReactDOM from 'react-dom';
import _ from 'underscore';
import FormSavedNotice from '../form_saved_notice.jsx';

var classNames = require('classnames');

var SectionsEditor = React.createClass({
    getInitialState: function() {      
        var savedSections = [];
    
        if (this.props.sections) {
           // console.log("this.props.sections inititial "+JSON.stringify(this.props.sections));
            _.each(JSON.parse(this.props.sections), function(section) {
                savedSections.push({
                    section_id: section['id'],
                    section_title: section['section_title'],
                    description: section['description']
                });
            });
        }
        return {
            section_items: savedSections
        }
    },   
    render: function() {
        var template_id = this.props.id;
      //  console.log("this.props.sectionsFields "+JSON.parse(this.props.sectionsFields));
        var sectionFields = this.props.sectionsFields;
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
                            { 
                                this.state.section_items.length > 0 ?
                                    this.state.section_items.map(function(section, i) {
                                        return (<SectionItem 
                                        key={i} 
                                        title={section['section_title']} 
                                        section_id={section['section_id']}
                                        description={section['description']}
                                        template_id={template_id} 
                                        field_sections={sectionFields}
                                        section_num={i+1}/>);
                                    })
                                :
                                    <SectionItem section_num={1} template_id={template_id}/>
                            }

                            <AddSectionItem section_num={this.state.section_items.length} template_id={template_id} />
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
        var sectionId, title = "", description = "", savedSectionFields = [];
        if (this.props.section_id) {
            sectionId = this.props.section_id;
            title = this.props.title;
            description = this.props.description;
        }
        if (this.props.field_sections) {
           // console.log("field_sections "+JSON.stringify(this.props.field_sections));
            _.each(JSON.parse(this.props.field_sections), function(section) {
                _.each(section, function(field) {
                   // console.log("field_section\\ "+JSON.stringify(field));
                   // console.log("specific field "+field['template_section_id']);
                    if (field['template_section_id'] == sectionId) {
                        savedSectionFields.push(field);
                    }
                });
            });
        }

        return ({
            section_title:title,
            section_id: sectionId,
            description: description,
            section_fields: savedSectionFields
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

        data[name] = value;
        data['template_id'] = this.props.template_id;
        data['order'] = this.state.section_num; // Set up for future re-ording capability

        if (this.state.section_id) {
            data['section_id'] = this.state.section_id;
        }

        $.ajax({
            type: 'POST',
            url: '/api/admin/templates/section',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
            this.setState({section_id: result['id']});
            this.setState({success:name});
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
          //  console.log("ERROR "+JSON.stringify(error));
            this.setState({ error: error });
        }.bind(this));
    },
    render: function() {
        var section_num = this.props.section_num;
        var placeholder = "Section "+section_num+" title...";
        var descriptionPlaceHolder = "Short description";
        var fields = ["section_title","section_description"];
        var groupClass = [], successClass = [], helpBlock = [], errValue = "";
        var errKey = _.keys(this.state.error)[0];
        var successKey = this.state.success; 
        var sectionFields = this.state.section_fields;
        var field_num;

        if (sectionFields.length > 0){
            field_num = sectionFields.length+1;
        }
        else {
            field_num = 2;
        }

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
                'col-sm-10': true,
                'has-error': errKey == field
            });

            if (errKey == field) {
                helpBlock[field] = errValue;
            }

            successClass[field] = classNames({
                'hidden': true,
                'not-hidden': successKey == field
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
                    <div className={groupClass['section_title']}>
                        <span className={successClass['section_title']}><i className="fa fa-check"></i></span>
                        <input 
                        className="form-control" 
                        name="section_title"
                        value={this.props.section_title} 
                        defaultValue={this.state.section_title}
                        type="text" 
                        placeholder={placeholder}
                        required={true} 
                        disabled ={!this.props.template_id}
                        onBlur={this.saveSection}
                        />
                        <span className="help-block text-danger">{helpBlock['section_title']}</span>
                    </div>
                </div>
                <div className="row">
                    <div className={groupClass['section_description']}>
                    <span className={successClass['section_description']}><i className="fa fa-check"></i></span>
                        <input 
                        className="form-control" 
                        name="section_description"
                        value={this.props.section_description} 
                        defaultValue={this.state.description}
                        disabled ={!this.state.section_id}
                        type="text" 
                        required={true} 
                        placeholder={descriptionPlaceHolder} 
                        onBlur={this.saveSection}
                        />
                        <span className="help-block text-danger">{helpBlock['section_description']}</span> 
                    </div>
                </div>

                { 
                    sectionFields.length > 0 ?
                        sectionFields.map(function(field, i) {
                            return (<FieldItem 
                            key={i} 
                            section_id={field['template_section_id']}
                            title={field['field_title']} 
                            field_id={field['id']}
                            required={field['required']} 
                            field_num={i+1}/>);
                        })
                    :
                        <FieldItem field_num={1} section_id={this.state.section_id}/>
                }

                <AddFieldItem field_num={field_num} sectionFields={sectionFields} section_num={sectionFields.length} section_id={this.state.section_id}/>
                <div>&nbsp;</div>
            </div>
        );
    }
});

var FieldItem = React.createClass({
    componentWillMount: function() {
            this.setState({field_num: this.props.field_num})
    },
    getInitialState: function() {
        var sectionId, fieldId, title = "", required;
        if (this.props.field_id) {
            fieldId = this.props.field_id;
            title = this.props.title;
            required = (this.props.required == 1) ? true:false;
        }

        return {
            field_title:title,
            field_required: required,
            field_id: fieldId
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

        data[name] = value;
        data['template_section_id'] = this.props.section_id;
        data['order'] = this.state.field_num; // Set up for future re-ording capability

        if (name == "field_required") {
            this.setState({field_required: !this.state.field_required});
            data['field_required'] = !this.state.field_required;
        }

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
            this.setState({field_id: result['id']});
            this.setState({success:name}); 
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
           // console.log("ERROR "+JSON.stringify(error));
            this.setState({ error: error });
        }.bind(this));
    },
    render: function() {

        var field_num = this.props.field_num;
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
            'col-sm-8': true,
            'has-error': errKey == 'field_title'
        });   

        groupClass['field_required'] = classNames({
            'form-group': true,
            'col-sm-4': true,
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
                <div>
                    {this.state.success ?
                        <FormSavedNotice/>
                    : null}
                </div>
                <div className={groupClass['field_title']}>
                    <span className={successClass['field_title']}><i className="fa fa-check"></i></span>
                    <input 
                    className="form-control" 
                    name="field_title"
                    value={this.props.field_title} 
                    defaultValue={this.state.field_title} 
                    type="text"
                    placeholder={placeholder}
                    disabled ={!this.props.section_id}
                    onBlur={this.saveField}
                    />
                    <span className="help-block text-danger">{helpBlock['field_title']}</span> 
                </div>
                <div className={groupClass['field_required']}>
                    <label>
                        <input type="checkbox"
                        name="field_required"
                        checked={this.state.field_required}
                        value={this.state.field_required}
                        disabled ={!this.state.field_id}
                        onChange={this.saveField}/>
                        &nbsp; required field?
                    </label>  
                </div>
            </div>
        );
    }
});

var AddSectionItem = React.createClass({    
    getInitialState: function() {
        var section_num = this.props.section_num;
        return {
            section_items: [],
            section_num: section_num
        }
    },   
    addSection: function(e) {
        e.preventDefault();

        var sectionItems = this.state.section_items;
        sectionItems.push(<SectionItem />);
        this.setState({section_items: sectionItems});
        var sectionNum = this.state.section_num++;
    },
    render: function() {
        var template_id = this.props.template_id;
        var section_num = this.state.section_num;

            return (

            <div>
                { this.state.section_items.map(function(item, i) {;
                    return (<SectionItem key={i} template_id={template_id} section_num={section_num}/>);
                })}
                
                <div className="btn btn-default" onClick={this.addSection}>add new section and fields</div>
            </div>
        );
    }
});

var AddFieldItem = React.createClass({    
    getInitialState: function() {
        var fieldItems = [];

        return {
            field_items: [],
            field_num: fieldItems.length
        };
    },   
    addField: function(e) {
        e.preventDefault();

        var fieldItems = this.state.field_items;
        fieldItems.push(<FieldItem />);
        this.setState({field_items: fieldItems});
        var fieldNum = this.state.field_num++;
    },
    render: function() {
        var field_num = this.props.field_num;
        var section_id = this.props.section_id;
        var field_id = this.props.field_id;

        return (

            <div>
                { this.state.field_items.map(function(item, i) {;
                    return (<FieldItem key={i} field_num={field_num+i} section_id={section_id} field_id={field_id}/>);
                })}

                <button disabled={!section_id} className="btn btn-default" onClick={this.addField}>add field to this section</button>

            </div>
        );
    }
});




module.exports = SectionsEditor;