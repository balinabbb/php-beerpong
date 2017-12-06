import React from 'react';
import {Table, Steps, Select, Form, Button, Row, Col} from 'antd';
import api from '../../api';
import Matches from './Matches';
import {subsets, subsetsLineups, shuffle} from "./helpers";

const columns = [
    {
        title: 'Team 1 Score',
        dataIndex: 'team1Score',
        key: 'team1Score'
    },
];

export default class extends React.Component {
    state = {
        step: 3,//todo make step 0
        allPlayers: [],
        selectedPlayers: [],
        matches: [],
        currentMatch: 0,
        results: []
    };

    fetchData() {
        const {match: {params: {id}}} = this.props; //todo remove with result get
        api.players.all()(({data}) => this.setState({allPlayers: data, selectedPlayers: data.map(({id}) => id)})); //todo remove selectedplayers
        api.cups.getResults(id)(({data}) => this.setState({results: data})) //TODO remove
    }

    componentWillMount() {
        this.fetchData();
    }

    getMatches() {
        const {selectedPlayers} = this.state;
        const allSubsets = subsets(selectedPlayers, 4);
        const allLineups = allSubsets.map(subsetsLineups);
        const flattenLineups = [].concat.apply([], allLineups);
        const applyKeys = flattenLineups.map((x, i) => ({key: i, lineup: x}));
        return shuffle(applyKeys);
    }

    finishMatch(team1Result, team2Result) {
        const {match: {params: {id}}} = this.props;
        const {currentMatch, matches} = this.state;
        api.cups.addResult(id, matches[currentMatch].lineup, team1Result, team2Result)(
            () => currentMatch < matches.length - 1 ?
                this.setState({currentMatch: currentMatch + 1}) :
                this.setState({step: 3})
        );
    }

    renderPlayerSelect() {
        const {allPlayers, selectedPlayers} = this.state;
        return (
            <div>
                <Form.Item label="Players">
                    <Select
                        style={{minWidth: 200}}
                        mode="multiple"
                        value={selectedPlayers}
                        onChange={e => this.setState({selectedPlayers: e})}
                    >
                        {allPlayers.map(({name, id}) => (
                            <Select.Option key={id} value={id}>
                                {name}
                            </Select.Option>
                        ))}
                    </Select>
                </Form.Item>
                {selectedPlayers.length >= 4 && (
                    <Button type="primary" onClick={() => this.setState({step: 1, matches: this.getMatches()})}>
                        Ok
                    </Button>
                )}
            </div>
        )
    }

    renderShuffle() {
        const {matches, allPlayers} = this.state;
        return (
            <div>
                <Button type="primary" onClick={() => this.setState({step: 2})} style={{marginRight: 20}}>
                    Start
                </Button>
                <Button type="default" onClick={() => this.setState({matches: shuffle(matches)})}>
                    Shuffle
                </Button>
                {matches.map(({key, lineup}) => {
                    const currentPlayers = allPlayers.filter(({id}) => lineup.includes(id));
                    return (
                        <Row className="matches-row" key={key}>
                            <Col xs={10}>
                                {currentPlayers[0].name} - {currentPlayers[1].name}
                            </Col>
                            <Col className="versus" xs={4}>
                                VS
                            </Col>
                            <Col xs={10}>
                                {currentPlayers[2].name} - {currentPlayers[3].name}
                            </Col>
                        </Row>
                    )
                })}
            </div>
        )
    }

    renderMatches() {
        const {currentMatch, matches, allPlayers} = this.state;
        return (
            <Matches
                allPlayers={allPlayers}
                matches={matches.map(({lineup}) => lineup)}
                currentMatch={currentMatch}
                finishMatch={(team1Result, team2Result) => this.finishMatch(team1Result, team2Result)}
            />
        )
    }

    renderResult() {
        const {results} = this.state;
        return (
            <Table
                dataSource={results.map(x => ({
                    ...x,
                    key: x.id
                }))}
                columns={columns}
            />
        )
    }

    render() {
        const {step} = this.state;
        return (
            <div>
                <Steps current={step}>
                    <Steps.Step title="Select players" description="Participating players"/>
                    <Steps.Step title="Shuffle lineup" description="Setup matches"/>
                    <Steps.Step title="Play matches" description="The game is playing"/>
                    <Steps.Step title="Result" description="Check your results here"/>
                </Steps>
                <div className="steps-content">
                    {
                        (() => {
                            switch (step) {
                                case 0:
                                    return this.renderPlayerSelect();
                                case 1:
                                    return this.renderShuffle();
                                case 2:
                                    return this.renderMatches();
                                case 3:
                                    return this.renderResult();
                                default:
                                    throw new Error();
                            }
                        })()
                    }
                </div>
            </div>
        )
    }
}
