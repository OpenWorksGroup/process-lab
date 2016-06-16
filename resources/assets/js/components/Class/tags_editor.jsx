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
			 contentTags.push(dataTag['tag']);
		  });
	 });

	 return {
		  tags: [],
		  suggestions: contentTags,
      error: undefined,
    }
  },
  handleDelete: function(i) {
    var tags = this.state.tags;
    tags.splice(i, 1);
    this.setState({tags: tags});
    //add delete from tag_relationships here
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
      var errMessage = error['tag']+error['message'];
      this.setState({ error: errMessage });

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
        <div>
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