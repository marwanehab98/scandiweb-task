import { Form } from 'react-bootstrap';


function FurnitureComponent(props) {
    return (
        <>
            <Form.Group className="mb-3" controlId="length">
                <Form.Label>Length (CM)</Form.Label>
                <Form.Control
                    id='length'
                    required
                    // type='number'
                    // step={0.01}
                    className="productDataEntry numberEntry"
                    placeholder="Enter Length"
                    onChange={(e) => {
                        props.data({ ...props.data, ...{ "length": e.target.value } });
                    }}
                />
            </Form.Group>
            <Form.Group className="mb-3" controlId="width">
                <Form.Label>Width (CM)</Form.Label>
                <Form.Control
                    id='width'
                    required
                    // type='number'
                    // step={0.01}
                    className="productDataEntry numberEntry"
                    placeholder="Enter Width"
                    onChange={(e) => {
                        props.data({ ...props.data, ...{ "width": e.target.value } });
                    }}
                />
            </Form.Group>
            <Form.Group className="mb-3" controlId="height">
                <Form.Label>Height (CM)</Form.Label>
                <Form.Control
                    id='height'
                    required
                    // type='number'
                    // step={0.01}
                    className="productDataEntry numberEntry"
                    placeholder="Enter Height"
                    onChange={(e) => {
                        props.data({ ...props.data, ...{ "height": e.target.value } });
                    }}
                />
            </Form.Group>
        </>
    )
}

export default FurnitureComponent;
