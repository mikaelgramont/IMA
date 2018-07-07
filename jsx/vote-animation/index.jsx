const React = require('react');
const ReactDOM = require('react-dom');

const VoteAnimation = require('./vote-animation.jsx');



ReactDOM.render((
    <VoteAnimation
        items={window.items}
        {...window.voteData}/>
), document.getElementById('vote-animation'));