import React from 'react';
import ReactDOM from 'react-dom';
import _ from 'underscore';
import Lightbox from 'react-images';

var docIcon = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '')+'/images/doc-icon.png';

var FilesDisplay = React.createClass({
    getInitialState: function() { 
        var savedFiles = JSON.parse(this.props.files);
        var files = [];

        console.log("savedFiles "+JSON.stringify(savedFiles));

        _.each(savedFiles, function(file) {
            var name = file['uri'].substr(file['uri'].lastIndexOf('/') + 1); 
            files.push({'field_content_id':file['id'],'caption':name, 'src':file['uri'],'saved_type':file['type']});
        });

       // console.log("files "+JSON.stringify(files));

        return {
            files: files,
            lightboxIsOpen: false,
            currentImage: 0,
        };
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
    renderGallery () {
        if (!this.state.files) return;
        const gallery = this.state.files.map((file, i) => {
            console.log("type "+file.saved_type)
             if(file.saved_type == "image") {
                var tooltip = "View "+file.caption;
                return (
                    <div>
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
    
    render: function() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        return(
            <div>
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
        )
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

module.exports = FilesDisplay;