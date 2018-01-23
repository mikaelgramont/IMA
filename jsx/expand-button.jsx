const React = require('react');

class ExpandButton extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return <span role="button" className={"expand-button arrow arrow-" + this.props.direction} onClick={this.props.onClick}></span>;
	}
}

module.exports = ExpandButton;