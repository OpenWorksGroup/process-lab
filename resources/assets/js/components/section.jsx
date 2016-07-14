import React from 'react';
import ReactDOM from 'react-dom';
import SectionFields from './Class/section_fields.jsx';

var SectionFieldsForm = React.createClass({
	render: function() {
    	return (
      		<div>
        		<SectionFields 
            contentId={this.props.contentId}
            sectionId={this.props.sectionId} 
            loadInfo={this.props.loadInfo}
            />
      		</div>
    	);
  	}

});

module.exports = SectionFieldsForm;