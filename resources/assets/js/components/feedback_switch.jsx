import React from 'react';
import ReactDOM from 'react-dom';
import Toggle from 'react-toggle';

var FeedbackSwitchForm = React.createClass({
	getInitialState: function() {
		return {
      		feedbackOn: false,
    	};
	},
	handleChange: function() {

	},
	render: function() {
  		return (
  			<div>
  				<label>
					<span>Share </span>
  					<Toggle
  					id="section-feedback-status"
  					defaultChecked={this.state.feedbackOn}
  					onChange={this.handleChange} />
  				</label>
  			</div>
		);
	}

});

module.exports = FeedbackSwitchForm;