import React from 'react';
import {Button, InputNumber, Row, Col, Tabs} from 'antd';

const defaultState = {
    team1Result: 0,
    team2Result: 0
};

export default class extends React.Component {
    state = {...defaultState};

    componentWillReceiveProps(nextProps) {

    }

    renderMatch(match) {
        const {matches} = this.props;
        const {team1Result, team2Result} = this.state;
        const {allPlayers} = this.props;
        const players = match.map(x => allPlayers.find(({id}) => id === x));
        const nextMatchIndex = matches.findIndex(x => x === match) + 1;
        const nextPlayers = nextMatchIndex < matches.length &&
            matches[nextMatchIndex].map(x => allPlayers.find(({id}) => id === x));

        return (
            <div>
                <Row style={{textAlign: 'center'}}>
                    {nextMatchIndex}/{matches.length}
                </Row>
                <Row className="matches-row">
                    <Col offset={5} xs={5}>
                        <div>{players[0].name} - {players[1].name}</div>
                        <InputNumber value={team1Result} min={0} max={10}
                                     onChange={e => this.setState({team1Result: e})}/>
                    </Col>
                    <Col className="versus" xs={4}>
                        VS
                    </Col>
                    <Col xs={5}>
                        <div>{players[2].name} - {players[3].name}</div>
                        <InputNumber value={team2Result} min={0} max={10}
                                     onChange={e => this.setState({team2Result: e})}/>
                    </Col>
                </Row>
                {nextPlayers && (
                    <Row style={{textAlign: 'center'}}>
                        Következő:
                        <div>{nextPlayers[0].name}&nbsp;-&nbsp;{nextPlayers[1].name}&nbsp;Vs.&nbsp;
                        {nextPlayers[2].name}&nbsp;-&nbsp;{nextPlayers[3].name}</div>
                    </Row>
                )}
            </div>
        )
    }

    render() {
        const {matches, currentMatch, finishMatch} = this.props;
        const {team1Result, team2Result} = this.state;
        return (
            <div>
                <Tabs activeKey={currentMatch + ''} tabBarStyle={{display: 'none'}}>
                    {matches.map((x, i) => (
                        <Tabs.TabPane key={i} tab={i + ''}>
                            {this.renderMatch(x)}
                        </Tabs.TabPane>
                    ))}
                </Tabs>
                {(team1Result !== 0 || team2Result !== 0) &&
                <Row style={{textAlign: 'center', marginTop: 20}}>
                    <Button type="primary" onClick={() => this.setState(defaultState, () => finishMatch(team1Result, team2Result))}>
                        {currentMatch === matches.length - 1 ? 'Finish' : 'Next'}
                    </Button>
                </Row>
                }
            </div>
        )
    }
}