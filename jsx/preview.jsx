const React = require('react');

const ExpandButton = require('./expand-button.jsx');

class Preview extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			expanded: false
		};
		this.onExpandClick = this.onExpandClick.bind(this);

	}

	onExpandClick() {
		console.log("Expand toggle");
		this.setState({
			expanded: !this.state.expanded
		});
	}

	render() {
		return (
			<div>
				<h2>
					{this.props.previewData.title}
					<ExpandButton onClick={this.onExpandClick} label={this.state.expanded ? "Collapse" : "Expand"} />
				</h2>				
				<div className={this.state.expanded ? "preview-content expanded" : "preview-content"}>
					<p>Submitted by {this.props.previewData.email}</p>
					<p>
						<a href={this.props.previewData.url} target="_blank">{this.props.previewData.url}</a>
					</p>
					<p>
						<img className="image" src={this.props.previewData.image} />
					</p>
					<div>Description:
						<p>{this.props.previewData.description}</p>
					</div>
					<div>IMA comment:
						<p>{this.props.previewData.IMAComment}</p>
					</div>
					<p><span className="hidden">Hide</span></p>
					<p><span className="hidden">Mark as used</span></p>
				</div>
			</div>
		);
	}
}

module.exports = Preview;