const React = require('react');

const ExpandButton = require('./expand-button.jsx');

class Preview extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			expanded: false,
			description: props.previewData.description,
			comment: props.previewData.IMAComment,
		};
		this.onExpandClick = this.onExpandClick.bind(this);
		this.onMarkAsUsedClick = this.onMarkAsUsedClick.bind(this);
		this.onDiscardClick = this.onDiscardClick.bind(this);
		this.onDescriptionChange = this.onDescriptionChange.bind(this);
		this.onCommentChange = this.onCommentChange.bind(this);

		this.descriptionEl = null;
		this.commentEl = null;
	}

	onExpandClick() {
		this.setState({expanded: !this.state.expanded});
		}

	expand() {
		this.setState({'expanded': true});
	}

	collapse() {
		this.setState({'expanded': false});
	}


	render() {
		const mainClass = "preview-main preview-content " + (this.state.expanded ? "expanded" : "");

		return (
			<section>
				<header className="preview-header" onClick={this.onExpandClick}>
					<h2 className="preview-title-text">{this.props.previewData.title}</h2>
					<ExpandButton direction={this.state.expanded ? "up" : "down"} />
				</header>
				
				<div className={mainClass}>
					<div className="image-container">
						{this.renderImage()}
					</div>
					<div className="info-container">
						<p>
							<label>
								Link:
								<a className="link" href={this.props.previewData.url} target="_blank">
									{this.props.previewData.url}
								</a>
							</label>
						</p>					
						<p>
							<label htmlFor="description" className="textarea-label">Description</label>
							<textarea
								onChange={this.onDescriptionChange}
								name="description"
								value={this.state.description}
								ref={(el) => {this.descriptionEl = el;}}
								>
							</textarea>
						</p>
						<p>
							<label htmlFor="comment" className="textarea-label">IMA comment</label>
							<textarea
								onChange={this.onCommentChange}
								name="comment"
								value={this.state.comment}
								ref={(el) => {this.commentEl = el;}}>
							</textarea>
						</p>
						<footer className="preview-footer">
							<p className="footer-text">
								Submitted by <a href={"mailto:" + this.props.previewData.email}>{this.props.previewData.email}</a> on {this.props.previewData.timestamp}.
							</p>
							<div className="actions">
								<button className="entry-action" onClick={this.onMarkAsUsedClick}>
									{this.props.actionData.markAsUsed ? "Mark as new" : "Mark as used"}
								</button>
								<button className="entry-action" onClick={this.onDiscardClick}>
									{this.props.actionData.discarded ? "Keep" : "Discard"}
								</button>
							</div>
						</footer>
					</div>
				</div>
			</section>
		);
	}

	renderImage() {
		if (!this.props.previewData.image) {
			return <span>No image</span>;
		}

		return <img className="image" src={this.props.previewData.image} />;
	}

	onMarkAsUsedClick() {
		this.props.onMarkAsUsed(this.props.id, this.props.actionData.markAsUsed);
	}

	onDiscardClick() {
		this.props.onDiscard(this.props.id, this.props.actionData.discarded);
	}

	onDescriptionChange(e) {
		this.setState({'description': this.descriptionEl.value}, () => {
			this.props.onDescriptionChange(this.props.id, this.state.description);	
		});
	}

	onCommentChange() {
		this.setState({'comment': this.commentEl.value}, () => {
			this.props.onCommentChange(this.props.id, this.state.comment);		
		});
		
	}
}

module.exports = Preview;