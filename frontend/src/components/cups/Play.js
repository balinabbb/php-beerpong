import React from 'react';
import {Steps, Select, Form, Button, Row, Col} from 'antd';
import api from '../../api';
import Match from './Match';

function subsets(input, size) {
    let results = [], result, mask, i, total = Math.pow(2, input.length);
    for (mask = size; mask < total; mask++) {
        result = [];
        i = input.length - 1;

        do {
            if ((mask & (1 << i)) !== 0) {
                result.push(input[i]);
            }
        } while (i--);

        if (result.length === size) {
            results.push(result);
        }
    }

    return results;
}

function subsetsLineups(subset) {
    return [
        [subset[0], subset[1], subset[2], subset[3]],
        [subset[0], subset[2], subset[1], subset[3]],
        [subset[0], subset[3], subset[1], subset[2]],
    ]
}

function shuffle(array) {
    let result = [...array];
    let currentIndex = result.length, temporaryValue, randomIndex;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        // And swap it with the current element.
        temporaryValue = result[currentIndex];
        result[currentIndex] = result[randomIndex];
        result[randomIndex] = temporaryValue;
    }

    return result;
}

export default class extends React.Component {
    state = {
        step: 0,
        allPlayers: [],
        selectedPlayers: [],
        matches: [],
        currentMatch: 0
    };

    fetchData() {
        api.players.all()(({data}) => this.setState({allPlayers: data, selectedPlayers: data.map(({id}) => id)})); //todo remove selectedplayers
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
            <Match
                allPlayers={allPlayers}
                match={matches[currentMatch].lineup}
            />
        )
    }

    render() {
        // const {match: {params: {id}}} = this.props;
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
