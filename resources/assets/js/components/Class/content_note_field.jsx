import React from 'react';
import ReactDOM from 'react-dom';
import _ from 'underscore';
import FormSavedNotice from '../form_saved_notice.jsx';
import TinyMCE from 'react-tinymce';

var ContentNote = React.createClass({
    getInitialState: function() { 
        var note = (this.props.notes) ? this.props.notes:null;      

        return {
            id: undefined,
            note: note
        };
    },
    handleChange: function(e) {
        this.setState({
            note: e.target.getContent()
        });

        var data = {};
        if (this.state.id) { 
            data['id'] = this.state.id;
        }

        data['note'] = this.state.note;
        data['content_id'] = this.props.contentId;

        $.ajax({
            type: 'POST',
            url: '/artifact-notes',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
            if (result['id']) {
                this.setState({ id: result['id'] });
            }
            this.setState({success:"true"});
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            this.setState({ error: error });
        }.bind(this));

    },
    render: function() {
        return(
            <form>
                <div>
                    {this.state.success ?
                        <FormSavedNotice/>
                    : null}
                </div>

                <TinyMCE
                content={this.state.note}
                config={{
                    plugins: 'link lists',
                    toolbar: 'undo redo | fontsizeselect | bold italic underline | ' +
                    'alignleft aligncenter alignright | ' + 'bullist numlist outdent indent | link | ',
                    menubar: false,
                    fontsize_formats: '12pt 14pt 16pt 24pt 32pt 48pt 72pt'
                }}
                onChange={this.handleChange}
                />
            </form>

        );
    }
});

module.exports = ContentNote;