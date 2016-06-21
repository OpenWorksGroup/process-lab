import React from 'react';
import ReactDOM from 'react-dom';

var ReactTags = require('react-tag-input').WithContext;
import _ from 'underscore';
var contentTags = [];

var TagsEditor = React.createClass({

  getInitialState: function() {
	 $.ajax({
	   type: 'GET',
	   url: '/api/content-tags'
	 })
	 .success(function(dataTags) {
		  _.each(dataTags, function(dataTag){
            if (dataTag['type'] == "content") {
                contentTags.push(dataTag['tag']);
            }
		  });
	 });

	 return {
		  tags: [],
		  suggestions: contentTags,
      error: undefined,
    }
  },
  handleDelete: function(i) {
    this.setState({ error: undefined});
    var data = {};
    data['template_id'] = this.props.id;

    var tags = this.state.tags;
    var tag = tags[i]['text'];
    data['tag'] = tag;

    tags.splice(i, 1);
    this.setState({tags: tags});

    $.ajax({
      type: 'DELETE',
      url: '/api/content-tags/',
      data: data,
      dataType: 'json',
    })
    .success(function(result) {
        if (result['success']) {
            tags.splice(i, 1);
            this.setState({tags: tags});
        }      

    }.bind(this))
    .error(function(result) {
      var error = result.responseJSON;
      if (error) {
        var errMessage = error['tag'] + error['message'];
        this.setState({ error: errMessage });
      }
    }.bind(this)); 
  },
  handleAddition: function(tag) {
    this.setState({ error: undefined});
    var data = {};
    data['template_id'] = this.props.id;
    data['tag'] = tag;

    $.ajax({
      type: 'POST',
      url: '/api/content-tags',
      data: data,
      dataType: 'json',
    })
    .success(function(result) {

      var tags = this.state.tags;

      tags.push({
        id: tags.length + 1,
        text: tag
      });
      this.setState({tags: tags});

    }.bind(this))
    .error(function(result) {
      var error = result.responseJSON;
      if (error) {
        var errMessage = error['tag'] + error['message'];
        this.setState({ error: errMessage });
      }
    }.bind(this));   
  },
  handleDrag: function(tag, currPos, newPos) {
    var tags = this.state.tags;

    // mutate array
    tags.splice(currPos, 1);
    tags.splice(newPos, 0, tag);

    // re-render
    this.setState({ tags: tags });
    },
    render: function() {
      var tags = this.state.tags;
      var suggestions = this.state.suggestions;
      var errValue = "";

      if (this.state.error) {
          errValue = this.state.error;
      }

      return (
        <div className="col-md-10" id="tags-editor">
        <label className="control-label">Tags</label>
        <ReactTags tags={tags}
        suggestions={contentTags}
        handleDelete={this.handleDelete}
        handleAddition={this.handleAddition}
        handleDrag={this.handleDrag}
        autofocus={false}
        minQueryLength={2}/>

        <span className="help-block text-danger">{errValue}</span>
      </div>
    )
  }
});

module.exports = TagsEditor;