const React = require('react');

class ItemGraph extends React.Component {
    render() {
        const {items, tally, stretch} = this.props;

        const totalVotes = tally.reduce((acc, current) => {
            return acc + current;
        }, 0)

        const bars = items.map((item, index) => {
            const ratio = (totalVotes === 0) ? 0 : tally[index] / totalVotes;
            return <GraphBar key={index} position={index} item={item} tally={tally[index]} ratio={ratio} stretch={stretch}/>
        });
        return (
            <div className="graph">
                {bars}
            </div>
        );
    }
}

class GraphBar extends React.Component {
    render() {
        const {item, index, ratio, tally, stretch} = this.props;
        const percentage = `${ratio * 100 * stretch}%`;

        const barStyle = {
            backgroundColor: item.barColor,
            height: percentage
        }

        const thumbStyle = {
            background: `url(${item.image})`,
            bottom: percentage
        }

        return (
            <div className="graph-bar-wrapper">
                <div className="graph-bar" style={barStyle}></div>
                <div className="graph-thumb" style={thumbStyle}></div>
            </div>
        );
    }
}

module.exports = ItemGraph;