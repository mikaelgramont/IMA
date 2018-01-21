const React = require('react');

class ExpandButton extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return <button className="expand-button" onClick={this.props.onClick} className="expand-button">{this.props.label}</button>;
	}
}

module.exports = ExpandButton;