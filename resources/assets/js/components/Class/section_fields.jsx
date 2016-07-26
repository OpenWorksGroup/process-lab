import React from 'react';
import ReactDOM from 'react-dom';
import _ from 'underscore';
import FormSavedNotice from '../form_saved_notice.jsx';
import TinyMCE from 'react-tinymce';
import Dropzone from 'react-dropzone';
import Lightbox from 'react-images';
import Loader from 'react-loader';

var classNames = require('classnames');
var docIcon = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '')+'/images/doc-icon.png';

var SectionFields = React.createClass({
	getInitialState: function() { 
		var loadedInfo = JSON.parse(this.props.loadInfo);
		var fields = [];
		//console.log("LOADED INFO "+JSON.stringify(loadedInfo));

		_.each(loadedInfo['fields'], function(fieldObj) {
			//console.log("FIELD "+JSON.stringify(fieldObj));
			_.each(fieldObj, function(field) {
				var fieldContent = "",fieldContentId,fieldLinks = [], fieldFiles = [];

				//console.log("FIELD CONTENT "+JSON.stringify(field['savedContent']));
				if (field['savedContent'].length) {
					_.each(field['savedContent'], function(content) {
						if (content['type'] == "text") {
							fieldContentId = content['id'];
							fieldContent = content['content'];
						}
						else if (content['type'] == "link") {
							fieldLinks.push({'id':content['id'],'uri':content['uri']});
						}
						else {
							fieldFiles.push({'id':content['id'],'uri':content['uri'],'saved_type':content['type']});
						}
					});
				}
				fields.push({'id':field['id'],
					'title':field['field_title'], 
					'required':field['required'], 
					'field_content_id': fieldContentId,
					'content':fieldContent,
					'links':fieldLinks,
					'files':fieldFiles
				});
			});
		});

		//console.log("FIELDS "+JSON.stringify(fields));

		return {
            fields: fields
        };
	},
	render: function() {
		var contentId = this.props.contentId;
		var sectionId = this.props.sectionId;

		return(
			<form>

				{
					this.state.fields.map(function(field, i) {
                        return (
                        	<Field
                            key={i} 
                            field_id={field['id']}
                            field_content_id={field['field_content_id']}
                            title={field['title']} 
                            required={field['required']} 
                            content={field['content']}
                            links={field['links']}
                            files={field['files']}
                            content_id={contentId}
                            section_id={sectionId}/>
                        );
                    })
                }
			</form>


		)
	}
});

