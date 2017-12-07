import React from 'react';
import {Table} from 'antd';
import api from '../../api';

const columns = [
    {
        title: 'Team 1',
        dataIndex: 'team1',
        key: 'team1'
    },
    {
        title: 'Team 2',
        dataIndex: 'team2',
        key: 'team2'
    },
];

export default class extends React.Component {
    state = {
        results: []
    };

    componentDidMount() {
        const id = this.props.id || this.props.match.params.id;
        api.cups.getResults(id)(({data}) => this.setState({results: data}))
    }

    render() {
        const {results} = this.state;

        const allMatches = results.map(({team1Player1, team1Player2, team1Score, team2Score, team2Player1, team2Player2}) => ({
            team1Score, team2Score,
            players: [
                team1Player1, team1Player2, team2Player1, team2Player2
            ]
        }));
        const allPlayers = [].concat.apply([], allMatches.map(({players}) => players))
            .filter((item, index, self) => self.indexOf(item) === index);

        const scores = allPlayers.map(playerName =>
            allMatches
                .map(({players, team1Score, team2Score}) => (
                    players.includes(playerName) ?
                        (team1Score === team2Score ? 1 : (
                            team1Score === 0 && players.slice(0, 2).includes(playerName) ? 3 : 0
                        )) :
                        0
                ))
                .reduce((a, b) => a + b, 0)
        );
        const playerResults = Object.assign({}, ...allPlayers.map((x, i) => ({[x]: scores[i]})));
        const finalScoreOrder = Object.keys(playerResults)
            .sort((a, b) =>
                playerResults[a] < playerResults[b] ?
                    1 :
                    (playerResults[a] > playerResults[b] ? -1 : 0)
            );
        return (
            <div>
                <h2>Final results:</h2>
                {
                    <Table
                        pagination={false}
                        columns={[
                            {
                                title: 'Position',
                                dataIndex: 'position',
                                key: 'position'
                            },
                            {
                                title: 'Name',
                                dataIndex: 'name',
                                key: 'name'
                            }, {
                                title: 'Score',
                                dataIndex: 'score',
                                key: 'score'
                            }]}
                        dataSource={finalScoreOrder.map((x,i) => ({
                            position: i+1,
                            key: x,
                            name: x,
                            score: playerResults[x]
                        }))}
                    />
                }
                <h2 style={{marginTop: 20}}>Matches:</h2>
                <Table
                    pagination={false}
                    columns={columns}
                    dataSource={results.map(({id, team1Score, team1Player1, team1Player2, team2Score, team2Player1, team2Player2}) => ({
                        key: id,
                        team1: (
                            <div>{team1Player1}-{team1Player2}-{team1Score}</div>
                        ),
                        team2: (
                            <div>{team2Player1}-{team2Player2}-{team2Score}</div>
                        ),
                    }))}
                />
            </div>
        )
    }
}