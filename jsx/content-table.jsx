const React = require('react');

const Preview = require('./preview.jsx');

class ContentTable extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			content: []
		};

	}

	render() {
		return (
			<table className="content-table">
				<thead>
					<tr>
						<th>Id</th>
						<th className="timestamp-header">Date</th>
						<th>Category</th>
						<th>Preview</th>
					</tr>
				</thead>
				<tbody>
					{this.state.content.map((row) => {
						return <tr key={row.metadata.id} className="content-row">
							<td>{row.metadata.id}</td>
							<td className="timestamp">{row.metadata.timestamp}</td>
							<td className="category">{row.metadata.category}</td>
							<td className="preview">
								<Preview previewData={row.preview} actionData={row.actions}/>
							</td>
						</tr>;
					})}
				</tbody>
			</table>
		);
	}

	componentDidMount() {
		const seed = JSON.parse(document.getElementById('seed').innerText);
		console.log('seed', seed);

		this.setState({content: seed.content});
	}
}

module.exports = ContentTable;