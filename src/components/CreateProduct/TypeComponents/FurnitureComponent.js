import { Form } from 'react-bootstrap';


function FurnitureComponent(props) {
    return (
        <>
            <Form.Group className="mb-3" controlId="Length">
                <Form.Label>Length (CM)</Form.Label>
                <Form.Control
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
            <Form.Group className="mb-3" controlId="Size">
                <Form.Label>Width (CM)</Form.Label>
                <Form.Control
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
            <Form.Group className="mb-3" controlId="Size">
                <Form.Label>Height (CM)</Form.Label>
                <Form.Control
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
