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
			currentIssueTime: 0,

			loading: true
		};

		this.issueEl = null;

		this.onShowUsedChange = this.onShowUsedChange.bind(this);
		this.onShowDiscardedChange = this.onShowDiscardedChange.bind(this);
		this.onCurrentIssueChange = this.onCurrentIssueChange.bind(this);
		this.onEntryMarkAsUsed = this.onEntryMarkAsUsed.bind(this);
		this.onEntryDiscard = this.onEntryDiscard.bind(this);
	}

	render() {
		return (
			<div>
				<p>{this.state.loading ? "Loading..." : "Ready."}</p>
				<div className="controls-wrapper">
					<label className="control">
						<span className="issueLabel">Show content for issue:</span>
						<select ref={(el) => {this.issueEl = el}} onChange={this.onCurrentIssueChange}>
							{this.state.issues.map((issue) => {
								return <option value={0} key={issue.time} value={issue.time}>{issue.name}</option>;
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
									<Preview id={row.metadata.id} previewData={row.preview} actionData={row.actions} onMarkAsUsed={this.onEntryMarkAsUsed} onDiscard={this.onEntryDiscard} />
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
		const currentIssueTime = seed.issues.length > 0 ? seed.issues[0].time : 0;

		this.setState({
			loading: false,
			content: seed.content,
			issues: seed.issues,
			currentIssueTime: currentIssueTime
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

	findRow(content, id) {
		const rowId = Object.keys(content).find((el) => {
			return content[el].metadata.id == id;
		});
		if (typeof rowId == 'undefined') {
			throw new Error("Could not find row " + id);
		}
		return content[rowId];
	}

	onEntryMarkAsUsed(id, currentMarkAsUsed) {
		let content = this.state.content.slice();
		let row = this.findRow(content, id);
		
		row.actions.markAsUsed = !currentMarkAsUsed;

		// Optimistic update.
		this.setState({content});

		// Call backend and maybe update state again (in case of error).
		this.updateRow(row);
	}

	onEntryDiscard(id, currentDiscarded) {
		let content = this.state.content.slice();
		let row = this.findRow(content, id);
		
		row.actions.discarded = !currentDiscarded;
		// Optimistic update.
		this.setState({content});

		// Call backend and maybe update state again (in case of error).
		this.updateRow(row);
	}

	updateRow(newRow) {
		const url = "./newsletter-entry-update";
		let formData = new FormData();
		formData.append('id', newRow.metadata.id);
		formData.append('markAsUsed', newRow.actions.markAsUsed);
		formData.append('discarded', newRow.actions.discarded);

		this.setState({loading: true});
		fetch(url, {
			method: 'POST',
			body: formData
		}).then((response) => {
			return response.json();
		}).then((json) => {
			// Copy content
			let content = this.state.content.slice();
			// Find the row
			let stateRow = this.findRow(content, newRow.metadata.id);

			// Update it
			stateRow.metadata = json.row.metadata;
			stateRow.actions = json.row.actions;
			stateRow.preview = json.row.preview;

			const loading = false;
			this.setState({content, loading});
		});
	}

	updateContent() {
		const url = "./newsletter-ajax";
		let formData = new FormData();
		formData.append('showUsed', this.state.showUsed);
		formData.append('showDiscarded', this.state.showDiscarded);
		formData.append('currentIssueTime', this.state.currentIssueTime);

		this.setState({loading: true});

		fetch(url, {
			method: 'POST',
			body: formData
		}).then((response) => {
			return response.json();
		}).then((json) => {
			const loading = false;
			this.setState({
				content: json.content,
				loading: loading
			});
		});
	}
}

module.exports = ContentTable;