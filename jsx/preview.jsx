const React = require('react');

const ExpandButton = require('./expand-button.jsx');

class Preview extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			expanded: false
		};
		this.onExpandClick = this.onExpandClick.bind(this);
		this.onMarkAsUsedClick = this.onMarkAsUsedClick.bind(this);
		this.onDiscardClick = this.onDiscardClick.bind(this);
	}

	onExpandClick() {
		this.setState({
			expanded: !this.state.expanded
		});
	}

	render() {
		return (
			<div>
				<h2>
					<span className="entry-title">{this.props.previewData.title}</span>
					<div className="actions">
						<ExpandButton onClick={this.onExpandClick} label={this.state.expanded ? "Collapse" : "Expand"} />
						<img className="entry-action" onClick={this.onMarkAsUsedClick} src="./images/check-mark.svg" title={this.props.actionData.markAsUsed ? "Mark this entry as new" : "Mark this entry as used"} />
						<img className="entry-action" onClick={this.onDiscardClick} src="./images/delete.svg" title={this.props.actionData.discarded ? "Take this entry back" : "Discard this entry"} />
					</div>
				</h2>				
				<dl className={this.state.expanded ? "preview-content expanded" : "preview-content"}>
					<dt>Submitted by</dt>
					<dd>{this.props.previewData.email}</dd>

					<dt>Date</dt>
					<dd>{this.props.previewData.timestamp}</dd>
					
					<dt>Link</dt>
					<dd><a className="link" href={this.props.previewData.url} target="_blank">{this.props.previewData.url}</a></dd>

					<dt>Image</dt>
					<dd>
						{this.renderImage()}
					</dd>

					<dt>Description</dt>
					<dd>{this.props.previewData.description ? this.props.previewData.description : "N/A"}</dd>

					<dt>IMA comment</dt>
					<dd>{this.props.previewData.IMAComment ? this.props.previewData.IMAComment : "N/A"}</dd>
					
				</dl>
			</div>
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
}

module.exports = Preview;