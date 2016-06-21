import React from 'react';
import ReactDOM from 'react-dom';
import CreateCompetencyFramework from './Class/create_competency_framework.jsx';


var CompetencyFrameworkForm = React.createClass({
  propTypes: {
    frameworkId: React.PropTypes.string
  },
  getInitialState: function() {
    return {
      cf_id: undefined,
    };
  },
	render: function() {
    	return (
      		<div>
            <CreateCompetencyFramework frameworkId={this.props.frameworkId}/>
      		</div>
    	);
  	}

});


module.exports = CompetencyFrameworkForm;