var Field = React.createClass({
	getInitialState() {
		//console.log("LINKS "+JSON.stringify(this.props.links));
    	return {
    		field_content_id: this.props.field_content_id,
    		links: this.props.links,
      		content: "",
      		success: undefined,
      		error: {}
    	};
  	},
	handleChange: function(e) {
        this.setState({
      		content: e.target.getContent()
    	});

    	var data = {};
    	if (this.state.field_content_id) { 
    		data['id'] = this.state.field_content_id;
    	}
    	data['type'] = "text";
    	data['content'] = this.state.content;
    	data['content_id'] = this.props.content_id;
    	data['template_section_field_id'] = this.props.field_id;

    	//console.log("DATA "+JSON.stringify(data));

    	$.ajax({
            type: 'POST',
            url: '/artifact/field',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
        	if (result['id']) {
                this.setState({ field_content_id: result['id'] });
            }
            this.setState({success:"true"});
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            this.setState({ error: error });
        }.bind(this));

    },
    removeLink: function(field_content_id){
    	console.log("field_content_id "+field_content_id);
    	console.log("this.state.links "+JSON.stringify(this.state.links));
    	var links = this.state.links.filter(function(l){
      		return field_content_id !== l.id;
    	});

    	console.log("links "+JSON.stringify(links));

    	this.setState({
      		links: links
    	});
  	},
	render: function() {
		var fieldId = this.props.field_id;
		var contentId = this.props.content_id;
		var sectionId = this.props.section_id;
		var removeLink = this.removeLink;

		return(
			<div className="vertical-spacer-40">
				<div>
                    {this.state.success ?
                        <FormSavedNotice/>
                    : null}
            	</div>
				<div className="vertical-spacer-40">
					<h3 className="inline-block">{this.props.title}</h3> { this.props.required ? 
						<span className="required"><i className="fa fa-asterisk"></i></span> : null
					}
					<TinyMCE
        			content={this.props.content}
        			config={{
          				plugins: 'link lists',
          				toolbar: 'undo redo | fontsizeselect | bold italic underline | ' +
							'alignleft aligncenter alignright | ' + 'bullist numlist outdent indent | link | ',
						menubar: false,
						fontsize_formats: '12pt 14pt 16pt 24pt 32pt 48pt 72pt'
        			}}
        			onChange={this.handleChange}
      				/>
      			</div>

      			<div className="vertical-spacer-40">
					<h4 className="inline-block">Links</h4> <span>(Websites, Videos, Google Docs)</span>
				
						{
							this.state.links.length > 0 ?
								this.state.links.map(function(link, i) {
                    				return (<div className="vertical-spacer-10">
                    						<Link
                    						key={i}
                							field_id={fieldId}
                							field_content_id = {link['id']}
                							field_uri = {link['uri']}
                							content_id={contentId}
                							section_id={sectionId}
                							onRemove={removeLink}
                							/>
                						</div>
                    				);
                				})
							: 

							<div className="vertical-spacer-10">
                    						<Link
                							field_id={fieldId}
                							content_id={contentId}
                							section_id={sectionId}
                							onRemove={removeLink}/>
                						</div>
						}
								

                	
                	<AddLink field_id={fieldId} content_id={contentId} section_id={sectionId} />
                </div>

                <div className="vertical-spacer-40">
					<h4 className="inline-block">Files</h4> (Allowed file types: .jpg/.jpeg, .gif, .png, .pdf, .doc, .docx)
					<div className="vertical-spacer-10">
      					<File
                		field_id={fieldId}
                		files={this.props.files}
                		content_id={contentId}
                		section_id={sectionId}/>
                	</div>
                </div>
      		</div>
		)
	}
});

var Link = React.createClass({
	getInitialState() {
    	return {
    		field_content_id: this.props.field_content_id,
    		uri:this.props.field_uri,
      		success: undefined,
      		error: {}
    	};
  	},
	handleChange: function(e) {
        var state = {};
        state[e.target.name] =  $.trim(e.target.value);
        this.setState(state);
    },
    saveChange: function(e) {
		var data = {};

    	if (this.state.field_content_id) { 
    		data['id'] = this.state.field_content_id;
    	}
    	data['type'] = "link";
    	data['uri'] = $.trim(e.target.value);
    	data['content_id'] = this.props.content_id;
    	data['template_section_field_id'] = this.props.field_id;

    	//console.log("DATA "+JSON.stringify(data));

    	$.ajax({
            type: 'POST',
            url: '/artifact/field',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
        	if (result['id']) {
                this.setState({ field_content_id: result['id'] });
            }
            this.setState({success:true});
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            this.setState({ error: error });
        }.bind(this));
    },
    removeLink: function() {
    	event.preventDefault();
		var field_content_id = this.state.field_content_id;
		console.log("1 field_content_id "+field_content_id);

		var data = {};
        data['id'] = field_content_id;

        $.ajax({
            type: 'DELETE',
            url: '/artifact/field/delete',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
        	this.setState({
    			success:"true"
  			});  
  			return this.props.onRemove(field_content_id);
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            if (error) {
               	var error = result.responseJSON;
            	this.setState({ error: error });
            }
        }.bind(this)); 
    },
    render: function() {
		return(
			<div>
				<div>
                	{this.state.success ?
                    	<FormSavedNotice/>
                	: null}
            	</div>
				<input 
                className="form-control" 
                name="uri"
                value={this.state.uri} 
                defaultValue={this.props.uri} 
                type="text" 
                placeholder="ex: http://www.domain.com"
                onChange={this.handleChange}
                onBlur={this.saveChange}
                />{this.state.field_content_id ?
                	<div className="removeClick" onClick={this.removeLink}>
						<i className="fa fa-times" aria-hidden="true"></i>
					</div>
					: null }
            </div>
        );
	}		
});


