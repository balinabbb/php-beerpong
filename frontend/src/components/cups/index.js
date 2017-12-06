import React from 'react';
import {Table, Button, Modal} from 'antd';
import moment from 'moment';
import api from '../../api';

const columns = [
    {
        title: 'Date',
        dataIndex: 'date',
        key: 'date',
    },
    {
        title: 'Delete',
        dataIndex: 'delete',
        key: 'delete',
    }
];

export default class extends React.Component {
    state = {
        data: [],
    };

    fetchData() {
        api.cups.all()(({data}) => this.setState({data}));
    }

    componentWillMount() {
        this.fetchData();
    }

    newCupClick() {
        api.cups.save(moment().format('YYYY-MM-DD'))(() =>
            true//push navigation here
        );
    }

    itemDeleteClick(id) {
        Modal.confirm({
            title: 'Confirm',
            content: 'Are you sure want to delete?',
            okText: 'Yes',
            cancelText: 'No',
            onOk: () => api.cups.delete(id)(() =>
                this.fetchData()
            )
        })
    }

    render() {
        const {data} = this.state;
        return (
            <div>
                <Button
                    icon="plus"
                    type="primary"
                    onClick={() => this.newCupClick()}
                    style={{marginBottom: 20}}>Start new cup</Button>
                <Table
                    dataSource={data.map(x => ({
                        ...x,
                        key: x.id,
                        delete: (
                            <Button
                                type="danger"
                                icon="delete"
                                onClick={() => this.itemDeleteClick(x.id)}
                            >
                                Delete
                            </Button>
                        )
                    }))}
                    columns={columns}
                    onRow={({id, specialization}) => ({
                        style: {cursor: 'pointer'}
                    })}
                />
            </div>
        )
    }
}