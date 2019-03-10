const React = require('react');

class ItemTable extends React.Component {
    render() {
        const {items, tally} = this.props;

        const totalVotes = tally.reduce((acc, current) => {
            return acc + current;
        }, 0)

        const rows = items.map((item, index) => {
            const ratio = (totalVotes === 0) ? 0 : tally[index] / totalVotes;
            return <ItemTableRow key={index} item={item} tally={tally[index]} ratio={ratio}/>
        });
        return (
            <table className="results-table">
                <thead>
                    <tr>
                        <td className="nameCell">Video name</td>
                        <td className="tallyCell">Score</td>
                    </tr>
                </thead>
                <tbody>
                    {rows}
                </tbody>
            </table>
        );
    }
}

class ItemTableRow extends React.Component {
    render() {
        const {item, ratio, tally} = this.props;
        const percentage = `${(ratio * 100).toFixed(2)}%`;

        return (
            <tr>
                <td className="nameCell">
                    <span className="coloredSquare" style={{backgroundColor: item.barColor}}></span>
                    <a className="itemLink" href={item.videoUrl} target="_blank">{item.displayName}</a>
                </td>
                <td className="tallyCell">{`${percentage} (${tally})`}</td>
            </tr>
        );
    }
}

module.exports = ItemTable;