const React = require('react');

const ItemTable = require('./item-table.jsx');

// Duration of the whole animation in seconds
const ANIMATION_DURATION = 20;


class VoteAnimation extends React.Component {
    constructor(props) {
        super(props);

        // Real time duration of the animation, in seconds:
        const timeStretch = props.endTime - props.startTime;
        // The number of steps to perform the whole animation:
        const numberOfSteps = ANIMATION_DURATION * 60;

        // How long each animaton step represents in real time:
        const stepDuration = timeStretch / numberOfSteps;


        const votesToProcess = this.props.votes.slice();

        this.state = {
            playing: false,
            stepDuration,
            time: props.startTime,
            tally: this.getStartTally(),
            votesToProcess
        }

        this.toggleState = this.toggleState.bind(this);
        this.play = this.play.bind(this);
        this.stop = this.stop.bind(this);
        this.reset = this.reset.bind(this);
        this.animate = this.animate.bind(this);
        this.step = this.step.bind(this);
        this.performStep = this.performStep.bind(this);
        this.getStartTally = this.getStartTally.bind(this);
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
        if (this.state.time >= this.props.endTime) {
            this.setState({
                time: this.props.startTime,
                votesToProcess: this.props.votes,
                playing: true
            }, this.animate);
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
        this.setState({
            time: this.props.startTime,
            votesToProcess: this.props.votes,
            playing: false
        });
    }

    animate() {
        this.performStep();
        this.rafId = requestAnimationFrame(this.animate);
    }

    step() {
        this.performStep();
    }

    performStep() {
        const newTime = this.state.time + this.state.stepDuration

        //let tally = {0:0, 1:0, 2:0, 3: 0};
        let {tally, votesToProcess} = this.state;

        let toRemoveFromStartOfList = 0;
        votesToProcess.forEach(vote => {
            if (vote.timestamp > newTime) {
                return;
            }

            // const date = new Date(vote.timestamp * 1000);
            // const day = date.toLocaleDateString({timeZone: 'UTC'});
            // const time = date.toLocaleTimeString([], {timeZone: 'UTC', hour: '2-digit', minute:'2-digit'});
            // const displayDate = `${day} ${time}`;

            //console.log(`Vote for ${vote.choice} at ${vote.timestamp} aka ${displayDate}`);
            tally[vote.choice] += 1;

            toRemoveFromStartOfList++;
        });

        votesToProcess.splice(0, toRemoveFromStartOfList);

        this.setState({time: newTime, tally, votesToProcess});


        if (newTime > this.props.endTime) {
            this.stop();
            return;
        }
    }

    render() {
        const date = new Date(this.state.time * 1000);
        const day = date.toLocaleDateString({timeZone: 'UTC'});
        const time = date.toLocaleTimeString([], {timeZone: 'UTC', hour: '2-digit', minute:'2-digit'});
        const displayDate = `${day} ${time}`;

        return (
            <div>
                <ItemTable items={this.props.items} tally={this.state.tally}/>
                <div>Date: {displayDate}</div>
                <button onClick={this.toggleState}>
                    {this.state.playing ? 'Stop':'Play'}
                </button>
                <button onClick={this.step}>
                    Step
                </button>
            </div>
        );
    }
}

module.exports = VoteAnimation;