var AddLink = React.createClass({  
    getInitialState: function() {
        return {
            links: []
        }
    },   
    addLink: function(e) {
        e.preventDefault();

        var links = this.state.links;
        links.push(<Link />);
        this.setState({links: links});
    },
    render: function() {

    	var field_id = this.props.field_id;
    	var links = this.state.links;
    	var contentId = this.props.content_id;
		var sectionId = this.props.section_id;

        return (

            <div>
                { this.state.links.map(function(link, i) {;
                    return (
                    	<div className="vertical-spacer-10">
                    		<Link key={i} links={links} field_id={field_id} content_id={contentId} section_id={sectionId}/>
                    	</div>
                    );
                })}
                <br/>
                <div className="btn btn-default" onClick={this.addLink}><i className="fa fa-btn fa-plus"></i> add link</div>
            </div>
        );
    }
});

var File = React.createClass({
	getInitialState: function() {
		var savedFiles = [];
		_.each(this.props.files, function(file) {
			var name = file['uri'].substr(file['uri'].lastIndexOf('/') + 1); 
			savedFiles.push({'field_content_id':file['id'],'caption':name, 'src':file['uri'],'saved_type':file['saved_type']});
		});
        return {
            files: savedFiles,
            lightboxIsOpen: false,
            currentImage: 0,
            loaded: true
        }
    },  
    openLightbox (index, event) {
		event.preventDefault();
		this.setState({
			currentImage: index,
			lightboxIsOpen: true,
		});
	},
	closeLightbox () {
		this.setState({
			currentImage: 0,
			lightboxIsOpen: false,
		});
	},
	gotoPrevious () {
		this.setState({
			currentImage: this.state.currentImage - 1,
		});
	},
	gotoNext () {
		this.setState({
			currentImage: this.state.currentImage + 1,
		});
	},
	handleClickImage () {
		if (this.state.currentImage === this.state.files.length - 1) return;

		this.gotoNext();
	},
	removeFile (i,e) {
		var field_content_id = this.state.files[i]['field_content_id'];

		var data = {};
        data['id'] = field_content_id;

        $.ajax({
            type: 'DELETE',
            url: '/artifact/field/delete',
            data: data,
            dataType: 'json',
        })
        .success(function(result) {
        	this.setState({
    			files: this.state.files.filter((_, j) => j !== i),
    			success:"true"
  			});   
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            if (error) {
               	var error = result.responseJSON;
            	this.setState({ error: error });
            }
        }.bind(this)); 
	},
	onDrop: function (file) {

      	this.setState({ loaded: false });

      	var uploadedFiles = this.state.files;
      	var type = "image";
      	if (! file[0]['type'].match(/image/g)) {
			file[0]['showFile'] = "true";
			type = "file";
      	}

      	file[0]['caption'] = file[0]['name'];

    	var formData = new FormData;
        formData.append('file', file[0]);
        formData.append('type', type);
        formData.append('content_id', this.props.content_id);
        formData.append('template_section_field_id', this.props.field_id);

      $.ajax({
            type: 'POST',
            url: '/artifact/field',
            cache: false,
            dataType: "json",
            data: formData,
            contentType: false,
            processData: false
        })
        .success(function(result) {
        	if (result['id']) {
        		file[0]['field_content_id'] = result['id'];
        		file[0]['src'] = result['uri'];
        		file[0]['saved_type'] = result['type'];
                uploadedFiles.push(file[0]);
      			this.setState({
        			files: uploadedFiles,
        			success:"true",
        			loaded: true
      			});
            }
        }.bind(this))
        .error(function(result) {
            var error = result.responseJSON;
            this.setState({ error: error });
        }.bind(this));
    },
    renderGallery () {
		if (!this.state.files) return;
		const gallery = this.state.files.map((file, i) => {
			 if(file.saved_type == "image") {
			 	var tooltip = "View "+file.caption;
				return (
					<div>
						<div className="removeFile" style={styles.remove} onClick={(e) => this.removeFile(i, e)}>
							<i className="fa fa-times" aria-hidden="true"></i>
						</div>
						<a href={file.src}
						key={i}
						onClick={(e) => this.openLightbox(i, e)}
						style={styles.thumbnail}>
						<span
                    	data-toggle="tooltip" 
                    	data-placement="bottom" 
                    	title={tooltip}><img
						height={styles.thumbnail.size}
						src={file.src}
						style={styles.thumbnailImage}
						width={styles.thumbnail.size}
						/></span></a>
					</div>
				);
			}
			else {
				var tooltip = "Download "+file.caption;
				return (
					<div>
						<div className="removeFile" style={styles.remove} onClick={(e) => this.removeFile(i, e)}>
							<i className="fa fa-times" aria-hidden="true"></i>
						</div>
						<a href={file.src} style={styles.thumbnail} download={file.caption}>
						<span data-toggle="tooltip" 
                		data-placement="bottom" 
                		title={tooltip}><img
						height={styles.thumbnail.size}
						src={docIcon}
						style={styles.thumbnailImage}
						width={styles.thumbnail.size}
						/></span></a>
					</div>
				);
            }

		});

		return (
			<div style={styles.gallery}>
				{gallery}
			</div>
		);
	},
    render: function () {
    	var files = this.state.files
		var openModal = this.openModal;
		var modalIsOpen = this.state.modalIsOpen;
		var afterOpenModal = this.afterOpenModal;
		var closeModal = this.closeModal;

		$(function () {
  			$('[data-toggle="tooltip"]').tooltip()
		});

      	return (
          <div>
          	<div>
                {this.state.success ?
                    <FormSavedNotice/>
                : null}
            </div>
          	<Loader loaded={this.state.loaded}/>
            <Dropzone onDrop={this.onDrop}
            className="file-drop-zone"
            accept="image/jpeg,
            image/gif,
            image/png,
            application/pdf,
            application/msword,
            application/vnd.openxmlformats-officedocument.wordprocessingml.document,
            text/plain,
            application/javascript,
            application/json,
            application/vnd.oasis.opendocument.text"
            activeStyle={{borderStyle: 'solid', backgroundColor: 'rgba(255,255,255,.5)'}}
            rejectStyle={{color: 'red'}}>
              <div className="pick-area">Dropping files here, or click to select files to upload.</div>
            </Dropzone>

            {this.renderGallery()}

            <Lightbox
			currentImage={this.state.currentImage}
			images={this.state.files}
			isOpen={this.state.lightboxIsOpen}
			onClickPrev={this.gotoPrevious}
			onClickNext={this.gotoNext}
			onClickImage={this.handleClickImage}
			onClose={this.closeLightbox}
			theme={this.props.theme}
			/>

          </div>
      );
    }
});

const THUMBNAIL_SIZE = 72;

const styles = {
	gallery: {
		marginLeft: -5,
		marginRight: -5,
		overflow: 'hidden',
	},
	remove: {
		float: 'left',
	},
	thumbnail: {
		backgroundSize: 'cover',
		borderRadius: 3,
		float: 'left',
		height: THUMBNAIL_SIZE,
		margin: 5,
		overflow: 'hidden',
		width: THUMBNAIL_SIZE,
	},
	thumbnailImage: {
		display: 'block',
		height: 'auto',
		maxWidth: '100%',
	},
};

module.exports = SectionFields;