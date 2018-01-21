const React = require('react');

const Preview = require('./preview.jsx');

class ContentTable extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			content: [],
			issues: [],

			showUsed: false,
			showDiscarded: false,
			currentIssueTime: 0
		};

		this.issueEl = null;

		this.onShowUsedChange = this.onShowUsedChange.bind(this);
		this.onShowDiscardedChange = this.onShowDiscardedChange.bind(this);
		this.onCurrentIssueChange = this.onCurrentIssueChange.bind(this);
	}

	render() {
		return (
			<div>
				<div className="controls-wrapper">
					<label className="control">
						<span className="issueLabel">Show content for issue:</span>
						<select ref={(el) => {this.issueEl = el}} onChange={this.onCurrentIssueChange}>
							{this.state.issues.map((issue) => {
								return <option key={issue.time} value={issue.time}>{issue.name}</option>;
							})}
						</select>
					</label>
					<label className="control">
						<input type="checkbox" checked={this.state.showUsed} onChange={this.onShowUsedChange} />
						Show items featured in previous issues
					</label>
					<label className="control">
						<input type="checkbox" checked={this.state.showDiscarded} onChange={this.onShowDiscardedChange} />
						Show discarded items
					</label>
				</div>
				<table className="content-table">
					<thead>
						<tr>
							<th>Id</th>
							<th>Category</th>
							<th>Content</th>
						</tr>
					</thead>
					<tbody>
						{this.state.content.map((row) => {
							let rowClasses = ["content-row"];
							rowClasses.push(row.actions.discarded ? "discarded-row" : "");
							rowClasses.push(row.actions.markAsUsed ? "used-row" : "");

							return <tr key={row.metadata.id} className={rowClasses.join(" ")}>
								<td className="id">{row.metadata.id}</td>
								<td className="category">
									{this.renderCategory(row)}
								</td>
								<td className="preview">
									<Preview previewData={row.preview} actionData={row.actions}/>
								</td>
							</tr>;
						})}
					</tbody>
				</table>
			</div>
		);
	}

	componentDidMount() {
		const seed = JSON.parse(document.getElementById('seed').innerText);
		this.setState({
			content: seed.content,
			issues: seed.issues,
			currentIssueTime: seed.issues[0].time
		});
	}


	renderCategory(row) {
		return (
			<div>
				{row.metadata.category}
				{row.actions.discarded ? <p className="row-status">(Discarded)</p> : ""}
				{row.actions.markAsUsed ? <p className="row-status">(Already used)</p> : ""}
			</div>
		);
	}	

	onShowUsedChange() {
		this.setState({showUsed: !this.state.showUsed}, this.updateContent.bind(this));
	}

	onShowDiscardedChange() {
		this.setState({showDiscarded: !this.state.showDiscarded}, this.updateContent.bind(this));
	}

	onCurrentIssueChange() {
		this.setState({currentIssueTime: this.issueEl.value}, this.updateContent.bind(this));
		console.log("Selected issue time:", this.issueEl.value);
	}

	updateContent() {
		const url = "./newsletter-ajax";
		let formData = new FormData();
		formData.append('showUsed', this.state.showUsed);
		formData.append('showDiscarded', this.state.showDiscarded);
		formData.append('currentIssueTime', this.state.currentIssueTime);

		fetch(url, {
			method: 'POST',
			body: formData
		}).then((response) => {
			return response.json();
		}).then((json) => {
			console.log('json', json);
			this.setState({
				content: json.content
			});
		});
	}
}

module.exports = ContentTable;