import React from 'react';
import { Form, Input, Row, Col } from 'antd';

const defaultState = {};

export default class extends React.Component {
    state = {...defaultState};

    componentWillReceiveProps(nextProps) {

    }

    render() {
        const {allPlayers, match} = this.props;
        console.log(match, allPlayers)
        return ('yolo'
            // <Row className="matches-row" key={key}>
            //     <Col xs={10}>
            //         {currentPlayers[0].name} - {currentPlayers[1].name}
            //     </Col>
            //     <Col className="versus" xs={4}>
            //         VS
            //     </Col>
            //     <Col xs={10}>
            //         {currentPlayers[2].name} - {currentPlayers[3].name}
            //     </Col>
            // </Row>
        )
    }
}