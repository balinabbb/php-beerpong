import React from 'react';


export default class extends React.Component {
    render() {
        const {match: {params: {id}}} = this.props;
        console.log(id)
        return 'yolo'
    }
}
