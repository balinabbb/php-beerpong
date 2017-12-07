import React from 'react';
import {Table, Button, Modal, Input, Form} from 'antd';
import api from '../../api';

const columns = [
    {
        title: 'Name',
        dataIndex: 'name',
        key: 'name',
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
        modalVisible: false,
        name: '',
    };

    nameInput = null;

    fetchData() {
        api.players.all()(({data}) => this.setState({data}));
    }

    componentWillMount() {
        this.fetchData();
    }

    modalSaveClick() {
        const {name} = this.state;
        if (name === '') {
            this.nameInput.focus();
            return;
        }
        api.players.save(name)(() =>
            this.setState({name: '', modalVisible: false}, () => this.fetchData())
        );
    }

    itemDeleteClick(id) {
        Modal.confirm({
            title: 'Confirm',
            content: 'Are you sure want to delete?',
            okText: 'Yes',
            cancelText: 'No',
            onOk: () => api.players.delete(id)(() =>
                this.fetchData()
            )
        })
    }

    getFormContent() {
        const {name} = this.state;
        return (
            <Form.Item label="Name" help="Name is required" required>
                <Input
                    value={name}
                    autoFocus={true}
                    onChange={e => this.setState({name: e.target.value})}
                    onPressEnter={() => this.modalSaveClick()}
                />
            </Form.Item>
        )
    }

    render() {
        const {data, modalVisible} = this.state;
        return (
            <div>
                <Button
                    icon="plus"
                    type="primary"
                    onClick={() => this.setState({modalVisible: true})}
                    style={{marginBottom: 20}}>New player</Button>
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
                <Modal
                    visible={modalVisible}
                    title="New player"
                    onCancel={() => this.setState({modalVisible: false})}
                    footer={(
                        <Button
                            type="primary"
                            onClick={() => this.modalSaveClick()}
                        >
                            Save
                        </Button>
                    )}
                >
                    {this.getFormContent()}
                </Modal>
            </div>
        )
    }
}