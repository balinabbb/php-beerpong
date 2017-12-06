import React from 'react';
import { Table, Button, Modal, Input, Form } from 'antd';
import api from '../../api';

const columns = [
    {
        title: 'Azonosító',
        dataIndex: 'id',
        key: 'id',
    },
    {
        title: 'Név',
        dataIndex: 'name',
        key: 'name',
    },
    {
        title: 'Leírás',
        dataIndex: 'description',
        key: 'description',
    },
]

export default class extends React.Component {
    state = {
        items: [],
        modalVisible: false,
        name: '',
        description: '',
        specialization: null,
        sportId: null
    };

    nameInput = null
    descriptionInput = null

    fetchItems() {
        api.players.all()(({data: items}) => this.setState({ items }));
    }

    componentWillMount() {
        this.fetchItems();
    }

    closeModal() {
        this.setState({ modalVisible: false, specialization: null })
    }

    modalSaveClick() {
        const { name, description } = this.state;
        if (name === '') {
            this.nameInput.focus();
            return;
        } else if (description === '') {
            this.descriptionInput.focus();
            return;
        }
        api.players.save(name, description)(() =>
            this.setState({ name: '', description: '', modalVisible: false })
        );
    }

    getFormContent() {
        const { name, description } = this.state;
        return (
            <div>
                <Form.Item label="Név" help="A mező megadása kötelező" required>
                    <Input
                        value={name}
                        ref={e => this.nameInput = e}
                        onChange={e => this.setState({ name: e.target.value })} />
                </Form.Item>
                <Form.Item label="Leírás" help="A mező megadása kötelező" required>
                    <Input
                        value={description}
                        ref={e => this.descriptionInput = e}
                        onChange={e => this.setState({ description: e.target.value })} />
                </Form.Item>
            </div>
        )
    }

    didAddSpecialization(name, description) {
        const { specialization } = this.state;
        this.setState({
            specialization: [...specialization, {
                name,
                description,
                id: Math.max(...specialization.map(({ id }) => id)) + 1
            }]
        })
    }

    render() {
        const { items, modalVisible, specialization, sportId } = this.state;
        return (
            <div>
                <Button
                    icon="plus"
                    type="primary"
                    onClick={() => this.setState({ modalVisible: true })}
                    style={{ marginBottom: 20 }}>Új sport</Button>
                <Table
                    dataSource={items.map(x => ({ ...x, key: x.id }))}
                    columns={columns}
                    onRow={({ id, specialization }) => ({
                        onClick: () => this.setState({
                            specialization,
                            sportId: id,
                            modalVisible: true
                        }),
                        style: { cursor: 'pointer' }
                    })}
                />
                <Modal
                    visible={modalVisible}
                    title={specialization ? "Specializáció" : "Új sport"}
                    onCancel={() => this.closeModal()}
                    width={specialization ? '70%' : undefined}
                    footer={(
                        <Button
                            type="primary"
                            onClick={() => specialization ? this.closeModal() : this.modalSaveClick()}
                        >
                            {specialization ? "OK" : "Mentés"}
                        </Button>
                    )}
                >
                    {this.getFormContent()}
                </Modal>
            </div>
        )
    }
}