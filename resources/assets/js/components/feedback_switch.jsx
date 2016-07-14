import React from 'react';
import ReactDOM from 'react-dom';
import Toggle from 'react-toggle';
import FormSavedNotice from './form_saved_notice.jsx';

var FeedbackSwitchForm = React.createClass({
	getInitialState: function() {
		var feedbackOnStatus = false, id;
		var sectionComments = JSON.parse(this.props.sectionComments);
		feedbackOnStatus = sectionComments['feedbackOn'];
		id = sectionComments['id'];

		return {
			id: id,
			contentId: this.props.contentId,
			sectionId: this.props.sectionId,
      		feedbackOn: feedbackOnStatus,
    	};
	},
	handleChange: function() {
		var data = {};
		data['feedback_on'] = !this.state.feedbackOn;
		this.setState({feedbackOn: !this.state.feedbackOn});
		console.log("feedbackOn "+!this.state.feedbackOn);

    	if (this.state.id) { 
    		data['id'] = this.state.id;
    	}

    	data['content_id'] = this.state.contentId;
    	data['template_section_id'] = this.state.sectionId;

    	$.ajax({
            type: 'POST',
            url: '/artifact-feedback-switch',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
        	if (result['id']) {
                this.setState({ id: result['id'] });
            }
            this.setState({success:true});
        }.bind(this))

	},
	render: function() {
  		return (
  			<div>
  				<div>
                    {this.state.success ?
                        <FormSavedNotice/>
                    : null}
            	</div>
  				<label>
					<span>Share </span>
  					<Toggle
  					id="section-feedback-status"
  					checked={this.state.feedbackOn}
  					onChange={this.handleChange} />
  				</label>
  			</div>
		);
	}

});

module.exports = FeedbackSwitchForm;