import React from 'react';
import {Provider} from 'react-redux';
import {ConnectedRouter} from 'react-router-redux';
import {Route, Link} from "react-router-dom";
import {Layout, Menu, Icon} from 'antd';

import configureStore, {getHistory} from './store';
import Players from './components/players';
import Cups from './components/cups';
import Play from './components/cups/Play';

const Header = Layout.Header;
const Content = Layout.Content;

const store = configureStore();
const history = getHistory();

export default class extends React.Component {
    state = {
        current: 'players',
    };
    handleClick = (e) => {
        this.setState({
            current: e.key,
        });
    };

    render() {
        return (
            <Provider store={store}>
                <ConnectedRouter history={history}>
                    <Layout>
                        <Header style={{position: 'fixed', width: '100%'}}>
                            <Menu
                                onClick={this.handleClick}
                                selectedKeys={[this.state.current]}
                                mode="horizontal"
                                theme="dark"
                                style={{lineHeight: '64px'}}
                            >
                                <Menu.Item key="players">
                                    <Link to="/players"><Icon type="play-circle"/>Players</Link>
                                </Menu.Item>
                                <Menu.Item key="cups">
                                    <Link to="/cups"><Icon type="star"/>Cups</Link>
                                </Menu.Item>
                            </Menu>
                        </Header>
                        <Layout>
                            <Content style={{
                                padding: '50px',
                                marginTop: 64,
                                height: 'calc(100vh - 64px)',
                                overflowY: 'scroll'
                            }}>
                                <Route exact path="/players" component={Players}/>
                                <Route exact path="/cups" component={Cups}/>
                                <Route exact path="/cups/:id" component={Play}/>
                            </Content>
                        </Layout>
                    </Layout>
                </ConnectedRouter>
            </Provider>
        );
    }
}
