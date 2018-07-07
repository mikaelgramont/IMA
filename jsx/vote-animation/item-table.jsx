const React = require('react');

class ItemTable extends React.Component {
    render() {
        const {items, tally} = this.props;
        const rows = items.map((item, index) => {
            return <ItemTableRow key={index} item={item} total={tally[index]}/>
        });
        return (
            <table>
                <tbody>
                    {rows}
                </tbody>
            </table>
        );
    }
}

class ItemTableRow extends React.Component {
    render() {
        const {item, total} = this.props;
        return (
            <tr>
                <td>{item.displayName}</td>
                <td>{total}</td>
            </tr>
        );
    }
}

module.exports = ItemTable;