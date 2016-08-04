import React from 'react';
import ReactDOM from 'react-dom';
import SearchInput, {createFilter} from 'react-search-input';

const KEYS_TO_FILTERS = ['title', 'tags', 'userTags','author']

var ResourcesSearch = React.createClass({
  getInitialState () {
    return { 
      searchTerm: '' 
    }
  },
  render () {
    var resources = JSON.parse(this.props.data);
    const filteredResources = resources.filter(createFilter(this.state.searchTerm, KEYS_TO_FILTERS))

    return (
      <div>
        <SearchInput className="search-input" onChange={this.searchUpdated} />
        {filteredResources.map(resource => {
          return (
            <div className="row vertical-spacer-20" key={resource.id}>
              <div classnmae="col-md-12">
                <div><a href="/artifact/{resource.id}">{resource.title}</a></div>
                <div>by {resource.author}</div>
                <div>Published {resource.publishDate}</div>
                { resource.tags ?
                  <div>Tags: {resource.tags}</div>
                :null }
              </div>
            </div>
          )
        })}
      </div>
    )
  },
  searchUpdated (term) {
    this.setState({searchTerm: term})
  }
});

module.exports = ResourcesSearch;