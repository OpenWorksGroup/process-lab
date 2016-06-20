import React from 'react';
import ReactDOM from 'react-dom';
import _ from 'underscore';

var classNames = require('classnames');
var sectionItemNum = 0, sectionFieldNum = 0, template_id, section_id;

var SectionsEditor = React.createClass({
    getInitialState: function() {
        return ({
            sectionItems: []
        });
    },
    addSectionItem: function(event) {
        var sectionItems = this.state.sectionItems;
        sectionItems.push(<SectionItem />);
        this.setState({
            sectionItems: sectionItems
        });
    },
    render: function() {
        template_id = this.props.id;
        console.log("test id "+template_id);
        return (
            <div className="col-md-10">
                <div className="panel panel-default">
                    <div className="panel-heading">
                        <h3 className="panel-title">Add Sections and Fields</h3>
                    </div>
                    <div className="panel-body">
                        <p>This will set up your sections, such as Ask or Investigate, 
                        and the types of content under each, such as design challenge or 
                        experiment.</p>
                        <form>
                            <SectionItem />
                            { this.state.sectionItems.map(function(item, i) {;
                                return (<SectionItem key={i}/>);
                            })}
                            <div className="btn btn-default" onClick={ this.addSectionItem }>add new section and fields</div>
                        </form>
                    </div>
                </div>
            </div>
        )
    }
});


var SectionItem = React.createClass({
    componentWillMount() {
        //this.section_input_name = "section_name_"+sectionItemNum;
       // this.section_description_name = "section_description_"+sectionItemNum;
        this.section_placeholder = "Section "+sectionItemNum+" title...";
    },
    propTypes: {
        section_id: React.PropTypes.number,
        section_title: React.PropTypes.string,
        section_description: React.PropTypes.string
    },
    getInitialState: function() {
        sectionItemNum++; 
        sectionFieldNum = 0;
        return ({
            section_id: undefined,
            section_title:"",
            sectionFields: []
        });
    },
    addSectionField: function(event) {
        var sectionFields = this.state.sectionFields;
        sectionFields.push(<SectionField />);
        this.setState({
        sectionFields: sectionFields
        });
    },
    handleChange: function(e) {
        var state = {};
        state[e.target.name] =  $.trim(e.target.value);
        state['success'] = "";
        this.setState(state);
    },
    saveSection: function(e) {
        var data = {};
        var name = e.target.name;
        var value = $.trim(e.target.value);
      //  console.log("Section name "+name);
      //  console.log("Section value "+value);

        data[name] = value;
        data['template_id'] = template_id;
        data['order'] = sectionItemNum; // Set up for future re-ording capability

        if (this.state.section_id) {
            data['section_id'] = this.state.section_id;
        }
 
      //  console.log("2 test id "+template_id);

       // console.log("DATA "+JSON.stringify(data));


        this.setState({ error: {}});
        this.setState({ success: ""});

        $.ajax({
            type: 'POST',
            url: '/admin/templates/section',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
            console.log(JSON.stringify(result));
            section_id = result['id'];
            this.setState({ section_id: section_id});
            this.setState({success:"true"}); 
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            console.log("ERROR "+JSON.stringify(error));
            this.setState({ error: error });
        }.bind(this));
    },
    render: function() {
    
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
                            placeholder={this.section_placeholder}
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
                            type="text" 
                            required={true} 
                            placeholder="Short description" 
                            onBlur={this.saveSection}
                            />
                        </div>
                    </div>
                </div>
                <SectionField />
                    { this.state.sectionFields.map(function(field, f) {
                        return (<SectionField key={f}/>)
                    })}

                <div className="row">
                    <div className=" col-sm-offset-1 col-sm-6">
                        <div className="form-group">
                            <div className="btn btn-default" onClick={ this.addSectionField }>add field to this section</div>
                        </div> 
                    </div> 
                </div>
            </div>
        );
    }
});


var SectionField = React.createClass({

    componentWillMount() {
       // this.field_input_name = "section_"+sectionItemNum+"_field_name_"+sectionFieldNum;
        this.field_required = "section_"+sectionItemNum+"_field_required_"+sectionFieldNum;
        this.field_required_value = "false";
        this.field_placeholder = "Field "+sectionFieldNum+" title...";
    },
    propTypes: {
        field_title: React.PropTypes.string,
        field_section_id:React.PropTypes.number,
        field_id:React.PropTypes.number
    },
    getInitialState: function() {
        sectionFieldNum++;
        return ({
            field_id: undefined,
            field_title:"",
            field_section_id: undefined,
            required_field: true
        });
    },
    handleChange: function(e) {
        var state = {};
        state[e.target.name] =  $.trim(e.target.value);
        state['success'] = "";

        this.setState(state);
    },
    saveField: function(e) {
        var data = {}, state = {};
        var name = e.target.name;
        var value = $.trim(e.target.value);
        console.log('section id '+section_id);
        this.setState({field_section_id: section_id});

        if (/field_required/.test(name)) {
            this.setState({required_field: !this.state.required_field});
        }

        data[name] = value;
        data['order'] = sectionItemNum; // Set up for future re-ording capability

        data['field_section_id'] = section_id;

        if (this.state.field_section_id) {
            data['field_section_id'] = this.state.field_section_id;
        }
        if (this.state.field_id) {
            data['field_id'] = this.state.field_id;
        }

       // console.log("3 test id "+template_id);
       // 
       console.log('DATA '+JSON.stringify(data));

        //console.log("Field name "+name);
       // console.log("Field value "+value);

        this.setState({ error: {}});
        this.setState({ success: ""});

        $.ajax({
            type: 'POST',
            url: '/admin/templates/section-field',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
            console.log(JSON.stringify(result));
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
        console.log('section id '+section_id);
        console.log("Field Section "+sectionFieldNum+" id "+this.state.field_section_id);
        return (

            <div className="row">
                <div className="col-sm-offset-1 col-sm-6">
                    <div className="form-group">
                        <input 
                        className="form-control" 
                        name="field_title"
                        value={this.props.field_title} 
                        type="text" 
                        required={true} 
                        placeholder={this.field_placeholder}
                        onBlur={this.saveField}
                        />
                    </div>
                </div>
                <div className="col-sm-5">
                    <div className="form-group">
                        <label>
                        <input type="checkbox"
                        name="field_required"
                        value={this.state.required_field}
                        onChange={this.saveField}/>
                        &nbsp; required field?
                        </label>  
                    </div>
                </div>
            </div>
        )
    }
});

module.exports = SectionsEditor;