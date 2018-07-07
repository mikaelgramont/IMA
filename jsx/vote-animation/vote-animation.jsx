const React = require('react');
const ReactDOM = require('react-dom');

const ItemGraph = require('./item-graph.jsx');
const ItemTable = require('./item-table.jsx');

let endClassName;
let scrollToEl;

class VoteAnimation extends React.Component {
    constructor(props) {
        super(props);

        // Real time duration of the animation, in seconds:
        const timeRange = props.endTime - props.startTime;
        // The number of steps to perform the whole animation:
        const numberOfSteps = this.props.animationDuration * 60;

        // How long each animaton step represents in real time:
        const stepDuration = timeRange / numberOfSteps;


        this.state = {
            playing: false,
            stepDuration,
            time: props.startTime,
            tally: this.getStartTally(),
            votesToProcess: this.props.votes.slice()
        }

        this.toggleState = this.toggleState.bind(this);
        this.play = this.play.bind(this);
        this.stop = this.stop.bind(this);
        this.reset = this.reset.bind(this);
        this.animate = this.animate.bind(this);
        this.step = this.step.bind(this);
        this.performStep = this.performStep.bind(this);
        this.getStartTally = this.getStartTally.bind(this);
        this.performReset = this.performReset.bind(this);
        this.rafId = null;
    }

    getStartTally() {
        const tally = [];
        this.props.items.forEach(item => {
            tally[item.index] = 0;
        });
        return tally;
    }

    toggleState() {
        if (this.state.playing) {
            this.stop();
        } else {
            this.play();
        }
    }

    play() {
        const rootEl = ReactDOM.findDOMNode(this);
        const startClassName = rootEl.parentElement.getAttribute('data-startClass');
        endClassName = rootEl.parentElement.getAttribute('data-endClass');

        const scrollToId = rootEl.parentElement.getAttribute('data-scrollTo');
        scrollToEl = document.getElementById(scrollToId);
        document.body.classList.add(startClassName);

        document.getElementById('animation-focus').scrollIntoView();

        if (this.state.time >= this.props.endTime) {
            this.performReset(this.animate);
        } else {
            this.setState({
                playing: true
            }, this.animate);
        }
    }

    stop() {
        this.setState({playing: false});
        cancelAnimationFrame(this.rafId);
    }

    reset() {
        this.performReset(() => {});
    }

    performReset(andThen) {
        this.setState({
            time: this.props.startTime,
            votesToProcess: this.props.votes.slice(),
            playing: false,
            tally: this.getStartTally()
        }, andThen);
    }

    animate() {
        const shouldContinue = this.performStep();
        if (!shouldContinue) {
            return;
        }

        this.rafId = requestAnimationFrame(this.animate);
    }

    step() {
        this.performStep();
    }

    performStep() {
        const newTime = this.state.time + this.state.stepDuration

        let {tally, votesToProcess} = this.state;

        // In order to process each vote only once, remove them from
        // the beginning of the list once we've taken them into account.
        let toRemoveFromStartOfList = 0;
        votesToProcess.forEach(vote => {
            if (vote.timestamp > newTime) {
                return;
            }
            tally[vote.choice] += 1;

            toRemoveFromStartOfList++;
        });
        votesToProcess.splice(0, toRemoveFromStartOfList);

        this.setState({time: newTime, tally, votesToProcess});
        if (newTime > this.props.endTime) {
            document.body.classList.add(endClassName);

            setTimeout(() => {
                scrollToEl.scrollIntoView();
            }, 0)

            this.stop();
            return false;
        }
        return true;
    }

    render() {
        const date = new Date(this.state.time * 1000);
        const day = date.toLocaleDateString({timeZone: 'UTC'});
        const time = date.toLocaleTimeString([], {timeZone: 'UTC', hour: '2-digit', minute:'2-digit'});
        const displayDate = `${day} ${time}`;

        return (
            <div>
                <button className="primary hidden-after-animation-started" id="trigger" onClick={this.play}>See the results!</button>
                <div id="animation-focus" className="animation-content">
                    <ItemGraph stretch={this.props.stretch} items={this.props.items} tally={this.state.tally} />

                    <div className="date">Date: {displayDate}</div>

                    <ItemTable items={this.props.items} tally={this.state.tally} />

                </div>
                <div className="button-container">
                    <button onClick={this.toggleState}>
                        {this.state.playing ? 'Stop':'Play'}
                    </button>
                    <button onClick={this.step}>
                        Step
                    </button>
                    <button onClick={this.reset}>
                        Reset
                    </button>
                </div>
            </div>
        );
    }
}

module.exports = VoteAnimation;